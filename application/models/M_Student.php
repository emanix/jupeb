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
}