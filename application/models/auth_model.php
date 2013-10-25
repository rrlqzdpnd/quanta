<?php

class Auth_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

	public function validate($username, $password){
        $this->db->select('salt')->from('users')->where('login', $username)->or_where('emailaddress', $username);
        $query = $this->db->get();

        if($query->num_rows == 0)
        	return false;

        foreach ($query->result() as $test)
        	$salt = $test->salt;

        $password = md5(md5($password).$salt);

        $this->db->select('userid')->from('users')->where('login', $username)->where('password', $password)->or_where('emailaddress', $username);
        $queryfx = $this->db->get();

        if($queryfx->num_rows() == 0)
            return false;

        foreach($queryfx->result() as $query)
			$userid = $query->userid;

		return $userid;
	}

	public function add_user($email, $username, $password, $firstname, $middlename, $lastname, $school){
		// BEGIN TRANSACTION
		$this->db->trans_begin();

		// First check: check if username is already in use
		$this->db->select('login')->from('users')->where('login', $username)->limit(1);
		$query = $this->db->get();

		if($query->num_rows() != 0)	{
			// username already used
			$this->db->trans_rollback();
			return false;
		}

		// Second check: check if email is already in use
		$this->db->select('emailaddress')->from('users')->where('emailaddress', $email)->limit(1);
		$query = $this->db->get();

		if($query->num_rows() != 0)	{
			// email already used
			$this->db->trans_rollback();
			return false;
		}

		// Insert into persons table
		$data = array(
			'lastname' => $lastname,
			'firstname' => $firstname,
			'middlename' => $middlename,
			'school' => $school
		);

		if(!$this->db->insert('persons', $data))	{
			// Something wrong happened in inserting person, rollback
			$this->db->trans_rollback();
			return false;
		}

		// Get personid
		$this->db->select('personid')->from('persons')->where('lastname', $lastname)->where('firstname', $firstname)->where('middlename', $middlename)->where('school', $school)->order_by('insertedon' ,'desc')->limit(1);
		$result = $this->db->get();
		foreach($result->result() as $res)
			$personid = $res->personid;

		// Insert into users table
		$data = array(
			'login' => $username,
			'emailaddress' => $email,
			'personid' => $personid,
			'password' => md5($password), // already included salt using trigger
			'usertype' => 'N'
		);

		if($this->db->insert('users', $data))	{
			// Success!
			$this->db->trans_commit();
			return true;
		}
		// Something went wrong with insertion
		$this->db->trans_rollback();
		return false;
	}

	public function getname_byuserid($userid)	{
		$this->db->select('lastname, firstname')->from('persons')->join('users', 'persons.personid = users.personid')->where('userid', $userid);
        $queryfx = $this->db->get();

        if($queryfx->num_rows() == 0)
            return false;

        foreach($queryfx->result() as $query){
             $firstname = $query->firstname;
             $lastname = $query->lastname;
        }

        return $firstname.' '.$lastname;
	}

	public function getusertype_byuserid($userid)	{
		$this->db->select('usertype')->from('users')->where('userid', $userid);
		$queryfx = $this->db->get();

        if($queryfx->num_rows() == 0)
            return false;

        foreach($queryfx->result() as $query)	{
             $usertype = $query->usertype;
        }

        if($usertype == 'A')
        	return 1;
		return 2;
	}
}
