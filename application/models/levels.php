<?php 
class Levels extends CI_Model {
	private $table = 'levels';

	public function get()
	{
		$query = $this->db->order_by( 'level_name' , 'asc' )
						  ->where( 'course_id', $this->session->userdata('course_id') )
						  ->where( 'is_trash', 0 )
						  ->get($this->table);

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function get_all_trash()
	{
		$query = $this->db->order_by( 'level_name' , 'asc' )
						  ->where( 'course_id', $this->session->userdata('course_id') )
						  ->where( 'is_trash', 1 )
						  ->get($this->table);

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


	public function get_level_areas($level_id)
	{
		$this->db->select('area.area_name,area.id as area_id,users.fname,users.mname,users.lname,users.id as user_id')
				 ->from( 'area')
				 ->join( 'users', 'users.id = area.assignee_id' )
				 ->where( 'area.level_id' , $level_id )
				 ->where( 'area.is_trash' , 0 )
				 ->order_by( 'area.area_name', 'ASC' );
		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function get_all_trashed_areas($level_id)
	{
		$this->db->select('area.area_name,area.id as area_id,users.fname,users.mname,users.lname,users.id as user_id')
				 ->from( 'area')
				 ->join( 'users', 'users.id = area.assignee_id' )
				 ->where( 'area.level_id' , $level_id )
				 ->where( 'area.is_trash' , 1 )
				 ->order_by( 'area.area_name', 'ASC' );
		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function create($data)
	{
		if ( $this->db->insert( $this->table , $data ) )
			return $this->db->insert_id();	// return newly added data id
		else 
			return false; // error, fail on create
	}

	public function update($data)
	{
		$this->db->where('id',$data['id']);
		$query = $this->db->update( $this->table, $data );

		if ($query)
			return true;
		else 
			return false;
	}

	public function trash($data)
	{
		if ( $this->db->where( 'id' , $data->id )->update( $this->table, ['is_trash' => 1] ) )
			return $data->id;	
		else 
			return false;	
	}

	public function delete($data)
	{
		if ( $this->db->delete($this->table, array('id' => $data->id)) ) {
			// Delete areas with this level id
			$this->db->delete( 'area', array( 'level_id' => $data->id ) );
			
			return true;
		} else {
			return false;
		}
	}	
}