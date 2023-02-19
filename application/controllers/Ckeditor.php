<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ckeditor extends Authenticated_controller {
	protected $titlepage = "CKEDITOR";

	protected $plugin_ckeditor_script_path = 'node_modules/@ckeditor/ckeditor5-build-classic/build/ckeditor.js';

	protected $view_ckeditor_path = 'ckeditor/view';
	
	protected $script_ckeditor_path = 'assets/app-scripts/ckeditor/script.js';
	protected $init_script_index = 'initCkeditorScripts';

	public function index()
	{
		if( (bool) $this->input->get_request_header('Http-X-Is-Ajax') )
		{
			$this->output->set_content_type('application/json; charset=UTF-8');
			$this->output->set_status_header(200, "success");
			
			$this->data->response = new stdClass();
			$this->data->response->html = $this->load->view($this->view_ckeditor_path, "", true);
			$this->data->response->scripts = array(
				base_url($this->plugin_ckeditor_script_path),
				array("init" => true, "src" => base_url($this->script_ckeditor_path))
			);
			$this->data->response->init_script_index = $this->init_script_index;
			$this->data->response->titlepage = $this->titlepage;
			$this->data->response->urlreferer = $this->input->get_request_header('Referer');
			$this->data->response->urlpath = current_url() . ($_SERVER['QUERY_STRING'] ? "?" . $_SERVER['QUERY_STRING'] : "");
			$this->output->set_output(json_encode($this->data->response));
		} else {
			$this->renderview(
				$this->titlepage,
				array(
					$this->view_ckeditor_path
				)
			);			
		}
	}

}

/* End of file Ckeditor.php */

