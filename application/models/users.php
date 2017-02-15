<?php 
class Users extends CI_Model {
	private $table = 'users';

	public function get_all_users()
	{
		$this->db->select( 'users.id as user_id, users.course_id, users.fname, users.mname, users.lname, users.email, users.user_level, users.role, courses.id, courses.course_name, organization.organization_name' )
				 ->from( $this->table )
				 ->join( 'courses', 'courses.id = users.course_id' )
				 ->join( 'organization', 'organization.id = courses.organization_id' );
		$query = $this->db->get();

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function get_user($data)
	{
		$this->db->select( 'users.id as id, users.course_id, users.fname, users.mname, users.lname, users.email, users.user_level, users.role, courses.id as course_id, courses.course_name, organization.organization_name, organization.id as organization_id' )
				 ->where('email',$data['email'])
				 ->where('password',sha1($data['password']))
				 ->join( 'courses', 'courses.id = users.course_id' )
				 ->join( 'organization', 'organization.id = courses.organization_id' );
		$query = $this->db->get($this->table);

		if ($query->num_rows() == 1)
			return $query->row_array();
		else
			return array();
	}

	public function get_course_chairman($course_id)
	{
		$this->db->where('course_id',$course_id)
				 ->where('user_level',2);
		$query = $this->db->get($this->table);


		if ($query->num_rows() > 0)
			return $query->row_array();
		else
			return array();
	}

	public function get_user_auth($data)
	{
		$this->db->where('email',$data['email'])
				 ->where('password',sha1($data['password']));
		$query = $this->db->get($this->table);

		if ($query->num_rows() == 1)
			return $query->row_array();
		else
			return array();
	}

	public function get_user_by_id($data)
	{
		$this->db->where('id',$data);
		$query = $this->db->get($this->table);

		if ($query->num_rows() == 1)
			return $query->row_array();
		else
			return array();
	}

	public function get_all_users_by_course($data)
	{
		$this->db->where('course_id',$data);
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0 )
			return $query->result_array();
		else
			return array();
	}

	public function get_chairman_by_course_id($id)
	{
		
		$this->db->where('course_id',$id);
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0 )
			return $query->result_array();
		else
			return array();
	}

	public function get_users_by_course_with_level($course_id,$user_level)
	{
		$this->db->where('course_id',$course_id,$user_level)
				 ->where('user_level' , $user_level);
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0 )
			return $query->row_array();
		else
			return array();
	}

	public function create($data)
	{
		// Check if email exists
		$this->db->where('email',$data['email']);
		$is_exists = $this->db->get($this->table);

		if ( $is_exists->num_rows() > 0 ) {
			return [ 'status' => 'exists', 'message' => 'Email already exists.' , 'data' => null ];	
		} else {
			if ( $this->db->insert( $this->table , $data ) )
				return [ 'status' => 'success', 'message' => 'New user successfully created.' , 'data' => $this->db->insert_id() ];	
			else 
				return [ 'status' => 'error', 'message' => 'Error on creation.' , 'data' => null ];	
		}
	}

	public function update($data)
	{
		if ( $this->db->where( 'id' , $data['id'] )->update( $this->table, $data ) )
			return [ 'status' => 'success', 'message' => 'User successfully updated.' , 'data' => null ];	
		else 
			return [ 'status' => 'error', 'message' => 'Error on update.' , 'data' => null ];	
	}

	public function delete($data)
	{
		if ( $this->db->delete( $this->table, array('id' => $data->id) ) ) {
			return $data->id;
		} else {
			return false;
		}
	}

}