<?php

class Profile_model extends CI_Model {

	function __construct()  {
		parent::construct();
	}

	function getUser($userid)  {
		$this->db->select('persons.lastname, persons.firstname, persons.middlename, persons.school, users.login, usertypes.description, users.emailaddress');
		$this->db->from('persons');
		$this->db->join('users', 'persons.personid = users.userid')->join('usertypes', 'usertypes.usertype = users.usertype');
		$this->db->where('userid', $userid);

		$query = $this->db->get();

		if($query->num_rows() == 0)
			return false;

		$return = array();

		foreach($query->result() as $result)    {
			$return[$userid]['lastname'] = $result->lastname;
			$return[$userid]['firstname'] = $result->firstname;
			$return[$userid]['middlename'] = $result->middlename;
			$return[$userid]['school'] = $result->school;
			
			$return[$userid]['login'] = $result->login; 
			// NOTE: wag nang hayaang magpalit ng username ang user since delikado sa database conflicts.
			// Magbabago tayo ng schema para maaccomodate ang ganito

			$return[$userid]['usertype'] = $result->description;
			// NOTE: hindi rin pwedeng palitan ni (non-admin) user and kanyang usertype

			$return[$userid]['emailaddress'] = $result->emailaddress;
		}

		return $return;
	}

	function changePassword($userid, $newPass, $oldPass) {
		// NOTE: hiwalay ang pagpalit ng password since ito kailangan ng authentication kaysa sa iba na hindi
		$this->db->select('salt, password');
		$this->db->from('users');
		$this->db->where('userid', $userid);

		$query = $this->db->get();

		if($query->num_rows() == 0)
			return false;

		foreach($query->result() as $result)    {
			$salt = $result->salt;
			$password = $result->password;
		}

		if($password != md5(md5($oldPass).$salt))   // check muna kung tama yung password
			return false;

		// kung tama, same salt na lang
		$data = array(
			$password = md5(md5($newPass).$salt);
		);

		$this->db->where('userid', $userid);
		$this->db->update('users', $data);
	}

	function changeDetails($userid, $newFirst, $newMiddle, $newLast, $newEmail, $newSchool)  {
		// NOTE: hindi ko na kailangan yung old values since hindi naman kailangan ng authentication ng user kung 
		// magbabago sya ng pangalan. kung gusto nya maging BoXsZh LuvVVs 23, let him/her be. Pero ijjudge ko pa rin
		// sya lol

		$this->db->select('personid');
		$this->db->from('users');
		$this->db->where('userid', $userid);

		$query = $this->db->get();

		if($query->num_rows() == 0)
			return false;

		foreach($query->result() as $result)
			$personid = $result->personid;

		$data = array(
			$firstname = $newFirst;
			$middlename = $newMiddle;
			$lastname = $newLast;
			$emailaddress = $newEmail;
			$school = $newSchool;
		);  
		$this->db->where('personid', $personid);
		$this->db->update('persons', $data);
	}

    }