<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ckeditor
 * 
 * @property CI_Upload	$upload CI Upload Library
 */
class Ckeditor extends Authenticated_controller {
	protected $titlepage = "CKEDITOR";

	protected $plugin_ckeditor_script_path = 'assets/ckeditor/ckeditor.js';

	protected $view_ckeditor_path = 'ckeditor/view';
	
	protected $script_ckeditor_path = 'assets/app-scripts/ckeditor/script.js';
	protected $init_script_index = 'initCkeditorScripts';

	protected $uploadConfig = array(
			'upload_path' =>  'files/ckeditor/images/',
			/**
			 * Allowed types should follows CKEDITOR allowed types
			 * https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/simple-upload-adapter.html#configuring-allowed-file-types
			 * 
			 * By default, users are allowed to upload jpeg, png, gif, bmp, webp and tiff file.
			 */
			'allowed_types' => 'jpg|jpeg|png|gif|bmp|webp|tiff',
			'max_size' => 4096,
	);

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
	
	/**
	 * A function to handle upload Image for CKEDITOR.
	 * Should be called from CKEDITOR Instance.
	 *
	 * @return void
	 */
	public function uploadimage() {
		$this->uploadConfig['file_name'] = $this->generateUniqueId();
		$this->load->library('upload', $this->uploadConfig);

		if(! $this->upload->do_upload('upload')) {
			$this->output->set_content_type('application/json; charset=UTF-8');
			$this->output->set_status_header(500, "Error");

			$this->data->response = new stdClass();
			$this->data->response->error['message'] = $this->upload->display_errors('', '');

			$this->output->set_output(json_encode($this->data->response));
		} else {
			$this->output->set_content_type('application/json; charset=UTF-8');
			$this->output->set_status_header(200, "success");

			$this->data->response = new stdClass();
			$this->data->response->url = base_url($this->uploadConfig['upload_path'] . $this->upload->data('file_name'));
			
			$this->output->set_output(json_encode($this->data->response));
		}
	}
	
	/**
	 * A function to handle autosave function for CKEDITOR Instance.
	 * This function is just for demo that the data from CKEDITOR Instance is sent successfully to the server.
	 *
	 * @return void
	 */
	public function autosave() {
		print_r($this->input->post('ckeditorData'));
	}
	
	/**
	 * a Function to generate unique ID.
	 *
	 * @return void
	 */
	private function generateUniqueId() {
		$random_bytes = random_bytes(32);
		return bin2hex($random_bytes);
	}

}

/* End of file Ckeditor.php */

