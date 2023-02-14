<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Login
 * @property Ion_auth|Ion_auth_model	$ion_auth					The ION Auth spark
 * @property CI_Form_validation				$form_validation	The form validation library
 * @property CI_Input 								$input						The Input CI
 * @property CI_Output 								$output						The output CI
 * @property CI_Security 							$security 				The Security CI
 * @property CI_Session 							$session					The Session CI
 */
class Login extends CI_Controller {
	protected $titlepage = "Login";
	
	public function __construct()
	{
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/ion_auth/');
		$this->load->library(['ion_auth']);

		($this->ion_auth->logged_in()) ? redirect('/dashboard', 'refresh') : "";
	}
	

	public function index()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->validate_form();

		} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
			$this->render_page();
		} else {
			$this->show_json_error();
		}
	}

	public function render_page($data = NULL) {
		$this->load->view('0_header', array(
				'titlepage' => $this->titlepage
			));
		$this->load->view('1_1_body_nav');
		$this->load->view('1_2_body_nav');
		$this->load->view('2_body_main_top');
		// insert main content here
		$this->load->view('login/login', $data);
		$this->load->view('3_body_main_bottom');
		$this->load->view('4_body_footer');
		$this->load->view('5_body_scripts');
		// insert inline scripts
		$this->load->view('login/login_script');
		($data) ? $this->load->view('login/validation_failed_script') : "";
		$this->load->view('6_body_close');
	}

	public function show_json_error($code = 404, $status = "Not Found", $message = "Not Found") {
		$this->output->set_content_type('application/json');
		$this->output->set_status_header($code, $status);
		$this->output->set_output(json_encode(array(
			"msg" => $message
		)));
	}

	protected function validate_form() {
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
		if($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('message', validation_errors());
			$this->render_page($this->input->post());
		} else {
			$this->do_login();
		}
	}

	protected function do_login() {
		$data = (object) html_escape($this->security->xss_clean($this->input->post()));
		$remember = (bool) $data->remember_me;
		// cek login identity
		if($this->ion_auth->login($data->email, $data->password, $remember)) {
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect('/dashboard', 'refresh');
		} else {
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect('/login', 'refresh');
		}
	}

	/* -------------------------------------------------------------------------- */
	/*                             Additional Function                            */
	/* -------------------------------------------------------------------------- */

	public function do_login2()
	{
		// $this->output->set_content_type('application/json');
		$this->output->set_content_type('text/html; charset=UTF-8');
		$this->output->set_status_header(200, "success");
		
		if((bool) $this->input->get_request_header('Http-X-Is-Ajax')) {
			$this->load->view('dashboard/dashboard');
		} else {
			$this->output->set_output(json_encode(array(
				"msg" => "error"
			)));
		}
	}

	public function basic_view()
	{
		$this->load->view('0_header', array(
			'titlepage' => $this->titlepage
		));
		$this->load->view('1_1_body_nav');
		// tempat untuk navbar profile.php
		$this->load->view('1_2_body_nav');
		$this->load->view('2_body_main_top');
		// insert main content here
		$this->load->view('3_body_main_bottom');
		$this->load->view('4_body_footer');
		$this->load->view('5_body_scripts');
		// insert inline scripts
		$this->load->view('6_body_close');
	}
		

	// the old way
	public function index_old()
	{
		// Form validation
		
		$data["pageinfo"] = array(
			"title" => "Login"
		);
		$data["load_view"] = "login/login";
		$data["load_scripts"] = ["login/login_script"];
		$this->load->view("app", $data);
	}

}

/* End of file Login.php */

