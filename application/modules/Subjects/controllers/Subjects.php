<?php

class Subjects extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('M_Subjects');
		$this->load->module('Templates');
	}

	function add_subjects(){
		$data['student_records'] = 'Students Management';
		$data['add_subject'] = 'Add Subject';
        $data['view_subject'] = 'List of available subjects';
        $data['page_title'] = 'Manage subjects';
        $data['optional_description'] = 'Add a new subject.';
        //$data['desc_students'] = 'Add current session';
        $data['subjects_table'] = $this->create_subjects_table();
        $data['content_view'] = 'Subjects/subjects_view';
        $this->templates->call_admin_template($data);
	}

	function add_subject(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('subject', 'Add Subject', 'required|is_unique[subjecttb.subject_name]', array(
                  'is_unique'     => 'This subject already exists.'));
        // if validation fails
        if ($this->form_validation->run() == FALSE){
            $this->add_subjects();

        }
        else
        {
        	if ($this->input->post()){
        		
        		$this->M_Subjects->add_subjects($this->input->post('subject'));
        		
        		$this->session->set_flashdata('success', 'Subject successfully added');
        		redirect(base_url() . 'Subjects/add_subjects');
        	}
        }
	}

	function create_subjects_table(){
		
		$subjects = $this->M_Subjects->get_subjects();

		$subjects_table = "";

		if (count($subjects)>0){
			$incrementer = 1;
			foreach ($subjects as $key => $value) {
				$subjects_table .="<tr>";
				$subjects_table .="<td>{$incrementer}</td>";
				$subjects_table .="<td>{$value->subject_name}</td>";
				$subjects_table .="<td><a href='".base_url()."Subjects/edit_subject/{$value->subid}'> <i class='material-icons'>Edit</i></a></td>";
				$incrementer++;
			}
			return $subjects_table;
		}
	}

	function edit_subject($id){
		
		$subid = $this->M_Subjects->get_subject_by_id($id);

		//creates the subject name field and populates it with the subject to be edited
		$update_field = "";
		if(count($subid) > 0){
			foreach ($subid as $key => $value) {
				$update_field .= "<div class='col-sm-10'>";
				$update_field .= "<input  type='text' class='form-control' id='inputEmail3' name='{$value->subid}' value='{$value->subject_name}'>";
				$update_field .= "</div>";
				$this->session->set_userdata(array('subjectname' => $value->subject_name, 'subid' => $value->subid));
				
			}	
		}
		//Loads the edit session page
		$data['student_records'] = 'Students Management';
		$data['update_subject'] = 'Update subject';
        $data['page_title'] = 'Manage subject';
        $data['optional_description'] = 'Update current subject record.';
        //$data['desc_students'] = 'Add current subject';
        $data['subject_field'] = $update_field;
        $data['content_view'] = 'Subjects/update_subject_view';
        $this->templates->call_admin_template($data);
	}

	function update_subject(){
		if($this->input->post()){
			
			$this->M_Subjects->subject_update();
						
        	$this->session->set_flashdata('success', 'Subject successfully updated');
        	redirect(base_url() . 'Subjects/add_subjects');
		}
	}
}