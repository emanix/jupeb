<?php

class Programs extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('M_Programs');
		$this->load->module('Templates');
	}

	function add_programs(){
		$data['student_records'] = 'Students Management';
		$data['add_program'] = 'Add Program';
        $data['view_program'] = 'List of available Programs';
        $data['page_title'] = 'Manage Programs';
        $data['optional_description'] = 'Add a new program.';
        //$data['desc_students'] = 'Add current session';
        $data['programs_table'] = $this->create_programs_table();
        $data['content_view'] = 'Programs/programs_view';
        $this->templates->call_admin_template($data);
	}

	function add_program(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('program', 'Add program', 'required|is_unique[programtb.program_name]', array(
                  'is_unique'     => 'This program already exists.'));
        // if validation fails
        if ($this->form_validation->run() == FALSE){
            $this->add_programs();

        }
        else
        {
        	if ($this->input->post()){
        		
        		$this->M_Programs->add_programs($this->input->post('program'));
        		
        		$this->session->set_flashdata('success', 'Program successfully added');
        		redirect(base_url() . 'Programs/add_programs');
        	}
        }
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
				$programs_table .="<td><a href='".base_url()."Programs/edit_program/{$value->pid}'> <i class='material-icons'>Edit</i></a></td>";
				$incrementer++;
			}
			return $programs_table;
		}
	}

	function edit_program($id){
		
		$pid = $this->M_Programs->get_program_by_id($id);

		//creates the program name field and populates it with the program to be edited
		$update_field = "";
		if(count($pid) > 0){
			foreach ($pid as $key => $value) {
				$update_field .= "<div class='col-sm-10'>";
				$update_field .= "<input  type='text' class='form-control' id='inputEmail3' name='{$value->pid}' value='{$value->program_name}'>";
				$update_field .= "</div>";
				$this->session->set_userdata(array('programname' => $value->program_name, 'pid' => $value->pid));
				
			}	
		}
		//Loads the edit session page
		$data['student_records'] = 'Students Management';
		$data['update_program'] = 'Update program';
        $data['page_title'] = 'Manage program';
        $data['optional_description'] = 'Update current program record.';
        //$data['desc_students'] = 'Add current program';
        $data['program_field'] = $update_field;
        $data['content_view'] = 'Programs/update_program_view';
        $this->templates->call_admin_template($data);
	}

	function update_program(){
		if($this->input->post()){
			
			$this->M_Programs->program_update();
						
        	$this->session->set_flashdata('success', 'Program successfully updated');
        	redirect(base_url() . 'Programs/add_programs');
		}
	}
}