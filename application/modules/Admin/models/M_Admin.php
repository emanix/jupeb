<?php

class M_Admin extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_session(){
    	$query = $this->db->query('select * from sessiontb');
    	return $query->result();
    }

    function add_sessions($name){
    	$query = array ('session_name' => $name);
    	$this->db->insert('sessiontb', $query);

    }

    function add_semester($name){
    	$query = array ('semester_name' => $name);
    	$this->db->insert('semestertb', $query);

    }

    function get_session_by_id($sid){
        $query = $this->db->query('select * from sessiontb where sid = "'.$sid.'" ');
        return $query->result();
    }

    function session_update(){

        $this->db->set('session_name', $this->input->post($this->session->userdata('sessionname'), TRUE));
        $this->db->where('session_name', $this->session->userdata('sessionname'));
        
        return $this->db->update('sessiontb');
        
    }

     function semester_update($name, $data){

        $this->db->set('semester_name', $name);
        $this->db->where('semester_name', $data);
        
        return $this->db->update('semestertb');
        
    }
}