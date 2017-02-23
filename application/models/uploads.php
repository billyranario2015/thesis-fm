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

	public function get($parameter_id)
	{
		$this->db->where( 'parameter_id' , $parameter_id );
		$query = $this->db->get($this->table);

		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	public function get_file_count($parameter_id,$child_count)
	{
		$this->db->where( 'parameter_id' , $parameter_id );
		$query = $this->db->get($this->table);

		/* 
		| If paramater has no child, then count the files inside this parameter and mark as complete
		| if empty, mark this parameter as incomplete
		*/
		$status = '';
		if ( $child_count == 0 ) {
			if ( $query->num_rows() > 0 ) { // if HAS files, mark as complete
				$status = 'complete';
			} else {
				$status = 'incomplete';
			}
		} else {
			// Store sub parameter's status
			$sub_paramater_status_arr = [];

			// Get sub parameters
			$sub_params = $this->get_sub_params($parameter_id);
			
			// Check sub parameters if HAS files
			foreach ($sub_params as $key => $sub) {
				// Get Child Parameter Count 
				$sub_child_count = $this->count_child_params($sub['id']);
				if ( $sub_child_count > 0 ) { // if HAS files, 
					array_push( $sub_paramater_status_arr, $this->get_file_count($sub['id'],$sub_child_count) );
				} else {
					array_push( $sub_paramater_status_arr, $this->get_file_count($sub['id'],$sub_child_count) );
				}
			}
			// $status = $sub_paramater_status_arr;
			if ( in_array('incomplete', $sub_paramater_status_arr) ) {
				$status = 'incomplete';
			} else {
				$status = 'complete';
			}

		}

		return $status;
	}

	public function get_sub_params($parameter_id)
	{
		$this->db->where( 'parent_id' , $parameter_id );
		$query = $this->db->get('area_parameters');

		return $query->result_array();
	}

	public function count_child_params($parameter_id)
	{
		$this->db->where( 'parent_id' , $parameter_id );
		$query = $this->db->get('area_parameters');

		return $query->num_rows();
	}

	public function search($data)
	{
		$this->db->select( 'uploads.id as upload_id, uploads.filename, uploads.parameter_id, uploads.description, uploads.shared_status, area_parameters.parameter_name,courses.course_name, courses.id as course_id' )
				 ->like('filename', $data->data, 'both')
				 ->or_like('description', $data->data, 'both')
				 ->where( 'shared_status', 1 )
				 ->join( 'area_parameters', 'area_parameters.id = uploads.parameter_id' )
				 ->join( 'area', 'area.id = area_parameters.area_id' )
				 ->join( 'courses', 'courses.id = area.course_id' );
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
			if ( file_exists( 'uploads/' . $data->filename ) ) {
				unlink( 'uploads/' . $data->filename );
			}
			return true;
		} else {
			return false;
		}
	}


	public function copy($data,$parameter_id)
	{
		$file_part = pathinfo('uploads/' . $data->filename);

		if (strpos($file_part['filename'], 'copy') !== false) {
			$get_original_filename =  substr($file_part['filename'], 0, -10) . '-copy' . $this->generateRandomString(5)	;
		} elseif( file_exists('uploads/'.$data->filename) ) {
			$get_original_filename =  $file_part['filename'] . '-copy' . $this->generateRandomString(5)	;
		} else {
			$get_original_filename = $file_part['filename'];
		}


		// Insert copied file data first to get the id
		$copy_id = $this->create([
			'filename'		=>	$get_original_filename .'.'.$file_part['extension'], 
			'parameter_id' 	=>  $parameter_id,
			'author_id'		=>  $this->session->userdata('id'),
			'description'	=>  $data->description,
		]);

		if ( $copy_id > 0 ) {
			if( copy( 'uploads/'.$data->filename , 'uploads/' . $get_original_filename .'.'.$file_part['extension'] ) )
				return 'true-1';
			else 
				return 'false-0';
		} else {
			return 'false-00';
		}
	}

	function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}	

}