<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsersController extends CI_Controller {


	public function user_page($tpl)
	{
		/*
		| -------------------------------------------------------------------------
		| IF user_level == 1  -- redirect to its corresponding page
		| -------------------------------------------------------------------------
		*/
		if ( $this->session->userdata('user_level') == 1 ) {
			redirect( base_url( 'admin/dashboard' ) );
		}

		$this->load->view('users/pages/'.$tpl);
	}
}
