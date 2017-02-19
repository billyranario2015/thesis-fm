<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommentsController extends CI_Controller {
	
	public function addComment()
	{
		$obj = json_decode(file_get_contents('php://input'));

		if ( $this->session->userdata( 'user_level' ) == 2 ) {
			#send notification to Subchairman who is assigned to the current area
			$target_id = $this->area->get_area_by_area_id($obj->target_id)['assignee_id'];
		} else {
			#send notification to Chairman if the comment is from the Sub-Chairman
			$target_id = $this->users->get_chairman_by_course_id($this->session->userdata('course_id'))[0]['id'];
		}

		// Create Notification
		$notification_arr = [
			'user_id' 				=> $this->session->userdata('id'),
			// 1 = COMMENTS
			'notification_type'		=> 1,
			// TARGET -> AREA ID
			'target_id' 			=> $target_id,
			'area_id' 				=> $obj->target_id,
			'notification_status' 	=> 0,
		];

		echo json_encode( [ 
			'response' => $this->comments->create($obj),
			'notification' => $this->notification->create($notification_arr),
		] );
	}

	public function getAreaComments($id)
	{
		echo json_encode( [
			'comments' => $this->comments->get_comment_by_area_id($id)
		] );
	}
}
