<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommentsController extends CI_Controller {
	
	public function addComment()
	{
		$obj = json_decode(file_get_contents('php://input'));

		$area_info = $this->area->get_area_by_area_id($obj->target_id);

		if ( $this->session->userdata( 'user_level' ) == 2 ) {
			#send notification to Subchairman who is assigned to the current area
			$target_id = $this->area->get_area_by_area_id($obj->target_id)['assignee_id'];
			

			#send notification to linked users to this area
			$linked_users = $this->area->get_linked_users_by_areaID($obj->target_id);
			$linked_users_notification_arr = [];
			foreach ($linked_users as $key => $user) {
				$linked_users_notification_arr[] = array(
					'user_id' 				=> $this->session->userdata('id'),
					// 1 = COMMENTS
					'notification_type'		=> 1,
					// TARGET -> AREA ID
					'target_id' 			=> $user['assignee_id'],
					'area_id' 				=> $obj->target_id,
					'notification_status' 	=> 0,
					'link'					=> base_url( 'user/level/'.$area_info['level_id'].'/area/' . $obj->target_id . '/edit')
				);
			}
			if ( !empty($linked_users_notification_arr) ) {
				$this->notification->create_batch($linked_users_notification_arr);
			}
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
			'link'					=> base_url( 'user/level/'.$area_info['level_id'].'/area/' . $obj->target_id . '/edit')
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
