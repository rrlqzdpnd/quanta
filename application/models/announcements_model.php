<?php

class Announcements_model extends CI_Model {

    function __construct() {
		
        parent::__construct();
    }

    public function add($title, $announcement, $userid)
    {
        $announcement = strip_tags($announcement);

        $data = array(
            'title' => $title,
            'body' => $announcement,
            'insertedby' => $userid
        );

        if(!$this->db->insert('announcements', $data))
            // Something wrong happened during insertion
            return false;
        return true;
    }

    public function get_admin()
    {
        $this->db->select()->from('announcements');
        return $this->_get();
    }

    public function get_user()
    {
        $this->db->select()->from('announcements')->where('isactive', 'true');
        return $this->_get();
    }

    private function _get()
    {
        $this->db->order_by("announcementid", "asc");
        $queryfx = $this->db->get();

        $announcements = array();

        if($queryfx->num_rows() == 0){
            return false;
        }

        foreach($queryfx->result() as $query)
        {
            $announcements[$query->announcementid]['tag'] = $query->announcementid.",".$query->isactive;
            $announcements[$query->announcementid]['title'] = $query->title;
            $announcements[$query->announcementid]['message'] = $query->body;
            $announcements[$query->announcementid]['date'] = date("m/d/Y", strtotime($query->insertedon));

            $this->db->select()->from('users')->where('userid', $query->insertedby);
			$result = $this->db->get()->result();
			// print_r($result); die();
			// echo $result[0]->login; die();
            $announcements[$query->announcementid]['poster'] = $result[0]->login; //there should only be one
        }

        return $announcements;
    }

    public function set($id, $active = 'false')
    {
        if(!$this->db->update('announcements', array('isactive' => $active), array('announcementid' => $id))){
            return false;
        }
        return true;
    }
}
