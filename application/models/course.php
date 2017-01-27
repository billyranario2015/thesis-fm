<?php 
class Course extends CI_Model {
	private $table = 'courses';

	public function create($data)
	{
		if ( $this->db->insert( $this->table , $data ) )
			return $this->db->insert_id();	// return newly added data id
		else 
			return false; // error, fail on create
	}

	public function get()
	{
		$this->db->select( 'courses.id as course_id, courses.course_name, organization.id as organization_id, organization.organization_name' )
				 ->from( $this->table )
				 ->join( 'organization', 'organization.id = courses.organization_id' )
				 ->order_by( 'courses.course_name', 'ASC' );
		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function get_course_by_id($data)
	{
		$this->db->where('id',$data);
		$query = $this->db->get($this->table);

		if ($query->num_rows() == 1)
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