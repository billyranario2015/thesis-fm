<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {


	public function admin_page($tpl)
	{
		/*
		| -------------------------------------------------------------------------
		| IF user_level != 1  -- redirect to its corresponding page
		| -------------------------------------------------------------------------
		*/
		if ( $this->session->userdata('user_level') != 1 ) {
			redirect( base_url( 'user/dashboard' ) );
		}

		$data = array(
			'tpl' => $tpl,
		);

		if ( $tpl == 'create-organization' ) {
			$data['tpl'] = 'organizations';
			$data['tpl2'] = 'create-organizations';
		} elseif ( $tpl == 'organizations' ) {
			$data['tpl'] = 'organizations';
			$data['tpl2'] = 'organizations';
			$data['orgs'] = $this->org->get();
		}

		$this->load->view('admin/pages/'.$tpl , $data);
	}


	public function create_organization()
	{
		$id = $this->org->create($_POST);
		if ( $id ) {
			$this->session->set_flashdata( 'message' , 'Organization successfully created.' );
			redirect( base_url( 'admin/organization/'.$id.'/edit' ) );
		}
	}

	public function edit_organization($id)
	{
		$data = array(
			'tpl' => 'organizations',
			'data' => $this->org->get_by_id($id)
		);
		$this->load->view('admin/pages/edit-organization',$data);
	}

	public function update_organization()
	{
		$data = array(
			'tpl' => 'organizations',
		);
		if ( $this->org->update($_POST) ) {
			$this->session->set_flashdata( 'message' , 'Organization successfully update.' );
			redirect( base_url( 'admin/organization/'.$_POST['id'].'/edit' ) );
		}
	}

	public function delete_organization($id)
	{
		if ( $this->org->delete($id) ) {
			$this->session->set_flashdata( 'message' , 'Organization successfully removed.' );
			redirect( base_url( 'admin/organizations/' ) );
		}
	}
}

