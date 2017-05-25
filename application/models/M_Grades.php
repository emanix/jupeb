<?php

class M_Grades extends CI_Model{

	function __construct(){
		parent::__construct();
	}

	function get_grades_by_stdid($id){
		$query = $this->db->query('select * from gradestb where stdid = "'.$id.'"');
		return $query->result();
	}

	function get_scores_by_subid($id){
		$query = $this->db->query('select * from gradestb where subid = "'.$id.'" and stdid = "'.$this->session->userdata('student_id').'"');
		return $query->result();
	}


    function add_students_score($stdid, $pid, $subid, $attd, $quiz, $assign, $midsem, $exam, $total, $percent){
        $query = array ('attendance' => $attd, 'quiz' => $quiz, 'assignment' => $assign, 'mid_semester' => $midsem, 'exam' => $exam, 'total' => $total, 'percentage' => $percent);
        $this->db->where('stdid', $stdid);
        $this->db->where('progid', $pid);
        $this->db->where('subid', $subid);
        $this->db->update('gradestb', $query);

    }

    function insert_into_gradestb($stdid, $pid, $subid){
    	$query = array ('stdid' => $stdid, 'progid' => $pid, 'subid' => $subid);
    	$this->db->insert('gradestb', $query);
    }
}