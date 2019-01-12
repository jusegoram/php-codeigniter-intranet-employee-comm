<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Performance extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Performance_model');
		$this->load->model('User_model');
		is_user_login();
		password_change_or_expire();
	}
	//================================================
	
	public function index()
	{
		$data['navBarNumber'] 	= 6;
		$data['title'] 			= 'Performance';
		$data['page_js'] 		= 'performance_js';
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['user_type'] 		= $user_session->user_type;
		$last_performance_array = array();

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;
		
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Performance/index', $data);
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
			
			if( $user_session->user_type == 2 )
			{
				$results 			= $this->Performance_model->find_all( $user_session->id, false, $search_str );
				$user_lists = $this->Performance_model->find_all_pagination( $user_session->id, false, $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by']);
			}
			elseif ( (1 == $user_session->user_type) || (5 == $user_session->user_type) || (6 == $user_session->user_type) )
			{
				$users 	= $this->User_model->find_all( false, $user_session->employee_id );

				$ids = '';
				if(!empty($users)){
					foreach ($users as $user) {
						$ids[]  =  $user->id;
					}
				}

				$results 	= $this->Performance_model->find_all( $ids, true, $search_str );
				$user_lists = $this->Performance_model->find_all_pagination( $ids, true, $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by']);
			}		
			else
			{
				$results 	= $this->Performance_model->find_all( false, false, $search_str );
				$user_lists = $this->Performance_model->find_all_pagination( false, false, $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by']);
			}

			
			// print_r($results);
			// die;

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
					$str = "first_name";
					return $str;
				break;
			
				case '2':
					$str = "performance_date";
					return $str;
				break;
			
				case '3':
					$str = "quality_commitment";
					return $str;
				break;
				
				case '4':
					$str = "adherence_commitment";
					return $str;
				break;
			
				case '5':
					$str = "hold_time_commitment";
					return $str;
				break;

				case '6':
					$str = "transfer_rate_commitment";
					return $str;
				break;
				
				case '7':
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
					
					// $filtered_data[$i] 							= $cms_pages_listing;
					$filtered_da['id'] 							= $i;
					$filtered_da['first_name'] 					= $users->first_name.' '.$users->last_name;
					$filtered_da['performance_date'] 			= date( 'Y-m-d H:i:s', $users->performance_date );
					$filtered_da['quality_commitment'] 			= $users->quality_commitment;
					$filtered_da['adherence_commitment'] 		= $users->adherence_commitment;
					$filtered_da['hold_time_commitment'] 		= $users->hold_time_commitment;
					$filtered_da['transfer_rate_commitment'] 	= $users->transfer_rate_commitment;
					$filtered_da['is_accepted'] 				= ( $users->is_accepted ) ? 'Yes' : 'No';
					$filtered_da['action'] 						= site_url('performance').'~'.$users->id.'~'.$user_type;
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
		is_user_employee(array(1,3,4,5,6));
		$data['title'] 			= 'Performance';
		$data['page_js'] 		= 'performance_js';
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['navBarNumber'] 	= 6;

		$user_type 				= ( 3 == $user_session->user_type ) ? 3 : ( 4 == $user_session->user_type ) ? 4 : false;
		$user_results 			= $this->User_model->find_all($user_type, $user_session->employee_id );
		
		$data['user_results'] 	= $user_results;

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;

		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('user_id', 'Employee', 'trim|required|xss_clean|strip_tags|alpha_numeric|callback_check_card');
			$this->form_validation->set_rules('performance_date', 'Performance Date', 'trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('quality_commitment', 'Quality', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('adherence_commitment', 'Adherence', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('hold_time_commitment', 'Hold Time', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('transfer_rate_commitment', 'Transfer Rate', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('manager_commitment', 'Manager Comment', 'trim|required|xss_clean|strip_tags|callback_check_card');

			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('warning', 'Performance addition failed.');
				$data['errors'] = validation_errors();
			}
			else
			{
				$user_id 					= $this -> input -> post('user_id', TRUE);
				$performance_date 			= strtotime($this -> input -> post('performance_date', TRUE));
				$quality_commitment 		= $this -> input -> post('quality_commitment', TRUE);
				$adherence_commitment		= $this -> input -> post('adherence_commitment', TRUE);
				$hold_time_commitment		= $this -> input -> post('hold_time_commitment', TRUE);
				$transfer_rate_commitment	= $this -> input -> post('transfer_rate_commitment', TRUE);
				$manager_commitment			= $this -> input -> post('manager_commitment', TRUE);
				
				$insert_record = array(
					'user_id' 					=> $user_id,
					'performance_date' 			=> $performance_date,
					'quality_commitment' 		=> $quality_commitment,
					'adherence_commitment' 		=> $adherence_commitment,
					'hold_time_commitment'		=> $hold_time_commitment,
					'transfer_rate_commitment' 	=> $transfer_rate_commitment,
					'manager_commitment'		=> $manager_commitment,
					'is_accepted' 				=> 0,
					'created_date' 				=> time()
				);

				if( $this->Performance_model->add( $insert_record ))
				{
					$this->session->set_flashdata('success', 'Performance added successfully.');
					redirect('/Performance/index');
				}
				else
				{
					$this->session->set_flashdata('errors', 'Performance not added.');
					redirect('/Performance/index');
				}
			}
		}

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Performance/create', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	public function edit( $id )
	{
		is_user_employee(array(1,3,4,5,6));
		$data['title'] 			= 'Performance';
		$data['page_js'] 		= 'performance_js';
		
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['navBarNumber'] 	= 6;

		$data['result'] 		= '';
		
		$user_type  	= ( 3 == $user_session->user_type ) ? 3 : ( 4 == $user_session->user_type ) ? 4 : false;		
		$user_results 	= $this->User_model->find_all($user_type, $user_session->employee_id );
		$data['user_results'] = $user_results;

		$is_exists_in_db 	= $this->Performance_model->performance_id_exists( $id );

		if( (1 == $user_session->user_type) || (5 == $user_session->user_type) || (6 == $user_session->user_type) )
		{
			$result 		= $this->Performance_model->find( $id );
			if( assigned_employees_list($result->user_id) )
			{
				$data['result'] = $result;
			}
		}
		else
		{
			$result 		= $this->Performance_model->find( $id );
			$data['result'] = $result;
		}
		
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 			= $csrf;

		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');

			$this->form_validation->set_rules('user_id', 'Employee ID', 'trim|required|xss_clean|strip_tags|alpha_numeric|callback_check_card');
			$this->form_validation->set_rules('performance_date', 'Performance Date', 'trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('quality_commitment', 'Quality Commitment', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('adherence_commitment', 'Adherence Commitment', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('hold_time_commitment', 'Hold Time Commitment', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('transfer_rate_commitment', 'Transfer Rate Commitment', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('manager_commitment', 'Manager Comment', 'trim|required|xss_clean|strip_tags|callback_check_card');

			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('warning', 'Performance addition failed.');
				$data['errors'] = validation_errors();
			}
			else
			{
				$user_id 			= $this -> input -> post('user_id', TRUE);
				$performance_date 	= strtotime($this -> input -> post('performance_date', TRUE));
				$quality_commitment 			= $this -> input -> post('quality_commitment', TRUE);
				$adherence_commitment			= $this -> input -> post('adherence_commitment', TRUE);
				$hold_time_commitment			= $this -> input -> post('hold_time_commitment', TRUE);
				$transfer_rate_commitment		= $this -> input -> post('transfer_rate_commitment', TRUE);
				$manager_commitment	= $this -> input -> post('manager_commitment', TRUE);
				
				$insert_record = array(
					'user_id' 					=> $user_id,
					'performance_date' 			=> $performance_date,
					'quality_commitment' 		=> $quality_commitment,
					'adherence_commitment' 		=> $adherence_commitment,
					'hold_time_commitment'		=> $hold_time_commitment,
					'transfer_rate_commitment' 	=> $transfer_rate_commitment,
					'employee_commitment'		=> '',
					'manager_commitment'		=> $manager_commitment,
					'updated_date' 				=> time(),
					'is_accepted' 				=> 0
				);

				$this->Performance_model->update( $insert_record, $id );
				$this->session->set_flashdata('success', 'Performance added successfully.');
				redirect('/Performance/index');
			}
		}

		$this->load->view( 'layouts/header', $data );
		$this->load->view( 'layouts/nav' );
		$this->load->view( 'Performance/edit', $data );
		$this->load->view( 'layouts/footer', $data );

	}
	//================================================

	public function details( $id )
	{
		$this->load->model('User_model');
		$data['title'] 			= 'Performance';
		$data['page_js'] 		= 'performance_js';
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['result'] 		= '';
		$data['navBarNumber'] 	= 6;
		$is_exists 				= $this->Performance_model->performance_id_exists( $id );

		if( $is_exists ) {
			
			if( ( 1 == $user_session->user_type) || ( 5 == $user_session->user_type ) || ( 6 == $user_session->user_type ) ) {
				
				$result 		= $this->Performance_model->find( $id );
				if( assigned_employees_list($result->user_id) )
				{
					$data['result'] = $result;
				}
			} else {
				
				$result 		= $this->Performance_model->find( $id );
				$data['result'] = $result;
			}
		}
		
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;
		
		if( count( $_POST ) > 0 ) {
			
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('employee_commitment', 'Comment', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('is_accepted', 'Aggrement Accept', 'trim|required|xss_clean|strip_tags');
			
			if( $this->form_validation->run() == FALSE ) {
				
				$this->session->set_flashdata('warning', 'Please enter required field');
				$data['errors'] = validation_errors();
			} else {
				
				$employee_commitment 	= $this -> input -> post('employee_commitment', TRUE);
				$is_accepted 			= $this -> input -> post('is_accepted', TRUE);

				if( !$is_accepted ){
					$this->session->set_flashdata('warning', 'Please accept aggrement & Terms.');
					redirect('/Performance/details' . $id );
				}
				
				$update_record = array(
					'employee_commitment' 	=> $employee_commitment,
					'is_accepted' 			=> 1
				);
				
				$this->Performance_model->update( $update_record, $id );
				$this->session->set_flashdata('success', 'Process is done.');
				redirect('/Performance/index');
			}
		}

		$this->load->view( 'layouts/header', $data );
		$this->load->view( 'layouts/nav' );
		$this->load->view( 'Performance/details', $data );
		$this->load->view( 'layouts/footer', $data );

	}
	//================================================

	public function remove()
	{
		is_user_employee(array(3,4));
		if ($this->input->is_ajax_request()) {

			$id 	= $this -> input -> post('id');

			if( $this->Performance_model->delete($id) )
			{
				$da['success'] 	= 1;
				$da['id'] 		= $id;
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