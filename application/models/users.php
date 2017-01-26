<?php 
class Users extends CI_Model {
	private $table = 'users';

	public function get_user($data)
	{
		$this->db->where('email',$data['email'])
				 ->where('password',sha1($data['password']));
		$query = $this->db->get($this->table);

		if ($query->num_rows() == 1)
			return $query->row_array();
		else
			return array();
	}

}