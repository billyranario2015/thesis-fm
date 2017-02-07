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