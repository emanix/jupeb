<?php

class M_Reporting extends CI_Model{

	function __construct(){
		parent:: __construct();
		
	}

	function get_semesters(){
        $query = $this->db->query('select * from semestertb');
        return $query->result();
    }

    function get_subjects(){
        $query = $this->db->query('select * from subjecttb order by subject_name ASC');
        return $query->result();
    }

    function get_semester_by_id(){
        $query = $this->db->query('select * from semestertb where semid = "'.$this->input->post('semid', TRUE).'"');
        return $query->result();
    }

    function get_subject_by_id(){
        $query = $this->db->query('select * from subjecttb where subid = "'.$this->input->post('subid', TRUE).'"');
        return $query->result();
    }

    function get_program_by_id(){
        $query = $this->db->query('select * from programtb where pid = "'.$this->input->post('progid', TRUE).'"');
        return $query->result();
    }

    function get_scores(){
    	$this->db->select('*');
        $this->db->from('gradestb');
        $this->db->join('studenttb', 'studenttb.stdid = gradestb.stdid');
        $this->db->where('subid', $this->input->post('subid', TRUE));
        $this->db->where('sem_id', $this->input->post('semid', TRUE));
        $this->db->order_by('studenttb.student_name');
        $query = $this->db->get();
        //$query = $this->db->query('select * from gradestb where subid = "'.$this->input->post('subid', TRUE).'" and sem_id = "'.$this->input->post('semid', TRUE).'"');
        return $query->result();
    }

    function get_grades(){
        $this->db->select('*');
        $this->db->from('gradestb');
        $this->db->join('studenttb', 'studenttb.stdid = gradestb.stdid');
        $this->db->where('progid', $this->input->post('progid', TRUE));
        $this->db->where('sem_id', $this->input->post('semid', TRUE));
        $this->db->order_by('studenttb.student_name');
        $query = $this->db->get();
        //$query = $this->db->query('select * from gradestb where subid = "'.$this->input->post('subid', TRUE).'" and sem_id = "'.$this->input->post('semid', TRUE).'"');
        return $query->result();
    }
}