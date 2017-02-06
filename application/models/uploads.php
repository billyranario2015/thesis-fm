<?php 
class Uploads extends CI_Model {
	private $table = 'uploads';

	public function create($data)
	{
		if ( $this->db->insert( $this->table , $data ) )
			return $this->db->insert_id();	// return newly added data id
		else 
			return false; // error, fail on create
	}

	public function get($data)
	{
		$this->db->where( 'parameter_id', $data );
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function search($data)
	{
		$this->db->like('filename', $data->data)
				 ->where( 'shared_status',1 );
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function search_by_filename($data)
	{
		$this->db->where('id',$data);
		$query = $this->db->get($this->table);

		if ($query->num_rows() == 1)
			return $query->result_array();
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