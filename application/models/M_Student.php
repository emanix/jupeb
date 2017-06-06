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

    function get_student_by_id($stdid){
        $query = $this->db->query('select * from studenttb where stdid = "'.$stdid.'" ');
        return $query->result();
    }

    function get_student_by_matric($matric){
        $query = $this->db->query('select * from studenttb where matric_no = "'.$matric.'" ');
        return $query->result();
    }

    function get_student_by_program($pid){
        $query = $this->db->query('select * from studenttb where Program_id = "'.$pid.'" ');
        return $query->result();
    }

    function get_student_by_programs($pid, $sesid){
        //$query = $this->db->query('select * from studenttb where Program_id = "'.$pid.'" ');
        $this->db->distinct();
        $this->db->from('studenttb');
        //$this->db->join('gradestb', 'gradestb.sem_id = "'.$this->session->userdata('semest_id').'"');
        $this->db->where('Program_id', $pid);
        $this->db->where('session_id', $sesid);
        $this->db->order_by('studenttb.student_name');
        $query = $this->db->get();
        return $query->result();
    }

    function get_program_name($pid){
        $query = $this->db->query('select program_name from programtb where pid = "'.$pid.'" ');
        return $query->result();
    }

    function update_student_record(){

        $this->db->set('student_name', $this->input->post($this->session->userdata('studentname'), TRUE));
        $this->db->set('matric_no', $this->input->post($this->session->userdata('matricno'), TRUE));
        $this->db->set('session_id', $this->input->post('sid'));
        $this->db->set('program_id', $this->input->post('pid'));
        $this->db->where('stdid', $this->session->userdata('std_id'));
        
        return $this->db->update('studenttb');
        
    }

    function get_student_by_name($stdname){
        $query = $this->db->query('select * from studenttb where student_name = "'.$stdname.'" ');
        return $query->result();
    }

    function get_acc_students(){
        $query = $this->db->query('select * from studenttb where program_id = 1');
        return $query->result();
    }

    function get_agric_students(){
        $query = $this->db->query('select * from studenttb where program_id = 8');
        return $query->result();
    }

    function get_anatomy_students(){
        $query = $this->db->query('select * from studenttb where program_id = 6');
        return $query->result();
    }

    function get_compsc_students(){
        $query = $this->db->query('select * from studenttb where program_id = 7');
        return $query->result();
    }
}