<?php 
class submission extends CI_Model {
	private $table = 'submission';

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

	public function get_submission_by_ID($submission_id)
	{	
		$this->db->where('id',$submission_id);
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
			return $query->row_array();
		else
			return array();
	}

	public function get_by_id($data)
	{
		$this->db->where('user_id',$data);
		$query = $this->db->get($this->table);

		if ($query->num_rows() == 1)
			return $query->row_array();
		else
			return array();
	}

	public function submitted_entry($data)
	{
		$this->db->select( 'users.*, users.id as u_user_id, submission.*, submission.id as submission_id' )
				 ->where('submission.course_id',$data['course_id'])
				 ->where('submission.user_id',$data['user_id'])
				 ->where('submission.submission_type',$data['submission_type'])
				 ->join( 'users', 'users.id = submission.user_id' );
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function check_chairman_submission($user_id, $level_id)
	{
		$this->db->where('user_id',$user_id)
				 ->where('level_id',$level_id);
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return 0;
	}

	public function get_submission_by_areaID($area_id)
	{
		$this->db->where('area_id',$area_id);
		$query = $this->db->get($this->table);	
		
		if ($query->num_rows() == 1)
			return $query->row_array();
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