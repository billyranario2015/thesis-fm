<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsersController extends CI_Controller {


	public function user_page($tpl)
	{
		/*
		| -------------------------------------------------------------------------
		| IF user_level != 1  -- redirect to its corresponding page
		| -------------------------------------------------------------------------
		*/
		if ( $this->session->userdata('user_level') == 1 ) {
			redirect( base_url( 'admin/dashboard' ) );
		}

		$data = array(
			'tpl' => $tpl,
		);

		if ( $tpl == 'create-user' ) {
			$data['tpl'] = 'users';
			$data['tpl2'] = 'create-user';
			$data['courses'] = $this->course->get();
		} elseif ( $tpl == 'users' ) {
			$data['tpl'] = 'users';
			$data['tpl2'] = 'users';
			$data['users'] = $this->users->get_all_users_by_course($this->session->userdata('course_id'));
			// Load Custom Scripts in footer
			$data['scripts'] = '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/admin/users.js').'"></script>';
		} elseif ( $tpl == 'area' ) {
			$data['tpl'] = 'area';
			$data['tpl2'] = 'area';
			$data['areas'] = $this->area->get_by_course_id($this->session->userdata('course_id'));
			// Load Custom Scripts in footer
			$data['scripts'] = '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/users/areas.js').'"></script>';
		} elseif ( $tpl == 'create-area' ) {
			$data['tpl'] = 'area';
			$data['tpl2'] = 'create-area';
			$data['users'] = $this->users->get_all_users_by_course($this->session->userdata('course_id'));
		}
		$this->load->view('users/pages/'.$tpl, $data);
	}

	// Users
	public function create_user()
	{
		// $this->session->set_flashdata( $_POST );

		if ( $_POST['password'] == $_POST['confirm_password'] ) {
			// Remove $_POST['confirm_password'] when doing query to avoid database error
			unset( $_POST['confirm_password'] );
			if ( $_POST['password'] ) {
				$_POST['password'] = sha1($_POST['password']);
			}
			$response = $this->users->create($_POST);
			if ( $response['status'] == 'exists' ) {
				$this->session->set_flashdata( 'err_message' , $response['message'] );
				redirect( base_url( 'user/create-user/' ) );
			} elseif ( $response['status'] == 'success' ) {
				$this->session->set_flashdata( 'message' , $response['message'] );
				redirect( base_url( 'user/'.$response['data'].'/edit' ) );
			} else {
				$this->session->set_flashdata( 'err_message' , $response['message'] );
				redirect( base_url( 'user/create-user/' ) );
			}
		} else {
			$this->session->set_flashdata( 'err_message' , 'Password confirmation does not match.' );
			redirect( base_url( 'user/create-user/' ) );
		}
	}

	public function edit_user($id)
	{
		$data = array(
			'tpl' => 'users',
			'data' => $this->users->get_user_by_id($id),
		);
		$this->load->view('users/pages/edit-user',$data);
	}

	public function update_user()
	{
		if ( $_POST['password'] != $_POST['confirm_password'] ) {
			$this->session->set_flashdata( 'err_message' , 'Password did not match.' );
			redirect( base_url( 'user/'.$_POST['id'].'/edit/' ) );
		} else {

			unset( $_POST['confirm_password'] );

			if ( !empty($_POST['password']) ) {
				$_POST['password'] = sha1($_POST['password']);
			} else {
				unset( $_POST['password'] );
			}

			$response = $this->users->update($_POST);
			if ( $response['status'] == 'success' ) {
				$this->session->set_flashdata( 'message' , $response['message'] );
				redirect( base_url( 'user/'.$_POST['id'].'/edit' ) );
			} else {
				$this->session->set_flashdata( 'err_message' , $response['message'] );
				redirect( base_url( 'user/'.$_POST['id'].'/edit' ) );;
			}
		}
	}	


	// Area
	public function create_area()
	{
		// Check if user is already assigned to other area
		$is_assigned = $this->area->check_if_assigned($_POST);

		if ( !empty($is_assigned) ) {
			$this->session->set_flashdata( 'err_message' , $is_assigned['fname'] . ' ' . $is_assigned['lname'] . ' is already assigned to ' . $is_assigned['area_name'] );
			redirect( base_url( 'user/create-area' ) );
		} else {
			$id = $this->area->create($_POST);
			if ( $id ) {
				$this->session->set_flashdata( 'message' , 'Area successfully created.' );
				redirect( base_url( 'user/area/'.$id.'/edit' ) );
			}
		}

	}

	public function edit_area($id)
	{
		$data = array(
			'tpl' => 'area',
			'data' => $this->area->get_by_id($id),
			'users' => $this->users->get_all_users_by_course($this->session->userdata('course_id')),
			'tab'	=> 'templates',
			'action' => 'templates',
		);
		$this->load->view('users/pages/edit-area',$data);
	}

	public function update_area()
	{
		$data = array(
			'tpl' => 'area',
		);
		if ( $this->area->update($_POST) ) {
			$this->session->set_flashdata( 'message' , 'Area successfully updated.' );
			redirect( base_url( 'user/area/'.$_POST['id'] ) );
		}
	}

	public function delete_area()
	{
		$obj = json_decode(file_get_contents('php://input'));
		echo json_encode( [ 'response' => $this->area->delete($obj) ] );
	}

	// Area Template
	public function area_view($id,$tpl)
	{
		$data = array(
			'tpl' => 'area',
			'data' => $this->area->get_by_id($id),
			'users' => $this->users->get_all_users_by_course($this->session->userdata('course_id')),
			'tab'	=> 'templates',
			'action' => 'templates',
			'scripts'=> '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/users/areas.js').'"></script>',
		);
		
		if ( $tpl == 'templates' ) {
			$data['tab'] = 'templates';
			$data['action'] = $tpl;
		} elseif ( $tpl == 'template-create' ) {
			$data['tab'] = 'templates';
			$data['action'] = $tpl;
		} elseif ( $tpl == 'settings' ) {
			$data['tab'] = 'settings';
			$data['action'] = $tpl;
		}
		$this->load->view('users/pages/edit-area',$data);

	}	

	// Parameters
	public function create_param()
	{
		$obj = json_decode(file_get_contents('php://input'));
		echo json_encode( [ 'response' => $this->area_params->create($obj) ] );
	}

	public function get_parameters($area_id)
	{
		echo json_encode( [ 'response' => $this->area_params->get_by_area_id($area_id) ] );
	}
}
