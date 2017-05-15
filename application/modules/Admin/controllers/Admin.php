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
}