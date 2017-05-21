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
        $data['optional_description'] = 'Students informative';
        $data['add_students'] = 'Add Students';
        $data['sessions'] = $this->session_select();
        $data['programs'] = $this->program_select();
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
}
