<?php

class Practice_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('Questions_model');
    }

    public function getSubjects(){
        //Dummy data
        $this->db->select()->from('subjects');
        $this->db->order_by("subjectid", "asc");
        $queryfx = $this->db->get();

        if($queryfx->num_rows() == 0)
            return false;

        foreach($queryfx->result() as $query){
            $subjects[$query->subjectid]['name'] = $query->subjectname;
            $subjects[$query->subjectid]['icon'] = $this->getIcon($query->subjectname);
            $subjects[$query->subjectid]['desc'] = $query->description;
            $subjects[$query->subjectid]['sets'] = $this->getSubjectSets($query->subjectid);
        }

        return $subjects;
    }

    public function getExam($setid)
    {
        $this->db->select('questionid, question')->from('questions')->where('setid', $setid);
        $queryfx = $this->db->get();

        if($queryfx->num_rows() == 0)
            return false;

        foreach($queryfx->result() as $i => $query){
            $questions[$i]['qid'] = $query->questionid;
            $questions[$i]['question'] = $query->question;
            $questions[$i]['choices'] = $this->getChoices($query->questionid);
        }

        return $questions;
    }

    private function getIcon($subjectName){
        switch($subjectName)
        {
            case "Math": return "icon-superscript";
            case "Science": return "icon-beaker";
            case "English": return "icon-font";
            case "History": return "icon-time";
            case "Geography": return "icon-globe";
            default: return "icon-puzzle-piece";
        }
    }

    public function getSubjectSets($subjectid){
        $this->db->select('setid, setname')->from('sets')->where('subjectid', $subjectid);
        $queryfx = $this->db->get();

        if($queryfx->num_rows() == 0)
            return false;

        foreach($queryfx->result() as $query)
            $sets[$query->setid] = $query->setname;

        return $sets;
    }

    private function getChoices($questionid){
        $this->db->select('choiceid, choicetext')->from('choices')->where('questionid', $questionid);
        $queryfx = $this->db->get();

        if($queryfx->num_rows() == 0)
            return false;

        $i = 0;
        foreach($queryfx->result() as $query){
            // $choices[$query->choiceid] = $query->choicetext;
            $choices[$i] = $query->choicetext;
            $i++;
        }

        return $choices;
    }
    public function saveHistory ($userid, $percentCorrect, $userAnswers, $setid, $currenttime, $prevtime)
    {
        $this->load->helper('date');
        $this->db->select_max('userhistoryid')->from('userhistories');
        $newId = $this->db->get();
        if($newId->num_rows() == 0)
            $newId = 1;
        else{
			$result = $newId->result();
            $newId = $result[0]->userhistoryid + 1;
		}
        $data = array(
            'userid' => $userid,
            'timefinished' => date('Y-m-d H:i:s',$currenttime),
            'timestarted' => date('Y-m-d H:i:s',$prevtime),
            'score' => $percentCorrect,
            'setid' => $setid,
            'userhistoryid' => $newId,
            'answerstring' => $userAnswers
        );
        if(!$this->db->insert('userhistories', $data))
            return false;
        return true;
	}

    public function getCorrectAnswers($setid) {
        $this->db->select('answerstring')->from('sets')->where('setid', $setid);

        $queryfx = $this->db->get();

        if($queryfx->num_rows() == 0)
            return false;

        $results = $queryfx->result();

        return $results[0]->answerstring;
    }

    public function getCorrectAnswer($setid, $qid) {
        $this->db->select('questionid')->from('questions')->where('setid', $setid);
        $queryfx = $this->db->get();

        if($queryfx->num_rows() == 0)
            return false;

        $qids = $queryfx->result();
        $answer = $this->getCorrectAnswers($setid);

        foreach($qids as $k => $v) {
            if($qid == $v->questionid)
                return $answer[$v->questionid-1];
        }

        return "-1"; // THIS SHOULD NOT HAPPEN!!!
    }

}
