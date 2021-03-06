<?php 
class Area_Parameters extends CI_Model {
	private $table = 'area_parameters';

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

	// Get PARAMETERS by area ID
	public function get_by_area_id($id)
	{
		$this->db->where( 'area_id' , $id )
				 ->order_by( 'parameter_name', 'ASC' );
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function get_child_by_parent_id($parent_id,$area_id)
	{
		$this->db->where( 'area_id' , $area_id )
				 ->where( 'parent_id' , $parent_id )
				 ->where( 'is_trash' , 0 )
				 ->order_by( 'id', 'ASC' );
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function get_child_by_parent_id_neutral($parent_id,$area_id)
	{
		$this->db->where( 'area_id' , $area_id )
				 ->where( 'parent_id' , $parent_id )
				 ->order_by( 'id', 'ASC' );
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function get_child_parameters_bulk($parent_id)
	{
		$this->db->select( 'area_parameters.*, area_parameters.id as area_parameter_id, area.*, area.id as area_area_id' )
				 ->where( 'parent_id' , $parent_id )
				 ->where( 'area.course_id' , $this->session->userdata('course_id') )
				 ->join( 'area', 'area.id = area_parameters.area_id' )
				 ->order_by( 'area_parameters.id', 'ASC' );
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function count_child_params($parameter_id)
	{
		$this->db->where( 'parent_id' , $parameter_id )
				 ->where( 'is_trash' , 0 );
		$query = $this->db->get($this->table);

		return $query->num_rows();
	}

	public function count_child_params_neutral($parameter_id)
	{
		$this->db->where( 'parent_id' , $parameter_id );
		$query = $this->db->get($this->table);

		return $query->num_rows();
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
		$this->db->where('id',$data->id);
		$query = $this->db->update( $this->table, $data );
		
		if ( $query )
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

	public function restore($data)
	{
		if ( $this->db->where( 'id' , $data['id'] )->update( $this->table, ['is_trash' => 0] ) )
			return $data['id'];	
		else 
			return false;
	}

	public function delete($data)
	{
		if ( $this->db->delete($this->table, array('id' => $data->id)) ) {
			//if this is a parent, delete childs
			if ( $this->db->delete($this->table, array('parent_id' => $data->id)) ) {
				return 	$data->id;
			}
			return true;
		} else {
			return false;
		}
	}
}