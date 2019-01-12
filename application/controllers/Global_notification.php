<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Global_notification extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('Global_notification_model');
		$this->load->model('User_model');
		is_user_login();
		password_change_or_expire();
	}
	//================================================

	public function index()
	{
		is_user_employee(array(3,4));
		$data['title'] 			= 'Global Notifications';
		$data['page_js'] 		= 'gobal_notification_js';
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['user_type'] 		= $user_session->user_type;
		$data['navBarNumber'] 	= 10;

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;

		$data['results'] = $results;
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Global_notification/index', $data);
		$this->load->view('layouts/footer', $data);
	}
	
	//================================================

	public function pagination()
	{
		if ($this->input->is_ajax_request()) {

			$csrf = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			$start 							= $this->input->post('start');
			$length	 						= $this->input->post('length');
			$order_details               	= $this->input->post('order');
			$search_str 					= $this->input->post('search');
			
			$response['draw']            	= $this->input->post('draw');
			
			$query_parameter['start']    	= empty($start) ? 0 : $start;
			$query_parameter['limit']    	= empty($length) ? 10 : $length;
			$query_parameter['order_by'] 	= $this->manage_orderby_for_article($order_details);
			$query_parameter['type'] 		= $order_details[0]['dir'];

			$search_str 					= $search_str['value'];

			$user_session					= $this->session->userdata('USER_SESSION');
			
			$results 	= $this->Global_notification_model->find_all( false, false, $search_str, 2 );
			$user_lists = $this->Global_notification_model->find_all_pagination( false, false, $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by'], 2);
			
			$response['data']            	= $this->user_filter( $user_lists, $query_parameter['start']+1 );
			$response['recordsFiltered'] 	= (!empty($results)) ? count($results) :0;
			
			$response['recordsTotal']   	= (!empty($results)) ? count($results) :0;
			$response['hash_token']   		= $this->security->get_csrf_hash();
			echo json_encode($response);
			exit;
		}
		else
		{
			$this->session->set_flashdata('warning','No direct script access allowed!');
			redirect('/home/index');
		}	
	}
	//================================================

	/* ajax order by category */
	public function manage_orderby_for_article($order_details)
	{
		if ($this->input->is_ajax_request()) {

			$column 	= $order_details[0]['column'];
			$type 		= $order_details[0]['dir'];
	 
			switch ($column)
			{
		
				// by default order byid
				case '0':
					$str = "id";
					return $str;
				break;
		
				// order by title
				case '1':
					$str = "notification_type";
					return $str;
				break;
			
				case '2':
					$str = "notification_date";
					return $str;
				break;
				
				case '3':
					$str = "document_name";
					return $str;
				break;
			
				case '4':
					$str = "submit_first_name";
					return $str;
				break;

				case '5':
					$str = "is_accepted";
					return $str;
				break;
			}
		}
		else
		{
			$this->session->set_flashdata('warning','No direct script access allowed!');
			redirect('/home/index');
		}	
	}
	//================================================
	
	/* ajax article filter */
	public function user_filter($user_lists, $index)
	{
		if ($this->input->is_ajax_request()) {

			$filtered_data	 = array();
			$record 		 = array();
			
			$user_session	 = $this->session->userdata('USER_SESSION');
			$user_type 		 = $user_session->user_type;

			if(!empty($user_lists))
			{
				$i = $index;

				foreach($user_lists as $key => $users)
				{
					
					//$filtered_data[$i] 						= $cms_pages_listing;
					$filtered_da['id'] 					= $i;
					$filtered_da['first_name'] 			= $users->first_name.' '.$users->last_name;
					$filtered_da['notification_type'] 	= ( 1 == $users->notification_type ) ? 'Warning' : (( 2 == $users->notification_type ) ? 'Agreement' : 'Training');
					$filtered_da['notification_date'] 	= date( 'Y-m-d H:i:s', $users->notification_date );
					$filtered_da['document_name'] 		= $users->document_name;
					$filtered_da['submit_first_name'] 	= $users->submit_first_name.' '.$users->submit_last_name;
					$filtered_da['is_accepted'] 		= ( $users->is_accepted ) ? 'Yes' : 'No';
					$filtered_da['action'] 				= site_url('global_notification').'~'.$users->id.'~'.$user_type;
						// echo site_url('user/edit');
						// die;
					// $filtered_da['csrf'] 	= $this->security->get_csrf_hash();

				$filtered_data[] = $filtered_da;
				$i++;
				}
			}
			return $filtered_data;
		}
		else
		{
			$this->session->set_flashdata('warning','No direct script access allowed!');
			redirect('/home/index');
		}
	}
	//================================================

	public function create()
	{
		is_user_employee(array(3,4));
		$data['navBarNumber'] 	= 10;
		$data['title'] 			= 'Global Notification';
		$data['page_js'] 		= 'gobal_notification_js';
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 			= $csrf;

		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('notification_type', 'Notification Type', 'trim|required|xss_clean|strip_tags|alpha_numeric|callback_check_card');
			$this->form_validation->set_rules('notification_date', 'Notification Date', 'trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('document_name', 'Document Name', 'trim|required|xss_clean|strip_tags|alpha_numeric|callback_check_card');
			$this->form_validation->set_rules('manager_comment', 'Manager Comment', 'trim|required|xss_clean|strip_tags|callback_check_card');

			$notification_text 	= $this -> input -> post('notification_text', TRUE);
			$file 				= $_FILES['file_name'];
			$file_name 			= $file['name'];
			$file_type 			= $file['type'];
			$file_exists 		= $file['name'];


			if( empty($notification_text) && empty($file_name) && empty($file_type) ){
				$this->form_validation->set_rules('file_name', 'File', 'trim|required|xss_clean|strip_tags');
			} elseif( !empty($notification_text) ) {
				$this->form_validation->set_rules('notification_text', 'Notification Text', 'trim|required|xss_clean|strip_tags|callback_check_card');
			}

			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('warning', 'Global notification addition failed.');
				$data['errors'] = validation_errors();
			}
			else
			{
				$notification_type 	= $this -> input -> post('notification_type', TRUE);

				$notification_date 	= strtotime($this -> input -> post('notification_date', TRUE));
				$document_name		= $this -> input -> post('document_name', TRUE);
				$manager_comment	= $this -> input -> post('manager_comment', TRUE);
				

				$file_name 			= space_to_symbol($file_name);
				$file_ext 			= get_extention($file_name);
				$file_name 			= get_extention($file_name, 'filename');
				$file_name 			= $file_name .'_' . time() . '.' . $file_ext;
 			
				$path = NOTIFICATION_ROOT_UPLOAD_PATH . '/';

				$user_type 			= ( $user_session->user_type == 3 ) ? 3 : ( $user_session->user_type == 4 ) ? 4 : false;
				$user_results 		= $this->User_model->find_all($user_type, $user_session->employee_id );
				$is_upload 			= 0;

				$created_date 			= time();
				$global_notification_id = $user_session->id.'-'.time();

				if( !empty($file_exists) ) {

					if( ($file_ext == 'pdf') || ($file_ext == 'PDF') || ($file_ext == 'mp4') || ($file_ext == 'MP4') ) {

						$is_error = $this->do_upload($file_name, $field_name='file_name', $path);
						
						if( $is_error['error'] ){
							
							$this->session->set_flashdata('warning', 'The file you are attempting to upload is not allowed.');
							$is_upload = 0;
						} else {
							
							if( !empty($user_results) ) {

								$total_length = count($user_results);
								$counter 	  = 0;

								foreach ($user_results as $users_id) {
									
									$insert_record = array(
										
										'user_id' 			=> $users_id->id,
										'notification_type' => $notification_type,
										'notification_date' => $notification_date,
										'notification_text' => $notification_text,
										'document_name' 	=> $document_name,
										'file_name'			=> $file_name,
										'manager_comment'	=> $manager_comment,
										'submitted_by' 		=> $user_session->id,
										'is_global' 		=> 2,
										'is_accepted' 		=> 0,
										'created_date' 		=> time()
									);

									$this->Global_notification_model->add( $insert_record );
									$counter++;
								}
								$is_upload = 1;
							}
						}

					} else {
						$this->session->set_flashdata('warning', 'Please select only pdf files!');
					}
				} else {

					if( !empty($user_results) ) {

						$total_length = count($user_results);
						$counter 	  = 0;
						foreach ($user_results as $users_id) {
							
							$insert_record = array(
								'user_id' 			=> $users_id->id,
								'notification_type' => $notification_type,
								'notification_date' => $notification_date,
								'notification_text' => $notification_text,
								'document_name' 	=> $document_name,
								'manager_comment'	=> $manager_comment,
								'submitted_by' 		=> $user_session->id,
								'is_accepted' 		=> 0,
								'is_global' 		=> 2,
								'created_date' 		=> time()
							);
							$this->Global_notification_model->add( $insert_record );
							$counter++;
						}
						$is_upload = 1;
					}
				}

				if( 1 == $is_upload ) {
								
					$this->session->set_flashdata('success', 'Global notification added successfully.');
					redirect('/global_notification/index');
				}
			}
		}

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Global_notification/create', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	public function edit( $id )
	{
		is_user_employee(array(3,4));

		$data['navBarNumber'] 	= 10;
		$data['title'] 			= 'Global Notification';
		$data['page_js'] 		= 'gobal_notification_js';
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		
		$data['result'] 		= '';
		$is_exists 				= $this->Global_notification_model->notification_id_exists( $id );

		$user_type  	= ( $user_session->user_type == 3 ) ? 3 : ( $user_session->user_type == 4 ) ? 4 : false;
		$user_results 	= $this->User_model->find_all($user_type, $user_session->employee_id );
		$data['user_results'] = $user_results;

		$result 		= $this->Global_notification_model->find( $id );
		$data['result'] = $result;
		
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;

		$file_ext = ( $result->file_name ) ? '.'.substr(strrchr($result->file_name,'.'),1) : '';
		$data['file_ext'] = $file_ext;

		$result = (array)$result;
		unset($result['id'], $result['user_id'], $result['file_name'], $result['employee_comment'], $result['is_accepted'], $result['created_date'], $result['updated_date'], $result['is_enabled'], $result['first_name'], $result['last_name'], $result['submit_first_name'], $result['submit_last_name'], $result['user_type'] );

		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('notification_type', 'Notification Type', 'trim|required|xss_clean|strip_tags|alpha_numeric|callback_check_card');
			$this->form_validation->set_rules('notification_date', 'Notification Date', 'trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('document_name', 'Document Name', 'trim|required|xss_clean|strip_tags|alpha_numeric|callback_check_card');
			$this->form_validation->set_rules('manager_comment', 'Manager Comment', 'trim|required|xss_clean|strip_tags|callback_check_card');
			
			$notification_text 	= $this -> input -> post('notification_text', TRUE);
			$uploaded_file 		= $this -> input -> post('uploaded_file', TRUE);

			$file 				= $_FILES['file_name'];
			$file_name 			= $file['name'];
			$file_type 			= $file['type'];
			$file_exists 		= $file['name'];

			if( empty($notification_text) && empty($file_name) && empty($file_type) && empty($uploaded_file) ){
				
				$this->form_validation->set_rules('file_name', 'File', 'trim|required|xss_clean|strip_tags');
			}

			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('warning', 'Global notification addition failed.');
				$data['errors'] = validation_errors();
							    			    
			}
			else
			{
				$notification_type 	= $this -> input -> post('notification_type', TRUE);
				$notification_date 	= strtotime($this -> input -> post('notification_date', TRUE));
				$document_name		= $this -> input -> post('document_name', TRUE);
				$manager_comment 	= $this -> input -> post('manager_comment', TRUE);
				
				$file_name 			= space_to_symbol($file_name);
				$file_ext 			= get_extention($file_name);
				$file_name 			= get_extention($file_name, 'filename');
				$file_name 			= $file_name .'_' . time() . '.' . $file_ext;
 				// $is_upload 			= 1;

				$path = NOTIFICATION_ROOT_UPLOAD_PATH . '/';

				if( !empty($file_exists) ) {
					
					if( ($file_ext == 'pdf') || ($file_ext == 'PDF') || ($file_ext == 'mp4') || ($file_ext == 'MP4') ) {

						$is_error = $this->do_upload($file_name, $field_name='file_name', $path);
							
						if( $is_error['error'] ){
							
							$this->session->set_flashdata('warning', 'The file you are attempting to upload is not allowed.');
						} else {

							$update_record = array(
								'notification_type' => $notification_type,
								'notification_date' => $notification_date,
								'notification_text' => $notification_text,
								'document_name' 	=> $document_name,
								'file_name' 		=> $file_name,
								'manager_comment' 	=> $manager_comment,
								'submitted_by' 		=> $user_session->id,
								'is_global' 		=> 2,
								'is_accepted' 		=> 0,
								'updated_date' 		=> time()
							);

							
							$this->Global_notification_model->update( $update_record, $id );
							$this->session->set_flashdata('success', 'Global notification updated successfully.');
							redirect('/Global_notification/index');
						}

					} else {
						$this->session->set_flashdata('warning', 'Please select only pdf files!');
					}
				} else {

					$update_record = array(
					
						'notification_type' => $notification_type,
						'notification_date' => $notification_date,
						'notification_text' => $notification_text,
						'document_name' 	=> $document_name,
						'manager_comment' 	=> $manager_comment,
						'submitted_by' 		=> $user_session->id,
						'is_global' 		=> 2
					);

					if( array_diff($result, $update_record) ) {
						$update_record['employee_comment'] ='';
						$update_record['is_accepted'] = 0;
						$update_record['updated_date'] = time();
					}

					$this->Global_notification_model->update( $update_record, $id );
					$this->session->set_flashdata('success', 'Global notification updated successfully.');
					redirect('/Global_notification/index');
				}
			}
		}

		$this->load->view( 'layouts/header', $data );
		$this->load->view( 'layouts/nav' );
		$this->load->view( 'Global_notification/edit', $data );
		$this->load->view( 'layouts/footer', $data );
	}
	//================================================

	public function details( $id )
	{

		$data['title'] 			= 'Global Notification';
		$data['page_js'] 		= 'gobal_notification_js';
		$data['navBarNumber'] 	= 10;
		
		$user_session			= $this->session->userdata('USER_SESSION');

		$user_id = $user_session->id;

		$data['user_session'] 	= $user_session;

		$this->load->model('User_model');

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 		= $csrf;
		$data['result'] 	= '';
		$is_exists 			= $this->Global_notification_model->notification_id_exists( $id );

		// if( empty($is_exists) )
		// {
		// 	$this->session->set_flashdata('error', 'Record not existed.');
		// 	redirect('/home/index');
		// }

		// $result 		= $this->Global_notification_model->find( $id );
		// $data['result'] = $result;

		// print('<pre>');
		// print_r($user_session->id);
		// print_r($result->user_id);
		// die;

		// if( (1 == $user_session->user_type) || (5 == $user_session->user_type) || (6 == $user_session->user_type) || (2 == $user_session->user_type) )
		// {
		// 	if( $result->user_id !== $user_session->id ){

		// 		$this->session->set_flashdata('error', 'You are not authorised person to access another record.');
		// 		// $data['errors'] = validation_errors();
		// 		redirect('/Home/index');
		// 	}
		// }


		if( $is_exists ) {
			
			$result 		= $this->Global_notification_model->find( $id );

			if( 1 == $user_session->user_type ) {
				
				if( $user_session->id == $result->user_id ){
					
					$data['result'] = $result;
				} elseif( (2 == $result->user_type) || (5 == $result->user_type) || (6 == $result->user_type)  ) {
					
					$data['result'] = $result;
				}
			} elseif( ( 5 == $user_session->user_type ) || ( 6 == $user_session->user_type ) ) {
				
				if( $user_session->id == $result->user_id ){
					
					$data['result'] = $result;
				} elseif( assigned_employees_list($result->user_id) ) {
					
					$data['result'] = $result;
				}
			} elseif( 2 == $user_session->user_type ) { 
					
				if( $result->user_id !== $user_session->id ){

					$this->session->set_flashdata('error', 'You are not authorised person to access another record.');
					// $data['errors'] = validation_errors();
					redirect('/Home/index');
				}
				$data['result'] = $result;
			} else {
				
				$data['result'] = $result;
			}
		}

		// print('<pre>');
		// print_r($user_session);
		// print_r($result);
		// die;

		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('employee_comment', 'Comment', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('is_accepted', 'Agreement Accept', 'trim|xss_clean|strip_tags|required');

			if( $this->form_validation->run() == FALSE )
			{
				$this->session->set_flashdata('warning', 'Please enter required field');
				$data['errors'] = validation_errors();
			}
			else
			{
				$employee_comment 	= $this -> input -> post('employee_comment', TRUE);
				$is_accepted 		= $this -> input -> post('is_accepted', TRUE);

				if( !$is_accepted )
				{
					$this->session->set_flashdata('warning', 'Please accept agreement & Terms.');
					redirect('/Global_notification/details' . $id );
				}
				
				$update_record = array(
					'employee_comment' 	=> $employee_comment,
					'is_accepted' 		=> 1
				);

				$this->Global_notification_model->update( $update_record, $id );


				// $update_record = array(
				// 	'user_id' 			=> $user_id,
				// 	'notification_id' 	=> $id,
				// 	'comment' 			=> $employee_comment,
				// 	'is_accepted' 		=> 1
				// );

				// $this->Notification_comment_model->add( $update_record );

				$this->session->set_flashdata('success', 'Global notification accepted.');
				
				if( (1 == $user_session->user_type) || (5 == $user_session->user_type) || (6 == $user_session->user_type) ){
					redirect('/home/index');
				} else {
					redirect('/Notification/index');
				}
			}
		}

		$this->load->view( 'layouts/header', $data );
		$this->load->view( 'layouts/nav' );
		$this->load->view( 'Global_notification/details', $data );
		$this->load->view( 'layouts/footer', $data );
	}
	//================================================

	public function remove()
	{
		is_user_employee(array(3,4));
		if ($this->input->is_ajax_request()) {

			$id 	= $this -> input -> post('id');

			if( $this->Global_notification_model->delete($id) )
			{
				$da['success'] = 1;
				$da['id'] = $id;
			}
			else
			{
				$da['success'] = 0;
			} 

			$da['hash_token'] = $this->security->get_csrf_hash();
			echo json_encode($da);
			die;
		}
		else
		{
			$this->session->set_flashdata('warning','No direct script access allowed!');
			redirect('/home/index');
		}
	}
	//================================================

	public function delete_file()
	{
		is_user_employee(array(3,4));
		if ($this->input->is_ajax_request()) {

			$id 	= $this -> input -> post('id');

			$update_file =array(
				'file_name' => ''
			);

			if( $this->Global_notification_model->update($update_file, $id) )
			{
				$da['success'] = 1;
				$da['id'] = $id;
			}
			else
			{
				$da['success'] = 0;
			} 

			$da['hash_token'] = $this->security->get_csrf_hash();
			echo json_encode($da);
			die;
		}
		else
		{
			$this->session->set_flashdata('warning','No direct script access allowed!');
			redirect('/home/index');
		}
	}
	//================================================

	function do_upload( $file_name, $field_name, $path )
	{
		$config['upload_path'] 		= $path;
		$config['allowed_types'] 	= 'pdf|mp4';
		$config['file_name']     	= $file_name;
		$config['max_size']			= '5120';
		// $config['max_width']  	= '1024';
		// $config['max_height']  	= '768';
		
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload( $field_name ))
		{
			$error = array('error' => $this->upload->display_errors());
			return $error;
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			return $data;
		}
	}
	//================================================

	function check_card( $string )
	{
		if( check_card_number($string) )
		{
			$this->form_validation->set_message("check_card", 'Chain numbers are not allowed');
			return FALSE;
		} 
		else
		{
			return TRUE;
		}
	}
	//================================================
}