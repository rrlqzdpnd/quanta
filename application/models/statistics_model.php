<?php

class Statistics_model extends CI_Model {

	function __construct()  {
		parent::__construct();
	}

	public function getTestScores($userid){
		$this->load->helper('date');
		$scores = array();
		$this->db->select('subjectid,subjectname')->from('subjects');
	
		$cats = $this->db->get();
		$j = 0;
		foreach($cats->result() as $cat){
			$catid = $cat->subjectid;
			$scores[$j]["subject"] = $cat->subjectname;
			$this->db->select('score,timefinished')->from('userhistories')->join('sets','userhistories.setid=sets.setid')->where("userid",$userid)->where("subjectid",$catid);
			$query = $this->db->get();				
			if($query->num_rows() == 0)
				$scores[$j] = null;
			else{
				$i = 0;
				foreach($query->result() as $q){
					$scores[$j][$i]['score'] = $q->score;
					$timestamp = mysql_to_unix($q->timefinished);
					$scores[$j][$i]['timefinished'] = mdate("%m/%d %h%a",$timestamp);
					//$scores[$j][$i]['setid'] = $q->setid;
					$i++;
				}
				$scores[$j]['size'] = $i;
			}
			$j++;
		}
		$scores['size'] = $j;
		return $scores;
	
	}
}
