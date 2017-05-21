<?php

class M_Student extends CI_Model{

	function __construct()
    {
        parent::__construct();
    }

    function get_students(){
        $this->db->select('stdid');
        $this->db->from('studenttb');
        $query = $this->db->get();

        return $query->result();
    }

    function get_session_details(){
        $query = $this->db->query('select * from sessiontb');
        return $query->result();
    }

    function get_program(){
        $query = $this->db->query('select * from programtb');
        return $query->result();
    }

    function add_students($matric, $stdname, $sid, $pid){
        $query = array ('matric_no' => $matric, 'student_name' => $stdname, 'session_id' => $sid, 'program_id' => $pid);
        $this->db->insert('studenttb', $query);

    }
}