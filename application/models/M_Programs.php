<?php

class M_Programs extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_programs(){
    	$query = $this->db->query('select * from programtb order by program_name ASC');
    	return $query->result();
    }

    function get_program_by_id($pid){
        $query = $this->db->query('select * from programtb where pid = "'.$pid.'" ');
        return $query->result();
    }

    function add_programs($name){
    	$query = array ('program_name' => $name);
    	$this->db->insert('programtb', $query);

    }

    function program_update(){
    	
        $this->db->set('program_name', $this->input->post($this->session->userdata('pid'), TRUE));
        
        $this->db->where('program_name', $this->session->userdata('programname'));
        
        return $this->db->update('programtb');
        
    }
}