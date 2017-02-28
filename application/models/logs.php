<?php 
class Logs extends CI_Model {
	private $table = 'logs';

	public function get()
	{
		$query = $this->db->order_by( 'created_at' , 'desc' )
		  				  ->limit(30)
		  				  ->where( 'course_id', $this->session->userdata('course_id') )
						  ->get($this->table);

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
}