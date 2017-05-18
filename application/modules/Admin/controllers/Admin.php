<?php

class Admin extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model("M_Student");
		$this->load->module('Templates');
	}

	function index($data = NULL){

		$data['student_records'] = 'Students Management';
        $data['optional_description'] = 'Summary of registered students.';
        $data['page_title'] = 'Dashboard';
        $data['desc_students'] = 'Total Registered Students';
        $data['num_students'] = count($this->M_Student->get_students());
       // $data['num_accouning_students'] = count($this->M_Publications->get_active_publications());
        $data['content_view'] = 'Admin/dashboard_view';
        $this->templates->call_admin_template($data);
	}

	function manage_session(){
		$data['student_records'] = 'Students Management';
		$data['add_session'] = 'Add Session';
        $data['view_session'] = 'View Session';
        $data['page_title'] = 'Manage Session';
        $data['optional_description'] = 'Create new session record.';
        $data['desc_students'] = 'Add current session';
        $data['session_table'] = $this->create_session_table();
        $data['content_view'] = 'Admin/session_view';
        $this->templates->call_admin_template($data);
	}

	function create_session_table(){
		$this->load->model('M_Admin');
		$sessions = $this->M_Admin->get_session();

		$sessions_table = "";

		if (count($sessions)>0){
			$incrementer = 1;
			foreach ($sessions as $key => $value) {
				$sessions_table .="<tr>";
				$sessions_table .="<td>{$incrementer}</td>";
				$sessions_table .="<td>{$value->session_name}</td>";
				$sessions_table .="<td><a href='".base_url()."Admin/edit_session/{$value->sid}'> <i class='material-icons'>Edit</i></a></td>";
				$incrementer++;
			}
			return $sessions_table;
		}
	}

	function add_session(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('session', 'Add session', 'required|is_unique[sessiontb.session_name]', array(
                  'is_unique'     => 'This session already exists.'));
        // if validation fails
        if ($this->form_validation->run() == FALSE){
            $this->manage_session();

        }
        else
        {
        	if ($this->input->post()){
        		$this->load->model('M_Admin');
        		$this->M_Admin->add_sessions($this->input->post('session'));
        		//Create semesters and populates the semester table in database
        		for ($counter = 1; $counter<=2; $counter++){
        			$data = $this->input->post('session').'.'.$counter;
        			$this->M_Admin->add_semester($data);

        		}
        		$this->session->set_flashdata('success', 'Session successfully added');
        		redirect(base_url() . 'Admin/manage_session');
        	}
        }
	}

	function edit_session($id){
		$this->load->model('M_Admin');
		$sid = $this->M_Admin->get_session_by_id($id);
		//creates the session name field and populates it with the session to be edited
		$update_field = "";
		if(count($sid) > 0){
			foreach ($sid as $key => $value) {
				$update_field .= "<div class='col-sm-10'>";
				$update_field .= "<input  type='text' class='form-control' id='inputEmail3' name='{$value->session_name}' value='{$value->session_name}'>";
				$update_field .= "</div>";
				$this->session->set_userdata(array('sessionname' => $value->session_name));
			}	
		}
		//Loads the edit session page
		$data['student_records'] = 'Students Management';
		$data['update_session'] = 'Update Session';
        $data['page_title'] = 'Manage Session';
        $data['optional_description'] = 'Update current session record.';
        //$data['desc_students'] = 'Add current session';
        $data['session_field'] = $update_field;
        $data['content_view'] = 'Admin/update_session_view';
        $this->templates->call_admin_template($data);
	}

	function update_session(){
		if($this->input->post()){
			$this->load->model('M_Admin');
			$this->M_Admin->session_update();
			//Updates the semesters of the updated session
			for ($counter = 1; $counter<=2; $counter++){
				$olddata = $this->session->userdata('sessionname').'.'.$counter;
        		$data = $this->input->post($this->session->userdata('sessionname')).'.'.$counter;
        		$this->M_Admin->semester_update($data, $olddata);

        	}
        	$this->session->set_flashdata('success', 'Session successfully updated');
        	redirect(base_url() . 'Admin/manage_session');
		}
	}

}