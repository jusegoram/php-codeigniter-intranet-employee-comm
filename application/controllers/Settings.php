<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
@Name 			:
@Description 	: 
@Created By 	: 
@Created Date 	: 
@Updated Date 	:
@Version 		: 1.0
*/

class Settings extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Settings_model');
		is_user_login();
		is_user_employee(array(3,4));
		password_change_or_expire();
	}
	//================================================

	/*
	* This is index function for getting information about users
	* @author 		:
	* @createdOn	: 
	*/
	public function index()
	{
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session ;
		$data['title'] 			= 'Settings';
		$data['page_js'] 		= 'settings_js';
		$data['navBarNumber'] 	= 9;

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 			= $csrf;

		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('password_expiry_time', 'Password Expire Time', 'trim|required|xss_clean|strip_tags|numeric|callback_check_card');
			
			if( $this->form_validation->run() == FALSE )
			{
				$this->session->set_flashdata('warning', 'All field is required!');
				$data['errors'] = validation_errors();
			}
			else
			{
				$expire_time 	= $this -> input -> post('password_expiry_time', TRUE);
				$insert_record  = array(
					'password_expire_time' 	=> $expire_time
				);

				$record_check 	= $this->Settings_model->find_all();

				if( !empty($record_check) )
				{
					$this->Settings_model->update( $insert_record, $record_check[0]->id);
					$this->session->set_flashdata('success', 'Password expire time updated successfully.');
					redirect('/home/index');
				}
				else if(empty($record_check))
				{
					$this->Settings_model->add( $insert_record);
					$this->session->set_flashdata('success', 'Password expire time added successfully.');
					redirect('/home/index');
				}
				else
				{
					$this->session->set_flashdata('error', 'Password expire time insertion failed.');
					$data['errors'] = validation_errors();
				}	
			}
		}

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Settings/password_settings', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	function check_card( $string )
	{
		if( check_card_number($string) )
		{
			$this->form_validation->set_message("check_card", 'The field is not valid');
			return FALSE;
		} 
		else
		{
			return TRUE;
		}
	}
	//================================================
}