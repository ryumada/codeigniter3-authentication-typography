<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$data["pageinfo"] = array(
			"title" => "Login"
		);
		$data["load_view"] = "login/login";
		$this->load->view("app", $data);
	}

}

/* End of file Login.php */

