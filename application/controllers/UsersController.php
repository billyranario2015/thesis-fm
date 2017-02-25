<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsersController extends CI_Controller {

	public function userdata()
	{
		echo json_encode( [
			'userdata'			=>	$this->session->userdata(),
			'belongsToArea'  	=> 	$this->area->my_area( $this->session->userdata('id') ),
			'linkedAreas'		=>  $this->area->get_linked_areas($this->session->userdata('id')),
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
		} elseif ( $tpl == 'dashboard' ) {
			$data['tpl'] = 'dashboard';
			$data['tpl2'] = 'dashboard';
			$data['logs'] = $this->logs->get();
			// Load Custom Scripts in footer
			$data['scripts'] = '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/admin/users.js').'"></script>';
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

			// For chairman_info
			if ( @$_GET['notification'] ) {
				// UPDATE NOTIFICATION STATUS
				$this->notification->update( [
					'id'=> $_GET['id'],
					'notification_status' => 1 // Seened
				] );
			}

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
			/*
			|  GET MAIN AREA ASSIGNED TO CURRENT  SUB CHAIRMAN
			*/
			$data['data'] = $this->area->my_area($this->session->userdata('id'));
			/*
			|  LIST ALL LINKED AREAS ASSIGNED TO CURRENT SUB CHAIRMAN
			*/
			$data['linked_areas'] = $this->area->my_areas($this->session->userdata('id'));
			/*
			|  LIST ALL LEVEL AREAS ASSIGNED TO CURRENT SUB CHAIRMAN
			*/
			// $data['level_areas'] = $this->area->get_level_areas($this->session->userdata('id'));


			$data['scripts'] = '<script src="'.base_url( 'assets/admin/plugins/bootstrap-select/js/bootstrap-select.js' ).'"></script>';
			$data['scripts'] = '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/users/areas.js').'"></script>';
		} elseif ( $tpl == 'levels' ) {
			$data['tpl'] = 'levels';
			$data['tpl2'] = 'level';
			$data['levels'] = $this->levels->get($this->session->userdata('course_id'));
			$data['scripts'] = '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/users/areas.js').'"></script>';
			// For chairman_info
			// if ( @$_GET['notification'] ) {
			// 	// UPDATE NOTIFICATION STATUS
			// 	$this->notification->update( [
			// 		'id'=> $_GET['id'],
			// 		'notification_status' => 1 // Seened
			// 	] );
			// }
		}  elseif ( $tpl == 'create-level' ) {
			$data['tpl'] = 'levels';
			$data['tpl2'] = 'create-level';

			// For chairman_info
			// if ( @$_GET['notification'] ) {
			// 	// UPDATE NOTIFICATION STATUS
			// 	$this->notification->update( [
			// 		'id'=> $_GET['id'],
			// 		'notification_status' => 1 // Seened
			// 	] );
			// }
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

				// Log current activity
				$log_arr = array(
					'author_id' => $this->session->userdata('id'),
					'message'   => $this->session->userdata('fname') . ' created new user.',
					'link'		=> base_url( 'user/'.$response['data'].'/edit' )
				);
				$this->logs->create($log_arr);

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

	public function edit_user($id,$hide_fields = 0)
	{
		$data = array(
			'tpl' => 'users',
			'data' => $this->users->get_user_by_id($id),
			'hide_fields' => $hide_fields,
			'scripts' => '<script src="'.base_url( 'assets/admin/plugins/bootstrap-select/js/bootstrap-select.js' ).'"></script>'
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

				// Log current activity
				$log_arr = array(
					'author_id' => $this->session->userdata('id'),
					'message'   => $this->session->userdata('fname') . ' updated a user.',
					'link'		=> base_url( 'user/'.$_POST['id'].'/edit' )
				);
				$this->logs->create($log_arr);

				redirect( base_url( 'user/'.$_POST['id'].'/edit' ) );
			} else {
				$this->session->set_flashdata( 'err_message' , $response['message'] );
				redirect( base_url( 'user/'.$_POST['id'].'/edit' ) );;
			}
		}
	}	


	// Area
	public function create_level_area($level_id)
	{
		$data = array();		
		$data['tpl'] = 'levels';
		$data['tpl2'] = 'create-area';
		$data['scripts'] = '<script src="'.base_url( 'assets/admin/plugins/bootstrap-select/js/bootstrap-select.js' ).'"></script>';
		$data['users'] = $this->users->get_all_users_by_course($this->session->userdata('course_id'));
		$data['level_info'] = $this->levels->get_by_id($level_id);


		$this->load->view('users/pages/create-area', $data);
	}
	public function create_area()
	{
		// Check if user is already assigned to other area
		$is_assigned = $this->area->check_if_assigned($_POST);

		if ( !empty($is_assigned) ) {
			$this->session->set_flashdata( 'err_message' , $is_assigned['fname'] . ' ' . $is_assigned['lname'] . ' is already assigned to ' . $is_assigned['area_name'] );
			redirect( base_url( 'user/level/'.$_POST['level_id'].'/create-area' ) );
		} else {
			$id = $this->area->create($_POST);
			if ( $id ) {

				// Log current activity
				$log_arr = array(
					'author_id' => $this->session->userdata('id'),
					'message'   => $this->session->userdata('fname') . ' created an area.',
					'link'		=> base_url( 'user/area/'.$id.'/edit' )
				);
				$this->logs->create($log_arr);

				$this->session->set_flashdata( 'message' , 'Area successfully created.' );
				redirect( base_url( 'user/level/'.$_POST['level_id'].'/area/'.$id.'/edit' ) );

			}
		}
	}

	public function edit_area($level_id,$id)
	{
		$data = array(
			'data' => $this->area->get_by_id($id),
			'level_info' => $this->levels->get_by_id($level_id),
			'users' => $this->users->get_all_users_by_course($this->session->userdata('course_id')),
			'sub_users' => $this->area->get_sub_assignees($id),
			'tab'	=> 'templates',
			'action' => 'templates',
			'scripts'=> '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/users/areas.js').'"></script>',
		);
		$data['tpl'] = 'levels';
		$data['tpl2'] = 'area';

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

	public function edit_area_settings($level_id,$id)
	{
		$data = array(
			'tpl' => 'area',
			'data' => $this->area->get_by_id($id),
			'level_info' => $this->levels->get_by_id($level_id),
			'users' => $this->users->get_all_users_by_course($this->session->userdata('course_id')),
			'tab'	=> 'templates',
			'action' => 'templates',
			'scripts'=> '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/users/areas.js').'"></script>',
		);
		$data['tpl'] = 'levels';
		$data['tpl2'] = 'area';

		$data['comments'] = $this->comments->get_comment_by_area_id($id);
		
		$data['sub_users'] = $this->area->get_sub_assignees($id);
		$data['tab'] = 'settings';
		$data['action'] = 'settings';
		$data['scripts'] .= '<br><script src="'.base_url( 'assets/admin/plugins/bootstrap-select/js/bootstrap-select.js' ).'"></script>';

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

		// Insert Sub Assignee IDs
		$sub_assignees = [];

		if (isset($_POST['sub_assignee_id']) && (count($_POST['sub_assignee_id']) > 0) ) {
			foreach ($_POST['sub_assignee_id'] as $key => $sub) {
				$sub_assignees[] = [
					'area_id'		=> $_POST['id'],
					'assignee_id'	=> $sub,
					'course_id'		=> $this->session->userdata('course_id'),
				];
			}

			// Log current activity
			$log_arr = array(
				'author_id' => $this->session->userdata('id'),
				'message'   => $this->session->userdata('fname') . ' added new users on area ' . $_POST['area_name'] . '.',
				'link'		=> base_url( 'user/area/'.$_POST['id'] . '/settings' )
			);
			$this->logs->create($log_arr);

			$sub_assignees_status = $this->area->insert_sub_assignees($sub_assignees);

			// UNSET $_POST['sub_assignee_id']
			unset( $_POST['sub_assignee_id'] );
		}

		if ( !empty($is_assigned) ) {
			if ( $is_assigned['assignee_id'] == $_POST['assignee_id'] ) {
				#unset $_POST['check_area']
				unset($_POST['check_area']);
				if ( $this->area->update($_POST) ) {
					$this->session->set_flashdata( 'message' , 'Area successfully updated.' );
					
					// Log current activity
					$log_arr = array(
						'author_id' => $this->session->userdata('id'),
						'message'   => $this->session->userdata('fname') . ' updated area ' . $_POST['area_name'] . '.',
						'link'		=> base_url( 'user/level/'.$_POST['level_id'].'/area/'.$_POST['id'].'/settings' )
					);
					$this->logs->create($log_arr);					

				} else {
					$this->session->set_flashdata( 'err_message' , 'Error on update.' );
				}
				redirect( base_url( 'user/level/'.$_POST['level_id'].'/area/'.$_POST['id'].'/settings' ) );
			} else {
				$this->session->set_flashdata( 'err_message' , $is_assigned['fname'] . ' ' . $is_assigned['lname'] . ' is already assigned to ' . $is_assigned['area_name'] );
				redirect( base_url( 'user/level/'.$_POST['level_id'].'/area/'.$_POST['id'].'/settings' ) );
			}
		} else {
			// echo "///";
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

			redirect( base_url( 'user/level/'.$_POST['level_id'].'/area/'.$_POST['id'].'/settings' ) );
		}

	}

	public function delete_area()
	{
		$obj = json_decode(file_get_contents('php://input'));

		// Log current activity
		$log_arr = array(
			'author_id' => $this->session->userdata('id'),
			'message'   => $this->session->userdata('fname') . ' deleted an area.',
		);
		$this->logs->create($log_arr);

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
			$data['sub_users'] = $this->area->get_sub_assignees($id);
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

	public function get_area_parameters_by_id($level_id,$area_id,$parameter_id)
	{
		$data = array(
			'tpl' => 'levels',
			'level_info' => $this->levels->get_by_id($level_id),
			'data' => $this->area->get_by_id($area_id),
			'users' => $this->users->get_all_users_by_course($this->session->userdata('course_id')),
			'tab'	=> 'entries',
			'action' => 'entries',
			'param_id' => $parameter_id,
			'param_info' =>  $this->area_params->get_by_id($parameter_id),
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

		// Log current activity
		$log_arr = array(
			'author_id' => $this->session->userdata('id'),
			'message'   => $this->session->userdata('fname') . ' created parameter ' . $obj->parameter_name,
			'link'		=> base_url( 'user/area/'.$obj->area_id )
		);
		$this->logs->create($log_arr);

		echo json_encode( [ 'response' => $this->area_params->create($obj) ] );
	}

	public function get_all_parameters()
	{
		echo json_encode( [ 'response' => $this->get_all_parameter_list(0,'','') ] );
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
					"parent_id" 		=> $param['parent_id'],
					"child_param_count" => $this->area_params->count_child_params($param['id']),
					"parameter_status"	=> $this->files->get_file_count(
												$param['id'],
												$this->area_params->count_child_params($param['id'])
										   ),
					"tags"				=> $param['tags']
				);

				$category_tree_array = $this->categoryParentChildTreeClean($param['id'], '::::: '.$spacing, $category_tree_array, $area_id);
			}
		}
		return $category_tree_array;
	}


	public function get_all_parameter_list($parent = 0, $spacing = '', $category_tree_array = '') {
		if (!is_array($category_tree_array))
			$category_tree_array = array();

		$parameters = $this->area_params->get_child_parameters_bulk($parent);
		$numItems = count( $parameters );

		if ( count( $parameters ) > 0 ) {
			$num = 0;
			foreach ($parameters as $key => $param) {
				$category_tree_array[] = array(
					"id" 				=> $param['id'], 
					'area_id'			=> $param['area_id'],
					"parameter_name"	=> '<span class="spacer">' . $spacing . ++$num .'.) </span> <span class="param_name"> ' . $param['parameter_name'] . '</span>',
					"clean_parameter"	=> $param['parameter_name'],
					"parent_id" 		=> $param['parent_id'],
					"child_param_count" => $this->area_params->count_child_params($param['area_parameter_id']),
					"parameter_status"	=> $this->files->get_file_count(
												$param['area_parameter_id'],
												$this->area_params->count_child_params($param['area_parameter_id'])
										   ),
					'level_info'		=> $this->levels->get_by_id($param['level_id']),
					'area_parameter_id' => $param['area_parameter_id']
				);

				$category_tree_array = $this->get_all_parameter_list($param['area_parameter_id'], '::::: '.$spacing, $category_tree_array);
			}
		}
		return $category_tree_array;
	}

	public function get_parameters_by_id($id)
	{
		echo json_encode( ['response' => $this->area_params->get_by_id($id)] );
	}

	public function update_parameter()
	{
		$obj = json_decode(file_get_contents('php://input'));
		// Log current activity
		$log_arr = array(
			'author_id' => $this->session->userdata('id'),
			'message'   => $this->session->userdata('fname') . ' updated parameter ' . $obj->parameter_name,
			'link'		=> base_url( 'user/area/'.$obj->area_id )
		);
		$this->logs->create($log_arr);

		echo json_encode( [ 'response' => $this->area_params->update($obj) ] );
	}

	public function delete_parameter()
	{
		$obj = json_decode(file_get_contents('php://input'));

		// Log current activity
		$log_arr = array(
			'author_id' => $this->session->userdata('id'),
			'message'   => $this->session->userdata('fname') . ' deleted a parameter.',
		);
		$this->logs->create($log_arr);

		echo json_encode( [ 'response' => $this->area_params->delete($obj) ] );
	}

	public function get_child_params_count($parameter_id,$child_count)
	{	
		/* 
		| If paramater has no child, then count the files inside this parameter
		| if empty, mark this parameter as incomplete
		*/ 
		$file_count = 0;
		if ( $child_count == 0 ) {
			// Get the numbers of files of this parameter
			$file_count = $this->files->get_file_count($parameter_id);
		}

		echo json_encode(['file_count'=>$file_count]);
	}

	// File Upload
	public function file_upload($parameter_id)
	{
		$files = $_FILES;
		$filedata = [];
		$cpt = count($_FILES['file']['name']);
		for($i=0; $i<$cpt; $i++) {
		    $_FILES['files']['name']		= $files['file']['name'][$i];
		    $_FILES['files']['type']		= $files['file']['type'][$i];
		    $_FILES['files']['tmp_name']	= $files['file']['tmp_name'][$i];
		    $_FILES['files']['error']		= $files['file']['error'][$i];
		    $_FILES['files']['size']		= $files['file']['size'][$i];
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

			// Log current activity
			$log_arr = array(
				'author_id' => $this->session->userdata('id'),
				'message'   => $this->session->userdata('fname') . ' uploaded a file '.$fileName,
			);
			$this->logs->create($log_arr);

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

	public function get_available_files()
	{
		echo json_encode( ['response'=>$this->files->get_available_files()] );
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

	/*
	| -------------------------------------------------------------------------
	| EVALUATOR
	| -------------------------------------------------------------------------
	*/
	public function evaluator_page($tpl)
	{

		$data = array(
			'tpl' => $tpl,
		);

		if ( $tpl == 'dashboard' ) {
			$data['tpl'] = 'users';
			$data['tpl2'] = 'create-user';
			$data['scripts'] = '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/users/areas.js').'"></script>';
			$data['courses'] = $this->course->get();


			// GET CHAIRMAN OF THE COURSE
			$data['chairman_info'] = $this->users->get_course_chairman($this->session->userdata('course_id'));

			// CHECK IF ALREADY SUBMITTED AN ENTRY FOR IN-HOUSE EVALUATOR
			$data['submitted_entry'] = $this->submission->submitted_entry( 
				array(
					'course_id' 		=> $this->session->userdata('course_id'),
					'user_id'			=> $data['chairman_info']['id'], // Submitted by 
					'submission_type'	=> 2 // 2 = SUBMIT TO IN-HOUSE EVALUATOR 
				) 
			);

		}
		$this->load->view('users/pages/evaluator/'.$tpl, $data);
	}
 	

 	public function evaluate_area($user_id)
 	{

 		// get user's course_id
 		$chairman_info = $this->users->get_user_by_id($user_id);


 		$data = array(
 			'areas'			=> $this->area->get_by_course_id($chairman_info['course_id']),
 			'chairman_info' => $chairman_info,
 		);

	
		if ( @$_GET['notification'] ) {
			// UPDATE NOTIFICATION STATUS
			$this->notification->update( [
				'id'=> $_GET['id'],
				'notification_status' => 1 // Seened
			] );
		}



		$this->load->view('users/pages/evaluator/evaluatee', $data);
 	}

 	public function evaluate_area_content($user_id,$area_id)
 	{

 		// get user's course_id
 		$chairman_info = $this->users->get_user_by_id($user_id);


		$data = array(
			'tpl' => 'area',
			'data' => $this->area->get_by_id($area_id),
			'users' => $this->users->get_user_by_id($user_id),
			'tab'	=> 'templates',
			'action' => 'templates',
			'chairman_info' => $chairman_info,
			'area_id' => $area_id,
			'user_id' => $user_id,
			'scripts'=> '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/users/areas.js').'"></script>',
		);

		if ( @$_GET['notification'] ) {
			// UPDATE NOTIFICATION STATUS
			$this->notification->update( [
				'id'=> $_GET['id'],
				'notification_status' => 1 // Seened
			] );
		}

		$this->load->view('users/pages/evaluator/evaluate-area-content',$data);
 	}

 	public function evaluate_parameter_content($user_id,$area_id,$parameter_id)
 	{
		// get user's course_id
 		$chairman_info = $this->users->get_user_by_id($user_id);

		$data = array(
			'tpl' => 'area',
			'data' => $this->area->get_by_id($area_id),
			'users' => $this->users->get_user_by_id($user_id),
			'tab'	=> 'templates',
			'action' => 'templates',
			'chairman_info' => $chairman_info,
			'area_id' => $area_id,
			'param_id' => $parameter_id,
			'param_info' => $this->area_params->get_by_id($parameter_id),
			'user_id' => $user_id,
			'scripts'=> '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/users/areas.js').'"></script>',
		);

		if ( @$_GET['notification'] ) {
			// UPDATE NOTIFICATION STATUS
			$this->notification->update( [
				'id'=> $_GET['id'],
				'notification_status' => 1 // Seened
			] );
		}

		$this->load->view('users/pages/evaluator/evaluate-parameter-content',$data);
 	}

 	public function redirectToNotificationContent($user_id)
 	{	
 		// Get User Info - USER
 		$user = $this->users->get_user_by_id($user_id);

 		// Get User Info - AREA
 		$user_area = $this->area->my_area($user_id);

 		// Get Notification
 		$notification = $this->notification->get_notification_by_id($_GET['id']);

 		// Update Notification Status
		if ( @$_GET['notification'] ) {
			// UPDATE NOTIFICATION STATUS
			$this->notification->update( [
				'id'=> $_GET['id'],
				'notification_status' => 1 // Seened
			] );
		}
 		// Redirect to Notification Content
 		if ( $notification['notification_type'] == 1 ) { // if notification_type is a 1 
 			redirect( base_url( 'user/area/'.$notification['area_id']) );
 		} else {
 			redirect( base_url( 'user/area/'.$user_area['id']) );
 		}

 		var_dump($notification);
 	}

 	// LEVELS
 	public function create_level()
 	{
		$level_id = $this->levels->create($_POST);
		if ( !empty($level_id) ) {
			$this->session->set_flashdata( 'message' , 'Level successfully created.' );
			redirect( base_url( 'user/level/'.$level_id.'/edit' ) );
		} else {
			$this->session->set_flashdata( 'err_message' , 'Something went wrong. Please try again later.' );
			redirect( base_url( 'user/create-level/' ) );
		}
 	}

	public function edit_level($id)
	{
		$data = array(
			'tpl' => 'levels',
			'data' => $this->levels->get_by_id($id),
		);

		if ( @$_GET['notification'] ) {
			// UPDATE NOTIFICATION STATUS
			$this->notification->update( [
				'id'=> $_GET['id'],
				'notification_status' => 1 // Seened
			] );
		}

		$this->load->view('users/pages/edit-level',$data);
	}

	public function update_level()
	{
		if ( $this->levels->update($_POST) ) {
			$this->session->set_flashdata( 'message' , 'Level successfully updated.' );
			
			// Log current activity
			$log_arr = array(
				'author_id' => $this->session->userdata('id'),
				'message'   => $this->session->userdata('fname') . ' updated level ' . $_POST['level_name'],
				'link'		=> base_url( 'user/level/'.$_POST['id'].'/edit' )
			);
			$this->logs->create($log_arr);					

		} else {
			$this->session->set_flashdata( 'err_message' , 'Error on update.' );
		}
		redirect( base_url( 'user/level/'.$_POST['id'].'/edit' ) );		

	}

	public function get_level_areas($level_id)
	{
		$level_info = $this->levels->get_by_id($level_id);

		$data = array(
			'level_info' 	=> $level_info, 
			'areas' 		=> $this->levels->get_level_areas($level_id)
		);

		$data['tpl'] = 'levels';
		$data['tpl2'] = 'area';
		$data['users'] = $this->users->get_all_users_by_course($this->session->userdata('course_id'));

		// For chairman_info
		if ( @$_GET['notification'] ) {
			// UPDATE NOTIFICATION STATUS
			$this->notification->update( [
				'id'=> $_GET['id'],
				'notification_status' => 1 // Seened
			] );
		}

		// Load Custom Scripts in footer
		$data['scripts'] = '<script type="text/javascript" src="'.base_url('assets/admin/js/angularjs/controllers/users/areas.js').'"></script>';


		$this->load->view('users/pages/level_areas', $data);
	}

	public function delete_level()
	{
		$obj = json_decode(file_get_contents('php://input'));

		// Log current activity
		$log_arr = array(
			'author_id' => $this->session->userdata('id'),
			'message'   => $this->session->userdata('fname') . ' deleted a level.',
		);
		$this->logs->create($log_arr);

		echo json_encode( [ 'response' => $this->levels->delete($obj) ] );
	}

}
