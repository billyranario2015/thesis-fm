<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {


	public function index()
	{
		$this->load->view('login');
	}
	public function login()
	{
		$this->load->view('login');
	}
	public function post_login()
	{
		$response = $this->auth->postLogin( $_POST );
		if ( $response ) {
			// Retrieve User Info and Make SESSION for user
			$user_info = $this->users->get_user( $_POST );

			// Session User Info 
			$this->session->set_userdata($user_info);

			// Session Auth Access
			$this->session->set_userdata( ['is_logged_in' => true ] );

			$this->session->set_flashdata( 'message' , '' );

			// Check user_type
			if ( $user_info['user_level'] == 1 )
				redirect( base_url('admin/dashboard') );
			else
				redirect( base_url('user/dashboard') );



		} else {
			$this->session->set_flashdata( 'old_email', $_POST['email']);
			// BaseController::redirect_w_msg(['route' => base_url('login/') , 'item' => 'err_message' , 'msg' => '' ]);

			$this->session->set_flashdata( 'intl_get_error_message(oid)' , 'Please check if email and password are matched.' );
			redirect( base_url('login') );
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect( base_url( 'login' ) );
	}
}
