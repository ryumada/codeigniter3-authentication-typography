<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Dashboard
 * @property Ion_auth|Ion_auth_model		$ion_auth		The Ion Auth Spark
 * @property CI_Input 									$input			The Input CI
 * @property CI_Output 									$output			The output CI
 */
class Dashboard extends CI_Controller
{
	protected $titlepage = "Dashboard";
	public $data = [];
	
	public function __construct()
	{
		parent::__construct();
		$this->load->add_package_path(APPPATH . 'third_party/ion_auth/');
		$this->load->library('ion_auth');
		($this->ion_auth->logged_in()) ? "" : redirect('/login');
		$this->data['user'] = $this->ion_auth->users()->result()[0];
	}
	
	public function index()
	{
		if ((bool) $this->input->get_request_header('Http-X-Is-Ajax')) {
			$this->output->set_content_type('text/html; charset=UTF-8');
			$this->output->set_status_header(200, "success");
			$this->load->view('dashboard/dashboard');
		} else {
			$this->load->view('0_header', array(
				'titlepage' => $this->titlepage
			));
			$this->load->view('1_1_body_nav');
			$this->load->view('components/navbar_profile', ["email" => $this->data['user']->email]);
			$this->load->view('1_2_body_nav');
			$this->load->view('2_body_main_top');
			// insert main content here
			$this->load->view('3_body_main_bottom');
			$this->load->view('4_body_footer');
			$this->load->view('5_body_scripts');
			// insert inline scripts
			$this->load->view('6_body_close');
		}
	}
}

/* End of file  Dashboard.php */
