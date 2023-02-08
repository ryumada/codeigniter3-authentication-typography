<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$data = array(
			"pageinfo" => array(
				"title" => "Login"
			)
			);

		$this->load->view("app", $data);
	}

}

/* End of file Login.php */

