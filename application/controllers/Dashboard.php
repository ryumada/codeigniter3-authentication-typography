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

	protected $view_dashboard_path = 'dashboard/dashboard';
	protected $script_dashboard_path = 'dashboard/dashboard_script';
	
	public function index()
	{
		if ((bool) $this->input->get_request_header('Http-X-Is-Ajax')) {
			$this->output->set_content_type('application/json');
			$this->output->set_status_header(200, "success");

			$this->data->response = new stdClass();
			$this->data->response->html = $this->load->view($this->view_dashboard_path, "", true);
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
			$this->renderview(
				$this->titlepage,
				array(
					$this->view_dashboard_path
				),
				array(
					$this->script_dashboard_path
				)
			);
		}
	}
}

/* End of file  Dashboard.php */
