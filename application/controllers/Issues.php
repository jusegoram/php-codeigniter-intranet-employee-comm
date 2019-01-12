<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Issues extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Logs_model');
		$this->load->model('Issues_model');
		is_user_login();
		is_user_employee(array(1,3,4,5,6));
		password_change_or_expire();
	}
	//================================================

	public function index()
	{
		$data['navBarNumber'] 	= 8;
		$data['title'] 			= 'Issues';
		$data['page_js'] 		= 'issues_js';
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 			= $csrf;
		
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Issues/index', $data);	
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
			
			$results 						= $this->Issues_model->find_all( false, true );
			$user_lists 					= $this->Issues_model->find_all_pagination( false, $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by']);
			
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

	public function manage_orderby_for_article($order_details)
	{
		if ($this->input->is_ajax_request()) {

			$column 	= $order_details[0]['column'];
			$type 		= $order_details[0]['dir'];
	 
			switch ($column)
			{
				case '0':
					$str = "id";
					return $str;
				break;
		
				case '1':
					$str = "issue_name";
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
	
	public function user_filter( $user_lists, $index )
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
					$filtered_da['id'] 			= $i;
					$filtered_da['issue_name'] 	= $users->issue_name;
					$color_class 				= ( $users->is_enabled == 1 ) ? 'green-class' : 'red-class';
					$filtered_da['action'] 		= site_url('issues').'~'.$users->id.'~'.$users->is_enabled.'~'.$color_class.'~'.$user_type;
					
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
		$data['navBarNumber'] 	= 8;
		$data['title'] 			= 'Add Issue';
		$data['page_js'] 		= 'logs_js';

		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
			
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;
		
		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('issue_name', 'Issue Name', 'trim|required|xss_clean|strip_tags|callback_check_card');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('warning', 'Issue addition failed.');
				$data['errors'] = validation_errors();
			}
			else
			{
				$issue_name 		= $this -> input -> post('issue_name', TRUE);
				$created_date 		= time();
				
				$insert_record = array(
					'issue_name' 		=> $issue_name,
					'created_date' 		=> $created_date
				);

				$this->Issues_model->add( $insert_record );
				$this->session->set_flashdata('success', 'Issue added successfully.');
				redirect('/Issues/index');
			}
		}

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Issues/create', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	public function edit( $id )
	{
		$data['navBarNumber'] 	= 8;
		$data['title'] 			= 'Edit Issue';
		$data['page_js'] 		= 'logs_js';

		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		
		$data['result'] 		= '';
		$is_exists 				= $this->Issues_model->issue_id_exists( $id );

		if( $is_exists )
		{
			$result 		= $this->Issues_model->find( $id );
			$data['result'] = $result;
		}	

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;
		
		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('issue_name', 'Issue Name', 'trim|required|xss_clean|strip_tags|callback_check_card');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('warning', 'Issue addition failed.');
				$data['errors'] = validation_errors();
			}
			else
			{
				$issue_name 		= $this -> input -> post('issue_name', TRUE);
				$created_date 		= time();
				
				$insert_record = array(
					'issue_name' 		=> $issue_name
				);


				$this->Issues_model->update( $insert_record, $id );
				$this->session->set_flashdata('success', 'Issue added successfully.');
				redirect('/Issues/index');
			}
		}

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Issues/edit', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================
	
	public function update()
	{
		if ($this->input->is_ajax_request()) {

			$id 			= $this -> input -> post('id');
			$is_enabled 	= $this -> input -> post('is_enabled');
			
			if( $is_enabled == 1 )
			{
				$is_enabled = 0;
			}
			else
			{
				$is_enabled = 1;
			}

			$update_record = array(
				'is_enabled' 		=> $is_enabled
			);

			if( $this->Issues_model->modified($update_record, $id) )
			{
				$da['success'] 	= 1;
				$da['id']		= $id;
			}
			else
			{
				$da['success'] 	= 0;
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

	function check_card( $string )
	{
		if(check_card_number($string))
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