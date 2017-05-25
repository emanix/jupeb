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
		$this->session->set_userdata('proid', $id);
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
    	
		foreach ($subjects as $key => $value) {
			$sub_name = $this->M_Subjects->get_subject_by_id($value->sid);
			//print_r($sub_name);
			//die;
			foreach ($sub_name as $key => $value) {
				$incre = 1;
				$grade_table .= "<th>{$value->subject_name}</th>";
				$this->session->set_userdata('suid."'.$incre.'"', $value->subid);
				$incre++;
			}
		}
		//$grade_table .= "<th>View</th>";
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
		//$grade_table .= "<th>View</th>";
   		$grade_table .= "</tr>";
   		$grade_table .= "</tfoot>";
   		$grade_table .= "<tbody>";
   		
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
				if(count($grade) == 1){
					//$inc = 3;
					//print_r($this->session->userdata('suid."'.$inc.'"')); die;
					foreach ($grade as $key => $value) {
						//print_r($value->subid); die;
						//for($inc = 1; $inc <=3; $inc++){
						//if($value->subid == $this->session->userdata('suid."'.$inc.'"')){
							$grade_table .="<td>{$value->percentage}</td>";
							
							//$inc++;
						//}else{
						//	$grade_table .="<td>NG</td>";
						//	$inc++;
						//}
						//}
					}
					$grade_table .="<td>NG</td>";
					$grade_table .="<td>NG</td>";
				}else if(count($grade) == 2){
					foreach ($grade as $key => $value){

						$inc = 1;
						//if($this->session->userdata('suid."'.$inc.'"') == $value->subid){
							$grade_table .="<td>{$value->percentage}</td>";
							$inc++;
						//}
					}
					$grade_table .="<td>NG</td>";
				}else if(count($grade) == 3){
					foreach ($grade as $key => $value){
						$inc = 1;
						//if($this->session->userdata('suid."'.$inc.'"') == $value->subid){
							$grade_table .="<td>{$value->percentage}</td>";
							//$grade_table .="<td>NG</td>";
							$inc++;
						//}
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

	function add_students_grades($id){

		$this->session->set_userdata('student_id', $id);
		$student = $this->M_Student->get_student_by_id($id);
		$student_name = "";
		$grading_table = "";
		$incre = 1;
		foreach ($student as $key => $value) {
			$subjects = $this->M_Subjects->get_subject_pid($value->program_id);
			$this->session->set_userdata('studentna', $value->student_name);
			$student_name = $value->student_name;
			foreach ($subjects as $key => $value) {
				$sub_name = $this->M_Subjects->get_subject_by_id($value->sid);
				//$subid = $value->sid;
				foreach ($sub_name as $key => $value) {
					$grading_table .="<tr>";
					$grading_table .="<td>{$incre}</td>";
					$grading_table .= "<td>{$value->subject_name}</td>";
					//$this->session->set_userdata('suid."'.$incre.'"', $value->subid);
					$get_scores = $this->M_Grades->get_scores_by_subid($value->subid);
					//if($get_scores){
						foreach ($get_scores as $key => $value) {
							$grading_table .= "<td>{$value->attendance}</td>";
							$grading_table .= "<td>{$value->quiz}</td>";
							$grading_table .= "<td>{$value->assignment}</td>";
							$grading_table .= "<td>{$value->mid_semester}</td>";
							$grading_table .= "<td>{$value->exam}</td>";
							$grading_table .= "<td>{$value->total}</td>";
							$grading_table .= "<td>{$value->percentage}</td>";
							
						}
						//$incre++;
					//}//else{
						//for($i = 1; $i <= 7; $i++){
							//$grading_table .="<td>NG</td>";
						//}
					//}
					$grading_table .="<td><a href='".base_url()."Grades/input_students_scores/{$value->subid}'> <i class='material-icons'>Edit Grade</i></a></td>";
					
					$grading_table .="</tr>";
					$incre++;
				}
			}
		}

		$data['student_records'] = 'Students Management';
		$data['add_scores'] = "";
        $data['view_students'] = 'Add the scores of '.$student_name.' in each subject';
        $data['page_title'] = 'Manage Students Grades';
        $data['optional_description'] = 'View and Add scores for '.$student_name.'.';
        //$data['desc_students'] = 'Add current session';
        $data['scores_table'] = $grading_table;
        $data['scores_field'] = "";
        $data['content_view'] = 'Grades/students_scores_view';
        $this->templates->call_admin_template($data);
	}

	/*function add_student_scores($id){
		if($id){
			$this->session->set_userdata('subject_id', $id);
			$stdid = $this->session->userdata('student_id');
			redirect(base_url() . 'Grades/add_students_grading/'.$stdid.'');
		}
	}*/

	function input_students_scores($id){
		$sub_name = $this->M_Subjects->get_subject_by_id($id);
		$this->session->set_userdata('subject_id', $id);
		//$subname = "";
		foreach ($sub_name as $key => $value) {
			$this->session->set_userdata('subname', $value->subject_name);
		}

		$data['student_records'] = 'Students Management';
        $data['view_students'] = 'Add the scores of '.$this->session->userdata('studentna').' in each subject';
        $data['page_title'] = 'Manage Students Grades';
        $data['optional_description'] = 'Add scores for '.$this->session->userdata('studentna').'.';
        $data['add_scores'] = 'Add scores for '.$this->session->userdata('subname').'';
        $data['content_view'] = 'Grades/add_students_scores_view';
        $this->templates->call_admin_template($data);
	}

	/*function add_students_scores($id){
		$sub_name = $this->M_Subjects->get_subject_by_id($id);
		//$subname = "";
		foreach ($sub_name as $key => $value) {
			$this->move_data($value->subject_name);
		}
		$scores_field = "";
		//$scores_field .= "<section class='content'>";
		
		$scores_field .= "<div class='box-body'>";
		$scores_field .= "<div class='form-group'>";
		$scores_field .= "<label class='col-sm-3 control-label'>Attendance</label>";
		$scores_field .= "<div class='col-sm-9'>";
		$scores_field .= "<input  type='number' class='form-control' id='inputEmail3' name='attendance' value='0'>";
		$scores_field .= "</div>";
		$scores_field .= "</div>";
		$scores_field .= "<div class='form-group'>";
		$scores_field .= "<label class='col-sm-3 control-label'>Quiz</label>";
		$scores_field .= "<div class='col-sm-9'>";
		$scores_field .= "<input  type='number' class='form-control' id='inputEmail3' name='quiz' value='0'>";
		$scores_field .= "</div>";
		$scores_field .= "</div>";
		$scores_field .= "<div class='form-group'>";
		$scores_field .= "<label class='col-sm-3 control-label'>Assignment</label>";
		$scores_field .= "<div class='col-sm-9'>";
		$scores_field .= "<input  type='number' class='form-control' id='inputEmail3' name='assignment' value='0'>";
		$scores_field .= "</div>";
		$scores_field .= "</div>";
		$scores_field .= "<div class='form-group'>";
		$scores_field .= "<label class='col-sm-3 control-label'>Mid Semester</label>";
		$scores_field .= "<div class='col-sm-9'>";
		$scores_field .= "<input  type='number' class='form-control' id='inputEmail3' name='midsem' value='0'>";
		$scores_field .= "</div>";
		$scores_field .= "</div>";
		$scores_field .= "<div class='form-group'>";
		$scores_field .= "<label class='col-sm-3 control-label'>Exam</label>";
		$scores_field .= "<div class='col-sm-9'>";
		$scores_field .= "<input  type='number' class='form-control' id='inputEmail3' name='exam' value='0'>";
		$scores_field .= "</div>";
		$scores_field .= "</div>";
		$scores_field .= "</div>";
		$scores_field .= "<div class='box-footer'>";
		$scores_field .= "<button type='submit' class='btn btn-info pull-right'>Submit</button>";
		$scores_field .= "</div>";
		$scores_field .= "</form>";
		$scores_field .= "</div>";
		$scores_field .= "</div>";
		$scores_field .= "</div>";
		//$scores_field .= "</section>";

		return $scores_field;
	}


	function add_students_grading($id){

		$student = $this->M_Student->get_student_by_id($id);
		$student_name = "";
		$grading_table = "";
		$incre = 1;
		foreach ($student as $key => $value) {
			$subjects = $this->M_Subjects->get_subject_pid($value->program_id);
			$student_name = $value->student_name;
			foreach ($subjects as $key => $value) {
				$sub_name = $this->M_Subjects->get_subject_by_id($value->sid);
				//$subid = $value->sid;
				foreach ($sub_name as $key => $value) {
					$grading_table .="<tr>";
					$grading_table .="<td>{$incre}</td>";
					$grading_table .= "<td>{$value->subject_name}</td>";
					//$this->session->set_userdata('suid."'.$incre.'"', $value->subid);
					$get_scores = $this->M_Grades->get_scores_by_subid($value->subid);
					if($get_scores){
						foreach ($get_scores as $key => $value) {
							$grading_table .= "<td>{$value->attendance}</td>";
							$grading_table .= "<td>{$value->quiz}</td>";
							$grading_table .= "<td>{$value->assignment}</td>";
							$grading_table .= "<td>{$value->mid_semester}</td>";
							$grading_table .= "<td>{$value->exam}</td>";
							$grading_table .= "<td>{$value->total}</td>";
							$grading_table .= "<td>{$value->percentage}</td>";
							
						}
						//$incre++;
					}else{
						for($i = 1; $i <= 7; $i++){
							$grading_table .="<td>NG</td>";
						}
					}
					$grading_table .="<td><a href='".base_url()."Grades/add_students_scores/{$value->subid}'> <i class='material-icons'>Edit Grade</i></a></td>";
					$incre++;
					$grading_table .="</tr>";
				}
			}
		}

		$data['student_records'] = 'Students Management';
		//$data['add_program'] = 'Add Program';
        $data['view_students'] = 'Add the scores of '.$student_name.' in each subject';
        $data['page_title'] = 'Manage Students Grades';
        $data['optional_description'] = 'View and Add scores for '.$student_name.'.';
        $data['add_scores'] = $this->session->userdata('subname');
        $data['scores_table'] = $grading_table;
        $data['scores_field'] = $this->add_students_scores($this->session->userdata('subject_id'));
        $data['content_view'] = 'Grades/students_scores_view';
        $this->templates->call_admin_template($data);
	}*/

	function add_students_scores(){
		if ($this->input->post()){
			$total = $this->input->post('attendance') + $this->input->post('quiz') + $this->input->post('assignment') + $this->input->post('midsem') + $this->input->post('exam');
			$percent = ($total/100)*5;
			$stdid = $this->session->userdata('student_id');
			$pid = $this->session->userdata('proid');
			$subid = $this->session->userdata('subject_id');
			$attendance = $this->input->post('attendance');
			$quiz = $this->input->post('quiz');
			$assignment = $this->input->post('assignment');
			$midsem = $this->input->post('midsem');
			$exam = $this->input->post('exam');

			$this->M_Grades->add_students_score($stdid, $pid, $subid, $attendance, $quiz, $assignment, $midsem, $exam, $total, $percent);
			$this->session->set_flashdata('success', 'Students scores are successfully added');
		}
		redirect(base_url() . 'Grades/view_students_grades/'.$pid.'');
	}
}