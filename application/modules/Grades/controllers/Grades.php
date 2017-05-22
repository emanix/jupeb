<?php

class Grades extends MY_Controller{
	
	function __construct(){

		parent::__construct();
		$this->load->model('M_Programs');
		$this->load->module('Templates');
	}

	function manage_grades(){

		$data['student_records'] = 'Students Management';
		//$data['add_program'] = 'Add Program';
        $data['view_program'] = 'List of available Programs';
        $data['page_title'] = 'Manage Students Grades';
        $data['optional_description'] = 'Grade students of each program';
        //$data['desc_students'] = 'Add current session';
        $data['programs_table'] = $this->create_programs_table();
        $data['content_view'] = 'Grades/students_grading_view';
        $this->templates->call_admin_template($data);
	}

	function create_programs_table(){
		
		$programs = $this->M_Programs->get_programs();

		$programs_table = "";

		if (count($programs)>0){
			$incrementer = 1;
			foreach ($programs as $key => $value) {
				$programs_table .="<tr>";
				$programs_table .="<td>{$incrementer}</td>";
				$programs_table .="<td>{$value->program_name}</td>";
				$programs_table .="<td><a href='".base_url()."Grades/add_students_grades/{$value->pid}'> <i class='material-icons'>View Students</i></a></td>";
				$incrementer++;
			}
			return $programs_table;
		}
	}

	function add_students_grades($id){
		echo "Inside student grading for $id";
	}
}