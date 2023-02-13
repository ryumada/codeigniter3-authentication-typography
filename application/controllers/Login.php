<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	protected $titlepage = "Login";

	public function index()
	{
		$this->load->view('0_header', array(
			'titlepage' => $this->titlepage
		));
		$this->load->view('1_body_nav');
		$this->load->view('2_body_main_top');
		// insert main content here
		$this->load->view('login/login');
		$this->load->view('3_body_main_bottom');
		$this->load->view('4_body_footer');
		$this->load->view('5_body_scripts');
		// insert inline scripts
		$this->load->view('login/login_script');
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

