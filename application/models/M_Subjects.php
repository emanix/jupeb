<?php

class M_Subjects extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_subjects(){
    	$query = $this->db->query('select * from subjecttb order by subject_name ASC');
    	return $query->result();
    }

    function get_subject_by_id($subid){
        $query = $this->db->query('select * from subjecttb where subid = "'.$subid.'" ');
        return $query->result();
    }

    function get_subject_pid($pid){
        $query = $this->db->query('select * from subject_combtb where pid = "'.$pid.'"');
        
        return $query->result();
    }

    function get_subject_pidsid($pid, $sid){
        $query = $this->db->query('select * from subject_combtb where pid = "'.$pid.'" and sid = "'.$sid.'"');
        
        return $query->result();
    }

    function add_subjects($name){
    	$query = array ('subject_name' => $name);
    	$this->db->insert('subjecttb', $query);

    }

    function add_subject_combination($pid, $subid){
        $query = array ('pid' => $pid, 'sid' => $subid);
        $this->db->insert('subject_combtb', $query);

    }

    function subject_update(){
    	
        $this->db->set('subject_name', $this->input->post($this->session->userdata('subid'), TRUE));
        
        $this->db->where('subject_name', $this->session->userdata('subjectname'));
        
        return $this->db->update('subjecttb');
        
    }

    function delete_subject($pid, $subid){
        $this->db->where('pid', $pid);
        $this->db->where('sid', $subid);
        $this->db->delete('subject_combtb');
    }
}