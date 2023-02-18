<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ckeditor extends Authenticated_controller {
	protected $titlepage = "CKEDITOR";

	public function index()
	{
		if( (bool) $this->input->get_request_header('Http-X-Is-Ajax') )
		{
			$this->output->set_content_type('application/json; charset=UTF-8');
			$this->output->set_status_header(200, "success");
			
			$this->data->response = new stdClass();
			$this->data->response->html = $this->load->view('ckeditor/view', "", true);
			$this->data->response->scripts = array(
				base_url('node_modules/@ckeditor/ckeditor5-build-classic/build/ckeditor.js'),
				base_url('assets/app-scripts/ckeditor/script.js')
			);
			$this->data->response->titlepage = $this->titlepage;
			$this->data->response->urlreferer = $this->input->get_request_header('Referer');
			$this->data->response->urlpath = current_url() . ($_SERVER['QUERY_STRING'] ? "?" . $_SERVER['QUERY_STRING'] : "");
			$this->output->set_output(json_encode($this->data->response));
		} else {
			$this->load->view('0_header', array(
				'titlepage' => $this->titlepage
			));
			$this->load->view('1_1_body_nav');
			$this->load->view('components/navbar_profile', ["email" => $this->data->user->email]);
			$this->load->view('1_2_body_nav');
			$this->load->view('2_body_main_top');
			// insert main content here
			$this->load->view('ckeditor/view');
			$this->load->view('3_body_main_bottom');
			$this->load->view('4_body_footer');
			$this->load->view('5_body_scripts');
			// insert inline scripts
			$this->load->view('ckeditor/scripts');
			$this->load->view('6_body_close');
		}
	}

}

/* End of file Ckeditor.php */

