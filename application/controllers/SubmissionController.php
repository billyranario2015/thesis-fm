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
		];

		// GET Chairman's ID
		$course_data = $this->users->get_users_by_course_with_level($obj->userdata->course_id,2);

		$notification_arr = [
			'user_id' 				=> $obj->userdata->id,
			'notification_type'		=> 2, // SUBMISSIONS
			'target_id'				=> $course_data['id'],
			'notification_status'	=> 0, // UNSEENED 
			'course_id'				=> $obj->userdata->course_id,
			// 'submission_type'		=> 1, // SUBMIT AREA TO CHAIRMAN
		];

		echo json_encode( [ 
			'submission' => $this->submission->create($submission_arr),
			'notification' => $this->notification->create($notification_arr),
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
		];

		// GET Chairman's ID
		$course_data = $this->users->get_users_by_course_with_level($obj->userdata->course_id,4);

		$notification_arr = [
			'user_id' 				=> $obj->userdata->id,
			'notification_type'		=> 2, // SUBMISSIONS
			'target_id'				=> $course_data['id'],
			'notification_status'	=> 0, // UNSEENED 
			'course_id'				=> $obj->userdata->course_id,
			// 'submission_type'		=> 1, // SUBMIT AREA TO CHAIRMAN
		];

		echo json_encode( [ 
			'submission' => $this->submission->create($submission_arr),
			'notification' => $this->notification->create($notification_arr),
		] );
	}

	public function status_update()
	{
		$obj = json_decode(file_get_contents('php://input'));

		$notification_arr = [
			'user_id' 				=> $this->session->userdata('id'),
			'notification_type'		=> 3, // IN HOUSE EVALUATOR RESPONSE
			'target_id'				=> $obj->user_id,
			'notification_status'	=> 0, // UNSEENED 
			'course_id'				=> $this->session->userdata('course_id'),
		];

		echo json_encode( 
			[ 
				'response' => $this->submission->update($obj) ,
				'notification' => $this->notification->create($notification_arr)
			] 
		);
	}
}
