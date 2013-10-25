<?php

    class Manageusers_model extends CI_Model {

        function __construct()  {
            parent::__construct();
        }

        function getUsers() {
            $this->db->select('users.userid, users.login, persons.firstname, persons.lastname, usertypes.description');
            $this->db->from('persons');
            $this->db->join('users', 'persons.personid = users.personid');
            $this->db->join('usertypes', 'users.usertype = usertypes.usertype');
            $this->db->order_by('users.login', 'desc');
			
			
            $query = $this->db->get();

            if($query->num_rows() == 0)
                return false;

            $person = array();

            foreach($query->result() as $result)    {
                $person[$result->userid]['userid'] = $result->userid;
                $person[$result->userid]['login'] = $result->login;
                $person[$result->userid]['fullname'] = $result->firstname.' '.$result->lastname;
                $person[$result->userid]['usertype'] = $result->description;
            }

			// print_r($person	);
            return $person;
        }

        function makeAdmin($userid) {
            $data = array(
                'usertype' => 'A'
            );
            $this->db->where('userid', $userid);
            $this->db->update('users', $data);
        }

        function removeAdmin($userid) {
            $data = array(
                'usertype' => 'N'
            );
            $this->db->where('userid', $userid);
            $this->db->update('users', $data);
        }
    }