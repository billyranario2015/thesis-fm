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

	public function search($data)
	{
		$this->db->select( 'uploads.id as upload_id, uploads.filename, uploads.parameter_id, uploads.description, uploads.shared_status, area_parameters.parameter_name,courses.course_name' )
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
		// Insert copied file data first to get the id
		$copy_id = $this->create([
			'filename'		=>	$file_part['filename']  . $this->generateRandomString(2) .'.'.$file_part['extension'], 
			'parameter_id' 	=>  $parameter_id,
			'description'	=>  $data->description,
		]);

		if ( $copy_id > 0 ) {
			copy( 'uploads/'.$data->filename , 'uploads/' . $file_part['filename']  . $this->generateRandomString(2) .'.'.$file_part['extension'] );
			return true;
		} else {
			return false;
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