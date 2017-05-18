<?php

class M_Subjects extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_subjects(){
    	$query = $this->db->query('select * from subjecttb');
    	return $query->result();
    }

    function get_subject_by_id($subid){
        $query = $this->db->query('select * from subjecttb where subid = "'.$subid.'" ');
        return $query->result();
    }

    function add_subjects($name){
    	$query = array ('subject_name' => $name);
    	$this->db->insert('subjecttb', $query);

    }

    function subject_update(){
    	
        $this->db->set('subject_name', $this->input->post($this->session->userdata('subid'), TRUE));
        
        $this->db->where('subject_name', $this->session->userdata('subjectname'));
        
        return $this->db->update('subjecttb');
        
    }
}