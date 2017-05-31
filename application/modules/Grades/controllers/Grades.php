<?php

class Grades extends MY_Controller{
	
	function __construct(){

		parent::__construct();
		$this->load->model(['M_Programs', 'M_Subjects', 'M_Student', 'M_Grades', 'M_Admin']);
		$this->load->module('Templates');
	}

	function manage_grades(){

		$data['student_records'] = 'Students Management';
		//$data['add_program'] = 'Add Program';
        $data['view_program'] = 'List of available Programs';
        $data['page_title'] = 'Manage Students Grades';
        $data['optional_description'] = 'Grade students of each program';
        //$data['desc_students'] = 'Add current session';
        $data['sessions'] = $this->session_select();
        $data['semester_table'] = "";
        $data['content_view'] = 'Grades/grading_view';
        $this->templates->call_admin_template($data);
	}

	function manage_grade(){

		$data['student_records'] = 'Students Management';
		//$data['add_program'] = 'Add Program';
        $data['view_program'] = 'Semester View';
        $data['page_title'] = 'Manage Students Grades';
        $data['optional_description'] = 'Grade students of each program';
        //$data['desc_students'] = 'Add current session';
        $data['sessions'] = $this->session_select();
        $data['semester_table'] = $this->session_selected();
        $data['content_view'] = 'Grades/grading_view';
        $this->templates->call_admin_template($data);
	}

	function session_selected(){
		if($this->input->post()){
			$sessionname = $this->M_Admin->get_session_by_id($this->input->post('sesid'));
			$semester_table = "";

			foreach ($sessionname as $key => $session) {
	            $sesname=$session->session_name;
	            
	            for($counter = 1; $counter <= 2; $counter++){
	              $semester = $this->M_Admin->get_semester_by_name("$sesname.$counter");
	              foreach ($semester as $key => $sem) {
	                $semester_table .= "<tr>"; 
	                $semester_table .= "<td>$counter</td>";
	                $semester_table .= "<td>{$sem->semester_name}</td>";
	                $semester_table .= "<td><a href='".base_url()."Grades/semester_select/{$sem->semid}'> <i class='material-icons'>Show Programs</i></a></td>";
	              } 
	            }
            }
		}
		return $semester_table;
	}

	function semester_select($id){
		$this->session->set_userdata('semest_id', $id);
		$programsid = $this->M_Grades->get_programs_by_semid($id);
		$programs = "";
		$semname = $this->M_Grades->get_semname_by_id($id);
		foreach ($semname as $key => $value) {
			$semestername = $value->semester_name;
			$this->session->set_userdata('semest_name', $semestername);
		}
		$programs_table = "";
		foreach ($programsid as $key => $pid) {
			//$incrementer = 1;
			$programs = $this->M_Programs->get_program_by_id($pid->progid);
			
			if (count($programs)>0){
				
				foreach ($programs as $key => $value) {
					$programs_table .="<tr>";
					//$programs_table .="<td>$incrementer</td>";
					$programs_table .="<td>{$value->program_name}</td>";
					$programs_table .="<td><a href='".base_url()."Grades/view_students_grades/{$value->pid}'> <i class='material-icons'>View Students</i></a></td>";
					//$incrementer++;
				}
			}
			//$incrementer++;
			$programs_table .="</tr>";
		}

		$data['student_records'] = 'Students Management';
		//$data['add_program'] = 'Add Program';
        $data['view_program'] = 'List of Programs ('.$semestername.')';
        $data['page_title'] = 'Manage Students Grades';
        $data['optional_description'] = 'Grade students of each program';
        //$data['desc_students'] = 'Add current session';
        $data['programs_table'] = $programs_table;
        $data['content_view'] = 'Grades/students_grading_view';
        $this->templates->call_admin_template($data);
	}

	function session_select(){

        $sessions = $this->M_Student->get_session_details();
        $options = "";
        if (count($sessions)){
            foreach ($sessions as $key => $value){
                $options .= "<option value = '{$value->sid}'>{$value->session_name}</option>";
            }
        }
        return $options;
    }

	/*function create_programs_table(){
		
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
	}*/

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
			
			foreach ($sub_name as $key => $value) {
				$grade_table .= "<th>{$value->subject_name}</th>";
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
				if(($grade)){
					foreach ($grade as $key => $value) {
						if ($value->percentage > 0){
							$grade_table .="<td>{$value->percentage}</td>";
						}else{
							$grade_table .="<td>NG</td>";
						}
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
        $data['view_students'] = 'List of '.$program_name.' Students ('.$this->session->userdata('semest_name').')';
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
					
					$get_scores = $this->M_Grades->get_scores_by_subid($value->subid);
						foreach ($get_scores as $key => $value) {
							if($value->attendance == 0){
								$grading_table .= "<td>NG</td>";
							}else{
								$grading_table .= "<td>{$value->attendance}</td>";
							}
							if($value->quiz == 0){
								$grading_table .= "<td>NG</td>";
							}else{
								$grading_table .= "<td>{$value->quiz}</td>";
							}
							if($value->assignment == 0){
								$grading_table .= "<td>NG</td>";
							}else{
								$grading_table .= "<td>{$value->assignment}</td>";
							}
							if($value->mid_semester == 0){
								$grading_table .= "<td>NG</td>";
							}else{
								$grading_table .= "<td>{$value->mid_semester}</td>";
							}
							if($value->exam == 0){
								$grading_table .= "<td>NG</td>";
							}else{
								$grading_table .= "<td>{$value->exam}</td>";
							}
							if($value->total == 0){
								$grading_table .= "<td>NG</td>";
							}else{
								$grading_table .= "<td>{$value->total}</td>";
							}
							if($value->percentage == 0){
								$grading_table .= "<td>NG</td>";
							}else{
								$grading_table .= "<td>{$value->percentage}</td>";
							}
						}
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

	function input_students_scores($id){
		$sub_name = $this->M_Subjects->get_subject_by_id($id);
		$this->session->set_userdata('subject_id', $id);
		$get_scores = $this->M_Grades->get_scores_by_subid($id);
		
		foreach ($get_scores as $key => $value) {
			if ($value->attendance !== 0){
				$attendance = $value->attendance;
			}else{
				$attendance = 0;
			}
			if ($value->quiz !== 0){
				$quiz = $value->quiz;
			}else{
				$quiz = 0;
			}
			if ($value->assignment !== 0){
				$assignment = $value->assignment;
			}else{
				$assignment = 0;
			}
			if ($value->mid_semester !== 0){
				$mid_semester = $value->mid_semester;
			}else{
				$mid_semester = 0;
			}
			if ($value->exam !== 0){
				$exam = $value->exam;
			}else{
				$exam = 0;
			}
		}
		//$subname = "";
		foreach ($sub_name as $key => $value) {
			$this->session->set_userdata('subname', $value->subject_name);
		}

		$data['student_records'] = 'Students Management';
        $data['view_students'] = 'Add the scores of '.$this->session->userdata('studentna').' in each subject';
        $data['page_title'] = 'Manage Students Grades';
        $data['optional_description'] = 'Add scores for '.$this->session->userdata('studentna').'.';
        $data['add_scores'] = 'Add scores for '.$this->session->userdata('subname').'';
        $data['attendance'] = $attendance;
        $data['quiz'] = $quiz;
        $data['assignment'] = $assignment;
        $data['mid_semester'] = $mid_semester;
        $data['exam'] = $exam;
        $data['content_view'] = 'Grades/add_students_scores_view';
        $this->templates->call_admin_template($data);
	}

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