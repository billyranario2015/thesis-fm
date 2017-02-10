<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsersController extends CI_Controller {

	public function userdata()
	{
		echo json_encode( [
			'userdata'			=>	$this->session->userdata(),
			'belongsToArea'  	=> 	$this->area->my_area( $this->session->userdata('id') ),
			'notifications'  	=>  $this->notification->get_by_id( $this->session->userdata('id') ),
			'submission'		=>  $this->submission->get_by_id( $this->session->userdata('id') ),
		] );
	}
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
			$data['scripts'] = '<script src="'.base_url( 'assets/admin/plugins/bootstrap-select/js/bootstrap-select.js' ).'"></script>';
			$data['courses'] = $this->course->get();
		} elseif ( $tpl == 'users' ) {
			$data['tpl'] = 'users';
			$data['tpl2'] = 'users';
			$data['users'] = $this->users->get_all_users_by_course($this->session->userdata('course_id'));
			// Load Custom Scripts in footer
			$data['scripts'] = '<script src="'.base_url( 'assets/admin/plugins/bootstrap-select/js/bootstrap-select.js' ).'"></script>';
			$data['scripts'] .= '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/admin/users.js').'"></script>';
		} elseif ( $tpl == 'area' ) {
			$data['tpl'] = 'area';
			$data['tpl2'] = 'area';
			$data['areas'] = $this->area->get_by_course_id($this->session->userdata('course_id'));
			// Load Custom Scripts in footer
			$data['scripts'] = '<script src="'.base_url( 'assets/admin/plugins/bootstrap-select/js/bootstrap-select.js' ).'"></script>';

			$data['scripts'] = '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/users/areas.js').'"></script>';
		} elseif ( $tpl == 'create-area' ) {
			$data['tpl'] = 'area';
			$data['tpl2'] = 'create-area';
			$data['scripts'] = '<script src="'.base_url( 'assets/admin/plugins/bootstrap-select/js/bootstrap-select.js' ).'"></script>';
			$data['users'] = $this->users->get_all_users_by_course($this->session->userdata('course_id'));
		} 
		// USER_LEVEL == 3
		elseif ( $tpl == 'my-area' ) {
			$data['tpl'] = 'my-area';
			$data['data'] = $this->area->my_area($this->session->userdata('id'));
			$data['scripts'] = '<script src="'.base_url( 'assets/admin/plugins/bootstrap-select/js/bootstrap-select.js' ).'"></script>';
			$data['scripts'] = '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/users/areas.js').'"></script>';
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
			'scripts'=> '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/users/areas.js').'"></script>',
		);

		if ( @$_GET['notification'] ) {
			// UPDATE NOTIFICATION STATUS
			$this->notification->update( [
				'id'=> $_GET['id'],
				'notification_status' => 1 // Seened
			] );
		}

		$data['comments'] = $this->comments->get_comment_by_area_id($id);


		$this->load->view('users/pages/edit-area',$data);
	}

	public function update_area()
	{
		$data = array(
			'tpl' => 'area',
		);

		// Check if user is already assigned to other area
		$_POST['check_area'] = 1;
		$is_assigned = $this->area->check_if_assigned($_POST);


		if ( !empty($is_assigned) ) {
			if ( $is_assigned['assignee_id'] == $_POST['assignee_id'] ) {
				#unset $_POST['check_area']
				unset($_POST['check_area']);
				if ( $this->area->update($_POST) ) {
					$this->session->set_flashdata( 'message' , 'Area successfully updated.' );
				} else {
					$this->session->set_flashdata( 'err_message' , 'Error on update.' );
				}
				redirect( base_url( 'user/area/'.$_POST['id'] . '/settings' ) );
			} else {
				$this->session->set_flashdata( 'err_message' , $is_assigned['fname'] . ' ' . $is_assigned['lname'] . ' is already assigned to ' . $is_assigned['area_name'] );
				redirect( base_url( 'user/area/'.$_POST['id'] . '/settings' ) );
			}
		} else {
			echo "///";
			// Check if user is already assigned to other area
			$_POST['check_area'] = 0;
			$is_assigned = $this->area->check_if_assigned($_POST);

			if ( !empty($is_assigned) ) {
				$this->session->set_flashdata( 'err_message' , $is_assigned['fname'] . ' ' . $is_assigned['lname'] . ' is already assigned to ' . $is_assigned['area_name'] );
			} else {
				unset($_POST['check_area']);
				if ( $this->area->update($_POST) ) {
					$this->session->set_flashdata( 'message' , 'Area successfully updated.' );
				} else {
					$this->session->set_flashdata( 'err_message' , 'Error on update.' );
				}
			}

			redirect( base_url( 'user/area/'.$_POST['id'] . '/settings' ) );
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
		
		$data['comments'] = $this->comments->get_comment_by_area_id($id);
		
		if ( $tpl == 'templates' ) {
			$data['tab'] = 'templates';
			$data['action'] = $tpl;
		} elseif ( $tpl == 'template-create' ) {
			$data['tab'] = 'templates';
			$data['action'] = $tpl;
		} elseif ( $tpl == 'settings' ) {
			$data['tab'] = 'settings';
			$data['action'] = $tpl;
			$data['scripts'] .= '<br><script src="'.base_url( 'assets/admin/plugins/bootstrap-select/js/bootstrap-select.js' ).'"></script>';
		} elseif ( $tpl == 'entries' ) {
			$data['tab'] = 'entries';
			$data['action'] = $tpl;
		}
		$this->load->view('users/pages/edit-area',$data);
	}	

	public function area_view_entries( $area_id, $parameter_id )
	{
		$data = array(
			'tpl' => 'area',
			'data' => $this->area->get_by_id($area_id),
			'users' => $this->users->get_all_users_by_course($this->session->userdata('course_id')),
			'tab'	=> 'entries',
			'action' => 'entries',
			'param_id' => $parameter_id,
			// 'styles' => '<link rel="stylesheet" type="text/css" href="'.base_url('assets/admin/plugins/dropzone/dropzone.css').'">',
			// 'scripts' => '<script type="text/javascript" src="'.base_url('assets/admin/plugins/dropzone/dropzone.js').'"></script>',
			'styles' => '<link rel="stylesheet" type="text/css" href="'.base_url('assets/admin/css/fileinput.min.css').'">',
			'scripts' => '<script type="text/javascript" src="'.base_url('assets/admin/js/fileinput.min.js').'"></script>',
		);
		$data['scripts'] .= '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/users/areas.js').'"></script>';
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
		echo json_encode( [ 'response' => $this->categoryParentChildTree(0,'','',$area_id) ] );
	}
	public function get_parameters_clean($area_id)
	{
		echo json_encode( [ 'response' => $this->categoryParentChildTreeClean(0,'','',$area_id) ] );
	}

	public function categoryParentChildTree($parent = 0, $spacing = '', $category_tree_array = '', $area_id) {
		if (!is_array($category_tree_array))
			$category_tree_array = array();
		// Fetch parameter by area_id and parent_id
		$parameters = $this->area_params->get_child_by_parent_id($parent,$area_id);
		if ( count( $parameters ) > 0 ) {
			$num = 0;
			foreach ($parameters as $key => $param) {
				$category_tree_array[] = array(
					"id" 				=> $param['id'], 
					'area_id'			=> $param['area_id'],
					"parameter_name"	=> $spacing . $param['parameter_name'],
					"parent_id" 		=> $param['parent_id']
				);

				$category_tree_array = $this->categoryParentChildTree($param['id'], '::::: '.$spacing, $category_tree_array, $area_id);
			}
		}
		return $category_tree_array;
	}

	public function categoryParentChildTreeClean($parent = 0, $spacing = '', $category_tree_array = '', $area_id) {
		if (!is_array($category_tree_array))
			$category_tree_array = array();
		// Fetch parameter by area_id and parent_id
		$parameters = $this->area_params->get_child_by_parent_id($parent,$area_id);
		$numItems = count( $parameters );

		if ( count( $parameters ) > 0 ) {
			$num = 0;
			foreach ($parameters as $key => $param) {
				$category_tree_array[] = array(
					"id" 				=> $param['id'], 
					'area_id'			=> $param['area_id'],
					"parameter_name"	=> '<span class="spacer">' . $spacing . ++$num .'.) </span> <span class="param_name"> ' . $param['parameter_name'] . '</span>',
					"clean_parameter"	=> $param['parameter_name'],
					"parent_id" 		=> $param['parent_id']
				);

				$category_tree_array = $this->categoryParentChildTreeClean($param['id'], '::::: '.$spacing, $category_tree_array, $area_id);
			}
		}
		return $category_tree_array;
		return $category_tree_array;
	}

	public function get_parameters_by_id($id)
	{
		echo json_encode( ['response' => $this->area_params->get_by_id($id)] );
	}

	public function update_parameter()
	{
		$obj = json_decode(file_get_contents('php://input'));
		echo json_encode( [ 'response' => $this->area_params->update($obj) ] );
	}

	public function delete_parameter()
	{
		$obj = json_decode(file_get_contents('php://input'));
		echo json_encode( [ 'response' => $this->area_params->delete($obj) ] );
	}

	// File Upload
	public function file_upload($parameter_id)
	{
		$files = $_FILES;
		$filedata = [];
		$cpt = count($_FILES['file']['name']);
		for($i=0; $i<$cpt; $i++) {
		    $_FILES['files']['name']= $files['file']['name'][$i];
		    $_FILES['files']['type']= $files['file']['type'][$i];
		    $_FILES['files']['tmp_name']= $files['file']['tmp_name'][$i];
		    $_FILES['files']['error']= $files['file']['error'][$i];
		    $_FILES['files']['size']= $files['file']['size'][$i];
		    // $this->upload->initialize($this->set_upload_options());
		    $this->load->library('upload', $this->set_upload_options());

	    	$this->upload->do_upload('files');
	    	$fileName = $this->upload->data('file_name');


		    // Save to database
		    $data_id = $this->files->create(
		    	array(
		    		'filename' 		=> $fileName,
		    		'parameter_id'	=> $parameter_id,
		    		'author_id' 	=> $this->session->userdata('id')
		    	)
		    );

		    $filedata[] = $fileName;
		}
		echo json_encode($filedata);

	}

	public function set_upload_options()
	{
		$config = array();
        $config['upload_path'] = 'uploads/'; //give the path to upload the image in folder
        $config['allowed_types'] = '*';
        $config['max_size'] = '0';
        $config['overwrite'] = FALSE;
  		return $config;
	}

	public function get_uploads($parameter_id)
	{
		echo json_encode( ['response'=>$this->files->get($parameter_id)] );
	}

	public function search_file()
	{
		$obj = json_decode(file_get_contents('php://input'));
		echo json_encode( [ 'response' => $this->files->search($obj) ] );
	}

	public function update_file()
	{
		$obj = json_decode(file_get_contents('php://input'));
		echo json_encode( [ 'response' => $this->files->update($obj) ] );
	}

	public function delete_file()
	{
		$obj = json_decode(file_get_contents('php://input'));
		echo json_encode( [ 'response' => $this->files->delete($obj) ] );
	}

	public function copy_file($parameter_id)
	{
		$obj = json_decode(file_get_contents('php://input'));
		echo json_encode( [ 'response' => $this->files->copy($obj,$parameter_id) ] );
	}

}
