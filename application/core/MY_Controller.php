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

	/**
	 * Render a view to user.
	 *
	 * @param  String $titlepage	The name of the title page.
	 * @param  Array $views				An array of views to load.
	 * @param  Array $scripts			An array of scripts to load.
	 * @return void
	 */
	public function renderview($titlepage = 'A page of website', $views = array(), $scripts = array()) 
	{
		try {
			$this->load->view('0_header', array(
				'titlepage' => $titlepage
			));
			$this->load->view('1_1_body_nav');
			$this->load->view('components/navbar_profile', ["email" => $this->data->user->email]);
			$this->load->view('1_2_body_nav');
			$this->load->view('2_body_main_top');
			// insert main content here
			foreach ($views as $view) {
				$this->load->view($view);
			}
			$this->load->view('3_body_main_bottom');
			$this->load->view('4_body_footer');
			$this->load->view('5_body_scripts');
			// insert inline scripts
			foreach ($scripts as $script) {
				$this->load->view($script);
			}
			$this->load->view('6_body_close');
		} catch (Throwable $th) {
			print_r($th);
		}
	}

	public function responsexhttpview(
		$response,
		$content_type = 'application/json; charset=UTF-8', 
		$status_code = 200,
		$status_message = 'success'
	) {

	}
}
