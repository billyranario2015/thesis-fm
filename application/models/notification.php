<?php 
class Notification extends CI_Model {
	private $table = 'notification';

	public function create($data)
	{
		if ( $this->db->insert( $this->table , $data ) )
			return $this->db->insert_id();	// return newly added data id
		else 
			return false; // error, fail on create
	}

	public function get()
	{
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function get_by_id($id)
	{
		$this->db->select( 'notification.*, notification.id as notification_id, notification.created_at as notification_created_at, users.*, users.id as u_user_id' )
				 ->where('target_id', $id)
				 ->where('notification.notification_status',0)
				 ->join( 'users', 'notification.user_id = users.id' )
				 // ->join( 'area', 'area.assignee_id = users.id' )
				 ->order_by( 'notification.created_at', 'desc' );
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function get_notification_by_id($notification_id)
	{
		$this->db->where( 'id', $notification_id );
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
			return $query->row_array();
		else
			return array();
	}

	public function update($data)
	{
		$this->db->where('id',$data['id']);
		$query = $this->db->update( $this->table, $data );
		
		if ( $query )
			return true;
		else 
			return false;
	}

	public function delete($data)
	{
		if ( $this->db->delete($this->table, array('id' => $data->id)) ) {
			return true;
		} else {
			return false;
		}
	}
}