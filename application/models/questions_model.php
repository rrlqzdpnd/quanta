<?php

class Questions_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function get($type)    {
        $this->db->select()->from('categories')->where('category',$type);

        $cats = $this->db->get();

        foreach($cats->result() as $c)
            $cat = $c->categoryid;

        $this->db->select('questions.questionid,question')->from('questiongroups');
        $this->db->join('questions','questions.questionid = questiongroups.questionid')->where('categoryid',$cat);

        $queries = $this->db->get();

        if($queries->num_rows() == 0)
            return false;

        $questions = array();

        foreach($queries->result() as $query){
            $questions[$query->questionid]['question'] = $query->question;
            $this->db->select('choices.choiceid, choicetext')->from('choices');
            $this->db->join('questionchoices','questionchoices.choiceid = choices.choiceid')->where('questionid',$query->questionid);

            $choices = $this->db->get();
            $qchoices = array();
            foreach($choices->result() as $choice){
                $qchoices[$choice->choiceid]['text'] = $choice->choicetext;
            }
            $questions[$query->questionid]['choices'] = $qchoices;
        }

        return $questions;
    }

}
