<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome_quotes extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Welcome_quotes_model');
		is_user_login();
		is_user_employee(array(3,4));
		password_change_or_expire();
	}
	//================================================
	
	public function index()
	{
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['title'] 			= 'Welcome Quotes';
		$data['page_js'] 		= 'welcome_quotes_js';
		$data['navBarNumber'] 	= 4;

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;

		$data['site_url'] 		= site_url();
		$data['base_url'] 		= base_url();
		$data['logout_url']		= site_url('user/logout');
		// $data['results'] 		= $this->Welcome_quotes_model->find_all();
		
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Welcome_quotes/index', $data);
		$this->load->view('layouts/footer');
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
			
			// $results 						= $this->Welcome_quotes_model->find_all( true );
			$results 						= $this->Welcome_quotes_model->find_all_pagination( $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by']);
			
			$response['data']            	= $this->user_filter( $results, $query_parameter['start']+1 );
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
					$str = "welcome_quote";
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
	public function user_filter($user_lists, $index )
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
					$filtered_da['id'] 				= $i;
					$filtered_da['welcome_quote'] 	= $users->welcome_quote;
					$filtered_da['action'] 			= site_url('welcome_quotes').'~'.$users->id.'~'.$user_type;
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
		$data['navBarNumber'] 	= 4;
		$this->load->model('user_model');

		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['page_js'] 		= 'welcome_quotes_js';
		$data['title'] 			= 'Welcome Quote';

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 			= $csrf;
		$data['results'] 		= $this->user_model->find_all(1);
		
		$this->load->library('encrypt');
		
		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('welcome_quote', 'Welcome Quote', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('welcome_quote_date', 'Quotes Date', 'trim|required|xss_clean|strip_tags');
			
			if( $this->form_validation->run() == FALSE )
			{
				$this->session->set_flashdata('warning', 'All field is required.');
				$data['errors'] = validation_errors();
			}
			else
			{
				$welcome_quote 			= $this->input->post('welcome_quote', TRUE);
				$welcome_quote_date 	= strtotime($this->input->post('welcome_quote_date', TRUE));

				$insert_record = array(
					'welcome_quote' 		=> $welcome_quote,
					'welcome_quote_date'	=> $welcome_quote_date,
					'created_date'			=> time()
				);
				
				if( $this->Welcome_quotes_model->add( $insert_record ) )
				{
					$this->session->set_flashdata('success','Quotes added successfully!');
					redirect('Welcome_quotes/index');
				}
				else
				{
					$this->session->set_flashdata('error','Quotes not added!');
				}	
			}
		}	
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Welcome_quotes/create', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	public function edit( $id )
	{
		$data['navBarNumber'] 	= 4;
		$this->load->model('user_model');
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['page_js'] 		= 'welcome_quotes_js';
		$data['title'] 			= 'Welcome Quote';
		$data['results'] 		= $this->user_model->find_all(1);

		$data['result'] 		= '';
		$is_exists 				= $this->Welcome_quotes_model->quotes_id_exists( $id );

		if( $is_exists )
		{
			$result 		= $this->Welcome_quotes_model->find( $id );
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
			$this->form_validation->set_rules('welcome_quote', 'Welcome Quote', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('welcome_quote_date', 'Quotes Date', 'trim|required|xss_clean|strip_tags');
			
			if( $this->form_validation->run() == FALSE )
			{
				$this->session->set_flashdata('warning', 'All field is required.');
				$data['errors'] = validation_errors();
			}
			else
			{
				$welcome_quote 			= $this->input->post('welcome_quote', TRUE);
				$welcome_quote_date 	= strtotime($this->input->post('welcome_quote_date', TRUE));

				$insert_record = array(
					'welcome_quote' 		=> $welcome_quote,
					'welcome_quote_date'	=> $welcome_quote_date,
					'updated_date'			=> time()
				);
				
				if( $this->Welcome_quotes_model->update( $insert_record, $id ) )
				{
					$this->session->set_flashdata('success','Quotes Updated successfully!');
					redirect('Welcome_quotes/index');
				}
				else
				{
					$this->session->set_flashdata('error','Quotes not updated!');
				}	
			}
		}	
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Welcome_quotes/edit', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================
	
	public function remove()
	{
		if ($this->input->is_ajax_request()) {

			$id 			= $this -> input -> post('id');

			if( $this->Welcome_quotes_model->delete($id) )
			{
				$da['success'] 	= 1;
				$da['id'] 		= $id;
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