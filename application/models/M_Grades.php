<?php

class M_Grades extends CI_Model{

	function __construct(){
		parent::__construct();
	}

	function get_grades_by_stdid($id){
		$query = $this->db->query('select * from gradestb where stdid = "'.$id.'"');
		return $query->result();
	}
}