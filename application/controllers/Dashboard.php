<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Dashboard
 * @property Ion_auth|Ion_auth_model		$ion_auth		The Ion Auth Spark
 * @property CI_Input 									$input			The Input CI
 * @property CI_Output 									$output			The output CI
 */
class Dashboard extends Authenticated_controller
{
	protected $titlepage = "Dashboard";
	
	public function index()
	{
		if ((bool) $this->input->get_request_header('Http-X-Is-Ajax')) {
			$this->output->set_content_type('application/json');
			$this->output->set_status_header(200, "success");

			$this->data->response = new stdClass();
			$this->data->response->html = $this->load->view('dashboard/dashboard', "", true);
			$this->data->response->titlepage = $this->titlepage;
			$this->data->response->urlreferer = $this->input->get_request_header('Referer');
			$this->data->response->urlpath = current_url() . ($_SERVER['QUERY_STRING'] ? "?" . $_SERVER['QUERY_STRING'] : "");
			$this->output->set_output(json_encode($this->data->response));
			/**
			 * JSON Output Example:
			 * {
			 * 		"html": "HTML Strings",
			 * 		"titlepage": "Page Title",
			 * 		"urlreferer": "http link before",
			 * 		"urlpath": "http link in this controller"
			 * }
			 */
		} else {
			$this->load->view('0_header', array(
				'titlepage' => $this->titlepage
			));
			$this->load->view('1_1_body_nav');
			$this->load->view('components/navbar_profile', ["email" => $this->data->user->email]);
			$this->load->view('1_2_body_nav');
			$this->load->view('2_body_main_top');
			// insert main content here
			$this->load->view('dashboard/dashboard');
			$this->load->view('3_body_main_bottom');
			$this->load->view('4_body_footer');
			$this->load->view('5_body_scripts');
			// insert inline scripts
			$this->load->view('dashboard/dashboard_script');
			$this->load->view('6_body_close');
		}
	}
}

/* End of file  Dashboard.php */
