<?php

class Subjects_Combination extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model(['M_Programs', 'M_Subjects', 'M_Grades']);
		$this->load->module('Templates');
	}

	function combine_subjects(){
		$data['student_records'] = 'Students Management';
		$data['add_program'] = 'Add Program';
        $data['view_program'] = 'List of available Programs';
        $data['page_title'] = 'Manage Programs';
        $data['optional_description'] = 'Add subject combination for each program';
        //$data['desc_students'] = 'Add current session';
        $data['programs_table'] = $this->create_programs_table();
        $data['content_view'] = 'Subjects_Combination/sub_combination_view';
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
				$programs_table .="<td><a href='".base_url()."Subjects_Combination/add_subject_combination/{$value->pid}'> <i class='material-icons'>Add subject combination</i></a></td>";
				$incrementer++;
			}
			return $programs_table;
		}
	}

	function add_subject_combination($id){
		
		$pid = $this->M_Programs->get_program_by_id($id);

		//creates the program name field and populates it with the program to be edited
		if(count($pid) > 0){
			foreach ($pid as $key => $value) {
				$this->session->set_userdata(array('program_name' => $value->program_name, 'p_id' => $value->pid));
			}
		}
		//Loads the edit session page
		$data['student_records'] = 'Students Management';
		$data['add_subjects'] = 'Add subjects for '.$this->session->userdata('program_name');
		$data['list_subjects'] = 'List of subjects for '.$this->session->userdata('program_name');
        $data['page_title'] = 'Manage subject combination';
        $data['optional_description'] = 'Programs subject combination.';
        $data['add_subject'] = 'Add Subject';
        $data['subjects'] = $this->subjects_select();
        $data['subject_table'] = $this->create_subject_combo_table();
        $data['content_view'] = 'Subjects_Combination/add_sub_combination_view';
        $this->templates->call_admin_template($data);
	}

	 function subjects_select(){

        $subjects = $this->M_Subjects->get_subjects();
        $options = "";
        if (count($subjects)){
            foreach ($subjects as $key => $value){
                $options .= "<option value = '{$value->subid}'>{$value->subject_name}</option>";
                //$this->session->set_userdata('s_id', $value->subid);
            }
        }
        return $options;
    }

    function create_subject_combo_table(){
    	// Gets the program id of the selected program
    	$subid = $this->M_Subjects->get_subject_pid($this->session->userdata('p_id'));
    	$subject_table = "";
    	
		if (count($subid)>0){
			$incrementer = 1;
			foreach ($subid as $key => $value) {
				$this->session->set_userdata(array('sid' => $value->sid));
				//Gets the subjects id's of the subjects added to the selected program
				$sub_id = $this->M_Subjects->get_subject_by_id($this->session->userdata('sid'));
				//Populate the programs' subject combination table with names of subjects for the program.
				foreach ($sub_id as $key => $value){
					$subject_table .="<tr>";
					$subject_table .="<td>{$incrementer}</td>";
					$subject_table .="<td>{$value->subject_name}</td>";
					$subject_table .="<td><a href='".base_url()."Subjects_Combination/remove_subject/{$value->subid}'> <i class='material-icons'>Drop</i></a></td>";
					$incrementer++;
				}
			}
			return $subject_table;
		}
    }

    function add_subject_combo(){
    	
    	$progid = $this->session->userdata('p_id');
    	if ($this->input->post()){
    		$this->M_Subjects->add_subject_combination($progid, $this->input->post('sub_name'));
    		$this->session->set_userdata(array('sub_id' => $this->input->post('sub_name')));
    	}
    	$this->add_subject_combination($progid);
    	//$this->M_Grades->initiate_percent_with_zero($this->session->userdata('p_id'), $this->session->userdata('sub_id'));

    }

    function remove_subject($id){

    	$this->M_Subjects->delete_subject($this->session->userdata('p_id'), $id);
    	$this->session->set_flashdata('successdelete', 'Subject deleted successfully.');
    	$this->add_subject_combination($this->session->userdata('p_id'));
    }
}	