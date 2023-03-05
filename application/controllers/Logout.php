<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Logout
 */
class Logout extends Authenticated_controller {	
	/**
	 * index
	 *
	 * @return void
	 */
	public function index()
	{
		$this->ion_auth->logout();
		redirect('/login', 'refresh');
	}
}
/* End of file Logout.php */
