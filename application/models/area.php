<?php 
class Area extends CI_Model {
	private $table = 'area';

	public function create($data)
	{
		if ( $this->db->insert( $this->table , $data ) )
			return $this->db->insert_id();	// return newly added data id
		else 
			return false; // error, fail on create
	}

	// Area Update
	public function insert_sub_assignees($sub_assignees)
	{
		// Delete first the old lists of sub users of the area if exists
		$deleteQuery = $this->db->delete('area_sub_users', array('area_id' => $sub_assignees[0]['area_id']) );	

		if ( $this->db->insert_batch( 'area_sub_users' , $sub_assignees ) )
			return $this->get_sub_assignees($sub_assignees[0]['area_id']);	// retrieve all assignees
		else 
			return false; // error, fail on create
	}

	public function get_sub_assignees($area_id)
	{
		$this->db->select('area_sub_users.*, area_sub_users.id as area_sub_users_id, users.*, users.id as user_id')
				 ->where( 'area_id', $area_id )
		         ->join( 'users', 'users.id = area_sub_users.assignee_id' );
		$query = $this->db->get('area_sub_users');

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function get_linked_areas($user_id)
	{
		$this->db->select('area_sub_users.*,area_sub_users.id as area_sub_users_id, area.*, area.id as area_area_id,area_sub_users.assignee_id as asu_assignee_id, area.assignee_id as u_assignee_id,')
				 ->where( 'area_sub_users.assignee_id', $user_id )
				 ->join( 'area', 'area_sub_users.area_id = area.id' );
		$query = $this->db->get('area_sub_users');

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function get_linked_users_by_areaID($area_id)
	{
		$this->db->where( 'area_id', $area_id );
		$query = $this->db->get('area_sub_users');

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function get()
	{
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function my_area($id)
	{
		$this->db->where( 'assignee_id' , $id );
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
			return $query->row_array();
		else
			return array();
	}

	public function get_area_by_area_id($id)
	{
		$this->db->where( 'id' , $id );
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
			return $query->row_array();
		else
			return array();
	}

	public function get_by_course_id($id)
	{
		$this->db->select('area.area_name,area.id as area_id,users.fname,users.mname,users.lname,users.id as user_id')
				 ->from( $this->table )
				 ->join( 'users', 'users.id = area.assignee_id' )
				 ->where( 'area.course_id' , $id )
				 ->order_by( 'area.area_name', 'ASC' );
		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function get_by_id($data)
	{
		$this->db->where('id',$data);
		$query = $this->db->get($this->table);

		if ($query->num_rows() == 1)
			return $query->row_array();
		else
			return array();
	}

	public function check_if_assigned($data)
	{
		if( isset($data['check_area']) && $data['check_area'] == 1 ) {
			$this->db->where( 'area.id' , $data['id'] );
		}

		$this->db->where( 'assignee_id', $data['assignee_id'] )
			     ->join( 'users', 'users.id = area.assignee_id' );
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