<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class UploadController extends CI_Controller {

	public $table = 'uploads';

	public function upload()
	{
		$config = array ( 
			'upload_path' 	=> 'uploads/' ,
			'allowed_types'	=> '*' ,
		);

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('file_data'))
		{
	        $error = array('error' => $this->upload->display_errors());
	        echo json_encode( $error );
		}
		else
		{
	        $data = array('upload_data' => $this->upload->data());
	        
	        echo json_encode( $data );
		}

	}
}
