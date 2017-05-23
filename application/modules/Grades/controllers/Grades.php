<?php

class Grades extends MY_Controller{
	
	function __construct(){

		parent::__construct();
		$this->load->model(['M_Programs', 'M_Subjects', 'M_Student', 'M_Grades']);
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
				$programs_table .="<td><a href='".base_url()."Grades/view_students_grades/{$value->pid}'> <i class='material-icons'>View Students</i></a></td>";
				$incrementer++;
			}
			return $programs_table;
		}
	}

	function view_students_grades($id){
		//Get program name.
		$program = $this->M_Programs->get_program_by_id($id);
		$program_name = "";

		foreach ($program as $key => $value) {
			$program_name = $value->program_name;
		}

		$grade_table = "";
		$subjects = $this->M_Subjects->get_subject_pid($id);
		$subject_name = "";
		$grade_table .= "<table id='example2' class='table table-bordered table-striped'>";
    	$grade_table .= "<thead>";
    	$grade_table .= "<tr>";
    	$grade_table .= "<th>Serial No</th>";
   		$grade_table .= "<th>Student Name</th>";
    	$incre = 1;
		foreach ($subjects as $key => $value) {
			$sub_name = $this->M_Subjects->get_subject_by_id($value->sid);
			//print_r($sub_name);
			//die;
			foreach ($sub_name as $key => $value) {
				$grade_table .= "<th>{$value->subject_name}</th>";
				$this->session->set_userdata('suid."'.$incre.'"', $value->subid);
				$incre++;
			}
		}
		$grade_table .= "<th>View</th>";
		$grade_table .= "</tr>";
   		$grade_table .= "</thead>";
   		$grade_table .= "<tfoot>";
   		$grade_table .= "<tr>";
   		$grade_table .= "<th>Serial No</th>";
   		$grade_table .= "<th>Student Name</th>";

   		foreach ($subjects as $key => $value) {
			$sub_name = $this->M_Subjects->get_subject_by_id($value->sid);

			foreach ($sub_name as $key => $value) {
				$grade_table .= "<th>{$value->subject_name}</th>";
			}
		}
		$grade_table .= "<th>View</th>";
   		$grade_table .= "</tr>";
   		$grade_table .= "</tfoot>";
   		$grade_table .= "<tbody>";
   		$inc = 1;
   		$counter = 1;
   		$student = $this->M_Student->get_student_by_program($id);
   		//Check if there are registered students for the program.
   		if(count($student) > 0){
	   		foreach ($student as $key => $value) {
	    		$grade_table .="<tr>";
				$grade_table .="<td>{$counter}</td>";
				$grade_table .="<td>{$value->student_name}</td>";
				$grade = $this->M_Grades->get_grades_by_stdid($value->stdid);
				//Checks if students have been graded.
				if($grade){
					foreach ($grade as $key => $value) {
						if(count($value->subid) > 0){
							if($this->session->userdata('suid."'.$inc.'"') == $value->subid){
								$grade_table .="<td>{$value->percentage}</td>";
								$inc++;
							}else{
								$grade_table .="<td>NG</td>";
								$inc++;
							}
						}
					}
				}else{
					for($i = 1; $i <= 3; $i++){
						$grade_table .="<td>NG</td>";
					}	
				}
				$grade_table .="<td><a href='".base_url()."Grades/add_students_grades/{$value->stdid}'> <i class='material-icons'>View</i></a></td>";
				$counter++;
			}
		}else{
			$grade_table .="<td colspan='3'><center><h4>There are no registered students for this course.</h4></center></td>";
		}
		$grade_table .= "</tr>";
   		$grade_table .= "</tbody>";
   		$grade_table .= "</table>";

		$data['student_records'] = 'Students Management';
		//$data['add_program'] = 'Add Program';
        $data['view_students'] = 'List of '.$program_name.' Students';
        $data['page_title'] = 'Manage Students Grades';
        $data['optional_description'] = 'Grade each students in '.$program_name.'';
        //$data['desc_students'] = 'Add current session';
        $data['grading_table'] = $grade_table;
        $data['content_view'] = 'Grades/grade_students_view';
        $this->templates->call_admin_template($data);
	}
}