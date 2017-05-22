<?php

class Students extends MY_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->load->module(['Templates']);
        $this->load->model('M_Student');
        
    }

    function add_students(){
    	$data['student_records'] = 'Students Management';
        $data['page_title'] = 'Manage Students Details';
        $data['optional_description'] = 'Add Students details, search details by matric number and program';
        $data['add_students'] = 'Add Students';
        $data['sessions'] = $this->session_select();
        $data['programs'] = $this->program_select();
        $data['student_tables'] = '';
        $data['content_view'] = 'Students/add_students_view';
        $this->templates->call_admin_template($data);
    }

    function search_students_with_matric(){
    	$data['student_records'] = 'Students Management';
        $data['page_title'] = 'Manage Students Details';
        $data['optional_description'] = 'Add Students details, search details by matric number and program';
        $data['add_students'] = 'Add Students';
        $data['sessions'] = $this->session_select();
        $data['programs'] = $this->program_select();
        $data['student_tables'] = $this->search_students_matric();
        $data['content_view'] = 'Students/add_students_view';
        $this->templates->call_admin_template($data);
    }

    function search_students_with_program(){
    	$data['student_records'] = 'Students Management';
        $data['page_title'] = 'Manage Students Details';
        $data['optional_description'] = 'Add Students details, search details by matric number and program';
        $data['add_students'] = 'Add Students';
        $data['sessions'] = $this->session_select();
        $data['programs'] = $this->program_select();
        $data['student_tables'] = $this->search_students_program();
        $data['content_view'] = 'Students/add_students_view';
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

    function program_select(){

        $programs = $this->M_Student->get_program();
        $options = "";
        if (count($programs)){
            foreach ($programs as $key => $value){
                $options .= "<option value = '{$value->pid}'>{$value->program_name}</option>";
            }
        }
        return $options;
    }

    function add_student_record(){

    	$this->load->library('form_validation');

		$this->form_validation->set_rules('matric', 'Matric Number', 'required');
		$this->form_validation->set_rules('stdname', 'Students Name', 'required');
		$this->form_validation->set_rules('sid', 'Session Name', 'required');
		$this->form_validation->set_rules('pid', 'Program Name', 'required');
        // if validation fails
        if ($this->form_validation->run() == FALSE){
            $this->add_students();

        }
        else
        {
	    	if ($this->input->post()){

	    		$matric = $this->input->post('matric');
	    		$stdname = $this->input->post('stdname');
	    		$sid = $this->input->post('sid');
	    		$pid = $this->input->post('pid');

	    		$this->M_Student->add_students($matric, $stdname, $sid, $pid);
	    	}
	    }
	    $this->session->set_flashdata('success', 'Students Record added successfully');
	    $this->add_students();
    }

    function search_students_program(){

    	if ($this->input->post()){

    		$student = $this->M_Student->get_student_by_program($this->input->post('pid'));
    		$student_table = "";

    		if (count($student) > 0){
    			$student_table .= "<section class='content'>";
    			$student_table .= "<div class='row'>";
    			$student_table .= "<div class='col-xs-12'>";
    			$student_table .= "<div class='box'>";
    			$student_table .= "<div class='box-header'>";
    			$student_table .= "<h3 class='box-title'>Students Details</h3>";
   				$student_table .= "</div>";
    			$student_table .= "<div class='box-body'>";
    			$student_table .= "<table id='example2' class='table table-bordered table-striped'>";
    			$student_table .= "<thead>";
    			$student_table .= "<tr>";
   				$student_table .= "<th>Serial No</th>";
   				$student_table .= "<th>Student Name</th>";
   				$student_table .= "<th>Program</th>";
   				$student_table .= "<th>Edit</th>";
   				$student_table .= "</tr>";
   				$student_table .= "</thead>";
   				$student_table .= "<tfoot>";
   				$student_table .= "<tr>";
   				$student_table .= "<th>Serial No</th>";
   				$student_table .= "<th>Student Name</th>";
   				$student_table .= "<th>Program</th>";
   				$student_table .= "<th>Edit</th>";
   				$student_table .= "</tr>";
   				$student_table .= "</tfoot>";
   				$student_table .= "<tbody>";
    			$counter = 1;
    			foreach ($student as $key => $value) {
    				
    				$program_name = $this->M_Student->get_program_name($value->program_id);
    				$std_id = $value->stdid;
    				$student_table .="<tr>";
					$student_table .="<td>{$counter}</td>";
					$student_table .="<td>{$value->student_name}</td>";
					foreach ($program_name as $key => $value){
						$student_table .="<td>{$value->program_name}</td>";
					}

					$student_table .="<td><a href='".base_url()."Students/edit_student/$std_id'> <i class='material-icons'>Edit</i></a></td>";
					$counter++;
    			}
    			$student_table .= "</tr>";
   				$student_table .= "</tbody>";
   				$student_table .= "</table>";
   				$student_table .= "</div>";
   				$student_table .= "</div>";
   				$student_table .= "</div>";
   				$student_table .= "</div>";
   				$student_table .= "</section>";
    		}else{
    			$student_table .= "<section class='content'>";
    			$student_table .= "<div class='row'>";
    			$student_table .= "<div class='col-xs-12'>";
    			$student_table .= "<div class='box'>";
    			$student_table .= "<div class='box-header'>";
    			$student_table .= "<h3 class='box-title'>Students Details</h3>";
   				$student_table .= "</div>";
    			$student_table .= "<div class='box-body'>";
    			$student_table .= "<table id='example2' class='table table-bordered table-striped'>";
    			$student_table .= "<thead>";
    			$student_table .= "<tr>";
   				$student_table .= "<th>Serial No</th>";
   				$student_table .= "<th>Student Name</th>";
   				$student_table .= "<th>Program</th>";
   				$student_table .= "<th>Edit</th>";
   				$student_table .= "</tr>";
   				$student_table .= "</thead>";
   				$student_table .= "<tfoot>";
   				$student_table .= "<tr>";
   				$student_table .= "<th>Serial No</th>";
   				$student_table .= "<th>Student Name</th>";
   				$student_table .= "<th>Program</th>";
   				$student_table .= "<th>Edit</th>";
   				$student_table .= "</tr>";
   				$student_table .= "</tfoot>";
   				$student_table .= "<tbody>";
   				$student_table .= "<tr>";
   				$student_table .= "<td colspan='4'><center><h4>Student records does not exist.</h4></center></td>";
   				$student_table .= "</tr>";
   				$student_table .= "</tbody>";
   				$student_table .= "</table>";
   				$student_table .= "</div>";
   				$student_table .= "</div>";
   				$student_table .= "</div>";
   				$student_table .= "</div>";
   				$student_table .= "</section>";
    		}
    	}
    	
    	return $student_table;
    }

    function search_students_matric(){

    	if ($this->input->post()){

    		$student = $this->M_Student->get_student_by_matric($this->input->post('matric'));
    		$student_table = "";

    		if (count($student) > 0){
    			$student_table .= "<section class='content'>";
    			$student_table .= "<div class='row'>";
    			$student_table .= "<div class='col-xs-12'>";
    			$student_table .= "<div class='box'>";
    			$student_table .= "<div class='box-header'>";
    			$student_table .= "<h3 class='box-title'>Students Details</h3>";
   				$student_table .= "</div>";
    			$student_table .= "<div class='box-body'>";
    			$student_table .= "<table id='example2' class='table table-bordered table-striped'>";
    			$student_table .= "<thead>";
    			$student_table .= "<tr>";
   				$student_table .= "<th>Serial No</th>";
   				$student_table .= "<th>Student Name</th>";
   				$student_table .= "<th>Program</th>";
   				$student_table .= "<th>Edit</th>";
   				$student_table .= "</tr>";
   				$student_table .= "</thead>";
   				$student_table .= "<tfoot>";
   				$student_table .= "<tr>";
   				$student_table .= "<th>Serial No</th>";
   				$student_table .= "<th>Student Name</th>";
   				$student_table .= "<th>Program</th>";
   				$student_table .= "<th>Edit</th>";
   				$student_table .= "</tr>";
   				$student_table .= "</tfoot>";
   				$student_table .= "<tbody>";
    			$counter = 1;
    			foreach ($student as $key => $value) {
    				
    				$program_name = $this->M_Student->get_program_name($value->program_id);
    				$std_id = $value->stdid;
    				$student_table .="<tr>";
					$student_table .="<td>{$counter}</td>";
					$student_table .="<td>{$value->student_name}</td>";
					foreach ($program_name as $key => $value){
						$student_table .="<td>{$value->program_name}</td>";
					}

					$student_table .="<td><a href='".base_url()."Students/edit_student/$std_id'> <i class='material-icons'>Edit</i></a></td>";
					$counter++;
    			}
    			$student_table .= "</tr>";
   				$student_table .= "</tbody>";
   				$student_table .= "</table>";
   				$student_table .= "</div>";
   				$student_table .= "</div>";
   				$student_table .= "</div>";
   				$student_table .= "</div>";
   				$student_table .= "</section>";
    		}else{
    			$student_table .= "<section class='content'>";
    			$student_table .= "<div class='row'>";
    			$student_table .= "<div class='col-xs-12'>";
    			$student_table .= "<div class='box'>";
    			$student_table .= "<div class='box-header'>";
    			$student_table .= "<h3 class='box-title'>Students Details</h3>";
   				$student_table .= "</div>";
    			$student_table .= "<div class='box-body'>";
    			$student_table .= "<table id='example2' class='table table-bordered table-striped'>";
    			$student_table .= "<thead>";
    			$student_table .= "<tr>";
   				$student_table .= "<th>Serial No</th>";
   				$student_table .= "<th>Student Name</th>";
   				$student_table .= "<th>Program</th>";
   				$student_table .= "<th>Edit</th>";
   				$student_table .= "</tr>";
   				$student_table .= "</thead>";
   				$student_table .= "<tfoot>";
   				$student_table .= "<tr>";
   				$student_table .= "<th>Serial No</th>";
   				$student_table .= "<th>Student Name</th>";
   				$student_table .= "<th>Program</th>";
   				$student_table .= "<th>Edit</th>";
   				$student_table .= "</tr>";
   				$student_table .= "</tfoot>";
   				$student_table .= "<tbody>";
   				$student_table .= "<tr>";
   				$student_table .= "<td colspan='4'><center><h4>Student record does not exist.</h4></center></td>";
   				$student_table .= "</tr>";
   				$student_table .= "</tbody>";
   				$student_table .= "</table>";
   				$student_table .= "</div>";
   				$student_table .= "</div>";
   				$student_table .= "</div>";
   				$student_table .= "</div>";
   				$student_table .= "</section>";
    		}
    	}
    	
    	return $student_table;
    }

    function edit_student($id){
    	$stdid = $this->M_Student->get_student_by_id($id);
		//creates the student name field and populates it with the student to be edited
		$update_field = "";
		if(count($stdid) > 0){
			foreach ($stdid as $key => $value) {
				$update_field .= "<div class='col-sm-9'>";
				$update_field .= "<input  type='text' class='form-control' id='inputEmail3' name='{$value->stdid}' value='{$value->student_name}'>";
				$update_field .= "</div>";
				$this->session->set_userdata(array('studentname' => $value->stdid, 'std_id' => $id));
			}	
		}

		//creates the matric number field and populates it with the matric number to be edited
		$update_matric_field = "";
		if(count($stdid) > 0){
			foreach ($stdid as $key => $value) {
				$update_matric_field .= "<div class='col-sm-9'>";
				$update_matric_field .= "<input  type='text' class='form-control' id='inputEmail3' name='{$value->matric_no}' value='{$value->matric_no}'>";
				$update_matric_field .= "</div>";
				$this->session->set_userdata(array('matricno' => $value->matric_no));
			}	
		}

		$data['student_records'] = 'Students Management';
		$data['update_student'] = 'Update Students record';
        $data['page_title'] = 'Manage Students';
        $data['optional_description'] = 'Update current students record.';
        //$data['desc_students'] = 'Add current session';
        $data['matric_field'] = $update_matric_field;
        $data['student_field'] = $update_field;
        $data['sessions'] = $this->session_select();
        $data['programs'] = $this->program_select();
        $data['content_view'] = 'Students/edit_student_view';
        $this->templates->call_admin_template($data);
    }

    function update_student(){
		if($this->input->post()){
			$this->M_Student->update_student_record();
			
        	$this->session->set_flashdata('success', 'Students record successfully updated');
        	redirect(base_url() . 'Students/add_students');
		}
	}
}
