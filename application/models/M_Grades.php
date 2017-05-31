<?php

class M_Grades extends CI_Model{

	function __construct(){
		parent::__construct();
	}

	function get_grades_by_stdid($id){
		$query = $this->db->query('select * from gradestb where stdid = "'.$id.'" and sem_id = "'.$this->session->userdata('semest_id').'"');
		return $query->result();
	}

	function get_scores_by_subid($id){
		$query = $this->db->query('select * from gradestb where subid = "'.$id.'" and stdid = "'.$this->session->userdata('student_id').'" and sem_id = "'.$this->session->userdata('semest_id').'"');
		return $query->result();
	}


    function add_students_score($stdid, $pid, $subid, $attd, $quiz, $assign, $midsem, $exam, $total, $percent){
        $query = array ('attendance' => $attd, 'quiz' => $quiz, 'assignment' => $assign, 'mid_semester' => $midsem, 'exam' => $exam, 'total' => $total, 'percentage' => $percent);
        $this->db->where('stdid', $stdid);
        $this->db->where('progid', $pid);
        $this->db->where('subid', $subid);
        $this->db->where('sem_id', $this->session->userdata('semest_id'));
        $this->db->update('gradestb', $query);

    }

    function insert_into_gradestb($stdid, $pid, $subid, $semid){
    	$query = array ('stdid' => $stdid, 'progid' => $pid, 'subid' => $subid, 'sem_id' => $semid);
    	$this->db->insert('gradestb', $query);
    }

    function get_programs_by_semid($id){
    	//$this->db->distinct();
    	//$this->db->where('sem_id', $id);
		//$query = $this->db->get('gradestb');
    	$query = $this->db->query('select distinct progid from gradestb where sem_id = "'.$id.'"');
		return $query->result();
    }

    function get_semname_by_id($id){
    	$query = $this->db->query('select * from semestertb where semid = "'.$id.'"');
		return $query->result();
    }
}