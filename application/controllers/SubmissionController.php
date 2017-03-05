<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubmissionController extends CI_Controller {

	// API REQUESTS
	public function addSubmissionArea()
	{
		$obj = json_decode(file_get_contents('php://input'));
		// Get Course data 
		$course = $this->course->get_course_by_id($obj->userdata->course_id);

		$submission_arr = [
			'user_id' 			=> $obj->userdata->id,
			'organization_id'	=> $course['organization_id'],
			'course_id'			=> $obj->userdata->course_id,
			'submission_type'	=> 1, // SUBMIT AREA TO CHAIRMAN 
			'submission_status'	=> 3, // UNAPPROVED
			'area_id'			=> $obj->userdata->area_id,
		];

		// Log current activity
		$log_arr = array(
			'course_id'	=> $this->session->userdata('course_id'),
			'author_id' => $this->session->userdata('id'),
			'message'   => $this->session->userdata('fname') . ' submitted an area.',
			'link'		=> base_url( 'user/level/'.$obj->userdata->level_id.'/area/'.$obj->userdata->area_id.'/edit' )
		);
		$this->logs->create($log_arr);		

		// GET Chairman's ID
		$course_data = $this->users->get_users_by_course_with_level($obj->userdata->course_id,5);

		$notification_arr = [
			'user_id' 				=> $obj->userdata->id,
			'notification_type'		=> 2, // SUBMISSIONS
			'target_id'				=> $course_data['id'],
			'notification_status'	=> 0, // UNSEENED 
			'course_id'				=> $obj->userdata->course_id,
			'link'					=> base_url( 'user/level/'.$obj->userdata->level_id.'/area/'.$obj->userdata->area_id.'/edit' ), // SUBMIT AREA TO CHAIRMAN
		];

		echo json_encode( [ 
			'submission' => $this->submission->create($submission_arr),
			'notification' => $this->notification->create($notification_arr),
		] );
	}

	public function get_submission_status($area_id)
	{
		echo json_encode( [ 
			'submission_status' => $this->submission->get_submission_by_areaID($area_id),
		] );
	}

	public function addSubmissionEvaluator()
	{
		$obj = json_decode(file_get_contents('php://input'));

		// Get Course data 
		$course = $this->course->get_course_by_id($obj->userdata->course_id);

		$submission_arr = [
			'user_id' 			=> $obj->userdata->id,
			'organization_id'	=> $course['organization_id'],
			'course_id'			=> $obj->userdata->course_id,
			'submission_type'	=> 2, // SUBMIT TO IN-HOUSE EVALUATOR 
			'submission_status'	=> 3, // UNAPPROVED
			'level_id'			=> $obj->userdata->level_id, // UNAPPROVED
		];

		// Log current activity
		$log_arr = array(
			'course_id'	=> $this->session->userdata('course_id'),
			'author_id' => $this->session->userdata('id'),
			'message'   => $this->session->userdata('fname') . ' has submitted an entry to evaluator.',
			'link'		=> base_url( 'user/level/'.$obj->userdata->level_id.'/areas' )
		);
		$this->logs->create($log_arr);	

		// GET Chairman's ID
		$course_data = $this->users->get_users_by_course_with_level($obj->userdata->course_id,4);

		$notification_arr = [
			'user_id' 				=> $obj->userdata->id,
			'notification_type'		=> 2, // SUBMISSIONS
			'target_id'				=> $course_data['id'],
			'notification_status'	=> 0, // UNSEENED 
			'course_id'				=> $obj->userdata->course_id,
			// 'submission_type'		=> 1, // SUBMIT AREA TO CHAIRMAN
			'link'					=> base_url( 'user/level/'.$obj->userdata->level_id.'/areas' ), // SUBMIT 
		];

		echo json_encode( [ 
			'submission' => $this->submission->create($submission_arr),
			'notification' => $this->notification->create($notification_arr),
		] );
	}

	public function status_update()
	{
		$obj = json_decode(file_get_contents('php://input'));
		// GET submission data
		$submission_info = $this->submission->get_submission_by_ID($obj->id);

		$notification_arr = [
			'user_id' 				=> $this->session->userdata('id'),
			'notification_type'		=> 3, // IN HOUSE EVALUATOR RESPONSE
			'target_id'				=> $obj->user_id,
			'notification_status'	=> 0, // UNSEENED 
			'course_id'				=> $this->session->userdata('course_id'),
			'link'					=> base_url( 'user/level/'.$submission_info['level_id'].'/areas' ) ,
		];

		echo json_encode( 
			[ 
				'response' => $this->submission->update($obj) ,
				'notification' => $this->notification->create($notification_arr)
			] 
		);
	}
}
