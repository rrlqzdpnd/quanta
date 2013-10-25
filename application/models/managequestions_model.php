<?php

class ManageQuestions_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

	public function addSubject($subject, $description){
		$data = array(
			'subjectname' => $subject,
			'description' => $description
		);
		$this->db->insert('subjects', $data);
	}

    public function addSet($set){
        switch($set['initanswer'])
        {
            case 'choice1': $string = "0"; break;
            case 'choice2': $string = "1"; break;
            case 'choice3': $string = "2"; break;
            case 'choice4': $string = "3"; break;
            default: $string = "-1"; break;
        }

        // ADD SET
        $data = array(
            'setname' => $set['setname'],
            'subjectid' => $set['subId'],
            'answerstring' => $string,
            'description' => $set['description']

        );

        if(!$this->db->insert('sets', $data)) {
            return 'sets';
        }

        // ADD QUESTION
        $this->db->select('setid')->from('sets');
        $query = $this->db->get();

        $setids = array();
        foreach($query->result() as $v)
        {
            $setids[] = $v->setid;
        }

        $data = array(
            'setid' => max($setids),
            'question' => $set['initquestion']
        );


        if(!$this->db->insert('questions', $data)) {
            return 'questions';
        }

        // ADD CHOICES
        $this->db->select('questionid')->from('questions');
        $query = $this->db->get();

        $qids = array();
        foreach($query->result() as $v)
        {
            $qids[] = $v->questionid;
        }
        $qid = max($qids);

        for($i = 0; $i < 4; $i++)
        {
            $data = array(
                'questionid' => $qid,
                'choicetext' => $set['choices'][$i]
            );
            if(!$this->db->insert('choices', $data)) {
                return 'choices';
            }
        }

        return 'success';
    }
}
