<?php

class Practice_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('Questions_model');
    }

	public function getSubjects(){
		$this->db->select('categoryid, description')->from('categories');

		$test = $this->db->get();

		foreach($test->result() as $result)	{
			$subjects[$result->categoryid]['categoryid'] = $result->categoryid;
			$subjects[$result->categoryid]['subject'] = $result->description;
		}

		return $subjects;
	}


	public function getSubjectSets(){
		$this->db->select('questionsetid, categoryid, setno')->from('questionsets');

		$sets = $this->db->get();

		foreach($sets->result() as $result)	{
			$sets[$result->categoryid][$result->questionsetid]['setname'] = 'Set '.$result->setno;
			$sets[$result->categoryid][$result->questionsetid]['setid'] = $result->questionsetid;
		}

		return $sets;
	}

	public function savePercent($userid, $percentCorrect){

	}

	public function getCorrectAnswers($setid) {
		//Dummy data
		switch ($setid){
			case 1:
				$correctAnswerString = '002';
				break;
			case 2:
				$correctAnswerString = '20';
				break;
			case 3:
				$correctAnswerString = '000';
				break;
			case 4:
				$correctAnswerString = '3';
				break;
			case 5:
				$correctAnswerString = '003';
				break;
			case 6:
				$correctAnswerString = '33';
				break;
			case 7:
				$correctAnswerString = '13';
				break;
			case 8:
				$correctAnswerString = '33';
				break;
			case 9:
				$correctAnswerString = '113';
				break;
			case 10:
				$correctAnswerString = '123';
				break;
			case 11:
				$correctAnswerString = '123';
				break;
			case 12:
				$correctAnswerString = '123';
				break;
			case 13:
				$correctAnswerString = '123';
				break;
			case 14:
				$correctAnswerString = '123';
				break;
			case 15:
				$correctAnswerString = '123';
				break;

			default:
				//No setid found.
				return false;
		}

		return $correctAnswerString;
	}

	public function getExam($setid){
		$this->db->select('questionid')->from('questionsets')->where('questionsetid', $setid);

		$resultset = $this->db->get();

		if($resultset->num_rows() < 1)
			return false;

		foreach($resultset->result() as $result)	{
			$this->db->select('question')->from('questions')->where('questionid', $result->questionid);

			$question = $this->db->get();

			foreach($question->result() as $q)
				$exams[$result->questionid]['question'] = $q->question;

			$this->db->select('choices.choiceid, choices.choicetext')->from('choices')->join('questionchoices', 'questionchoices.choiceid = choices.choiceid')->where('questionid', $result->questionid);

			$choices = $this->db->get();

			foreach($choices->result() as $c)
				$exams[$result->questionid]['choices'][$c->choiceid] = $choicetext;
		}

		return $exams;
	}
}
