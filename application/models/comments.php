<?php 
class Comments extends CI_Model {
	private $table = 'comments';

	public function create($data)
	{
		$comment_entry = [
			'user_id' => $this->session->userdata('id'),
			'target_id' => $data->target_id,
			'comment_type' => $data->comment_type,
			'comment' => $data->comment
		];
		if ( $this->db->insert( $this->table , $comment_entry ) )
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

	public function get_comment_by_area_id($data)
	{
		$this->db->select( 'users.*, users.id as user_id,comments.*, comments.id as comment_id' )
				 ->where('target_id',$data)
				 ->join( 'users', 'users.id = comments.user_id' )
				 ->order_by( 'comments.created_at' , 'desc' );
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function update($data)
	{
		$this->db->where('id',$data->id);
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