<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Authenticated_controller
 * @property Ion_auth|Ion_auth_model	$ion_auth					The ION Auth spark
 * @property CI_Form_validation				$form_validation	The form validation library
 * @property CI_Input 								$input						The Input CI
 * @property CI_Output 								$output						The output CI
 * @property CI_Security 							$security 				The Security CI
 * @property CI_Session 							$session					The Session CI
 */
class Authenticated_controller extends CI_Controller {
	protected $data;

	public function __construct()
	{
		parent::__construct();
		$this->load->add_package_path(APPPATH . 'third_party/ion_auth/');
		$this->load->library(['ion_auth']);

		($this->ion_auth->logged_in()) ? "" : redirect('/login', 'refresh');

		$this->data = new stdClass();
		$this->data->user = $this->ion_auth->users()->result()[0];
	}
	
}
