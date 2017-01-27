<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {


	public function admin_page($tpl)
	{
		/*
		| -------------------------------------------------------------------------
		| IF user_level != 1  -- redirect to its corresponding page
		| -------------------------------------------------------------------------
		*/
		if ( $this->session->userdata('user_level') != 1 ) {
			redirect( base_url( 'user/dashboard' ) );
		}

		$data = array(
			'tpl' => $tpl,
		);

		if ( $tpl == 'create-organization' ) {
			$data['tpl'] = 'organizations';
			$data['tpl2'] = 'create-organizations';
		} elseif ( $tpl == 'organizations' ) {
			$data['tpl'] = 'organizations';
			$data['tpl2'] = 'organizations';
			// Load Custom Scripts in footer
			$data['scripts'] = '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/admin/organization.js').'"></script>';
			$data['orgs'] = $this->org->get();
		} elseif ( $tpl == 'users' ) {
			$data['tpl'] = 'users';
			$data['tpl2'] = 'users';
			$data['users'] = $this->users->get_all_users();
			// Load Custom Scripts in footer
			$data['scripts'] = '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/admin/users.js').'"></script>';
		} elseif ( $tpl == 'create-user' ) {
			$data['tpl'] = 'users';
			$data['tpl2'] = 'create-user';
			$data['courses'] = $this->course->get();
		} elseif ( $tpl == 'create-course' ) {
			$data['tpl'] = 'courses';
			$data['tpl2'] = 'create-course';
			$data['orgs'] = $this->org->get();
		} elseif ( $tpl == 'courses' ) {
			$data['tpl'] = 'courses';
			$data['tpl2'] = 'create-course';
			$data['courses'] = $this->course->get();
			// Load Custom Scripts in footer
			$data['scripts'] = '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/admin/course.js').'"></script>';
		}

		$this->load->view('admin/pages/'.$tpl , $data);
	}

	/*
	| -------------------------------------------------------------------------
	| ORGANIZATION METHODS
	| -------------------------------------------------------------------------
	*/
	public function create_organization()
	{
		$id = $this->org->create($_POST);
		if ( $id ) {
			$this->session->set_flashdata( 'message' , 'Organization successfully created.' );
			redirect( base_url( 'admin/organization/'.$id.'/edit' ) );
		}
	}
	public function edit_organization($id)
	{
		$data = array(
			'tpl' => 'organizations',
			'data' => $this->org->get_by_id($id)
		);
		$this->load->view('admin/pages/edit-organization',$data);
	}
	public function update_organization()
	{
		$data = array(
			'tpl' => 'organizations',
		);
		if ( $this->org->update($_POST) ) {
			$this->session->set_flashdata( 'message' , 'Organization successfully updated.' );
			redirect( base_url( 'admin/organization/'.$_POST['id'].'/edit' ) );
		}
	}
	public function delete_organization($id)
	{
		$obj = json_decode(file_get_contents('php://input'));
		echo json_encode( [ 'response' => $this->org->delete($obj) ] );
	}

	/*
	| -------------------------------------------------------------------------
	| USER METHODS
	| -------------------------------------------------------------------------
	*/
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
				redirect( base_url( 'admin/create-user/' ) );
			} elseif ( $response['status'] == 'success' ) {
				$this->session->set_flashdata( 'message' , $response['message'] );
				redirect( base_url( 'admin/user/'.$response['data'].'/edit' ) );
			} else {
				$this->session->set_flashdata( 'err_message' , $response['message'] );
				redirect( base_url( 'admin/create-user/' ) );
			}
		} else {
			$this->session->set_flashdata( 'err_message' , 'Password confirmation does not match.' );
			redirect( base_url( 'admin/create-user/' ) );
		}
	}
	public function edit_user($id)
	{
		$data = array(
			'tpl' => 'users',
			'data' => $this->users->get_user_by_id($id),
			'courses' => $this->course->get()
		);
		$this->load->view('admin/pages/edit-user',$data);
	}
	public function update_user()
	{
		if ( $_POST['password'] != $_POST['confirm_password'] ) {
			$this->session->set_flashdata( 'err_message' , 'Password did not match.' );
			redirect( base_url( 'admin/user/'.$_POST['id'].'/edit/' ) );
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
				redirect( base_url( 'admin/user/'.$_POST['id'].'/edit' ) );
			} else {
				$this->session->set_flashdata( 'err_message' , $response['message'] );
				redirect( base_url( 'admin/create-user/' ) );
			}
		}
	}
	public function delete_user()
	{
		$obj = json_decode(file_get_contents('php://input'));
		echo json_encode( [ 'response' => $this->users->delete($obj) ] );

	}

	/*
	| -------------------------------------------------------------------------
	| COURSES METHODS
	| -------------------------------------------------------------------------
	*/
	public function create_course()
	{
		$id = $this->course->create($_POST);
		if ( $id ) {
			$this->session->set_flashdata( 'message' , 'Course successfully created.' );
			redirect( base_url( 'admin/course/'.$id.'/edit' ) );
		}
	}
	public function edit_course($id)
	{
		$data = array(
			'tpl' => 'courses',
			'data' => $this->course->get_course_by_id($id),
			'orgs' => $this->org->get()
		);
		$this->load->view('admin/pages/edit-course',$data);
	}
	public function update_course()
	{
		$data = array(
			'tpl' => 'courses',
		);
		if ( $this->course->update($_POST) ) {
			$this->session->set_flashdata( 'message' , 'Course successfully updated.' );
			redirect( base_url( 'admin/course/'.$_POST['id'].'/edit' ) );
		}
	}
	public function delete_course()
	{
		$obj = json_decode(file_get_contents('php://input'));
		echo json_encode( [ 'response' => $this->course->delete($obj) ] );
	}

}

