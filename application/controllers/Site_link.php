<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_link extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Site_link_model');
		is_user_login();
		password_change_or_expire();
	}
	//================================================

	public function index()
	{
		$data['navBarNumber'] 	= 2;
		$data['title'] 			= 'Site Links';
		$data['page_js'] 		= 'site_link_js';
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session ;
		$data['user_type'] 		= $user_session->user_type;

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;

		$results 				= $this->Site_link_model->find_all();
		$data['results'] 		= $results;

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');

		if( $user_session->user_type != 2 )
		{
			$this->load->view('Site_link/index', $data);
		}
		else
		{
			$this->load->view('Site_link/view', $data);
		}
		
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
			
			$countTotalRecords				= $this->Site_link_model->find_all_pagination( $search_str,fasle, false, $query_parameter['type'], $query_parameter['order_by']);

			$results 						= $this->Site_link_model->find_all_pagination( $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by']);
			
			$response['data']            	= $this->user_filter( $results, $query_parameter['start']+1 );
			$response['recordsFiltered'] 	= (!empty($countTotalRecords)) ? count($countTotalRecords) :0;
			
			// print_r($response['data']);
			// die;

			$response['recordsTotal']   	= (!empty($countTotalRecords)) ? count($countTotalRecords) :0;
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
					$str = "title";
					return $str;
				break;
			
				case '2':
					$str = "url";
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
					$filtered_da['id'] 		= $i;
					$filtered_da['title'] 	= $users->title;
					$filtered_da['url'] 	= $users->url;
					$filtered_da['action'] 	= site_url('site_link').'~'.$users->id.'~'.$user_type;
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
		$data['navBarNumber'] 	= 2;
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['title'] 			= 'Site Links';
		$data['page_js'] 		= 'site_link_js';

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 			= $csrf;
		
		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('url', 'Url', 'trim|required|xss_clean|strip_tags|callback_valid_url_format');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('warning', 'All field is required.');
				$data['errors'] = validation_errors();
			}
			else
			{
				$title 			= $this->input->post('title', TRUE);
				$url 			= $this->input->post('url', TRUE);

				$insert_record 	= array(
					'title' 	=> $title,
					'url'		=> $url
				);
				
				if( $this->Site_link_model->add( $insert_record ) )
				{
					$this->session->set_flashdata('success','Site Link added successfully!');
					redirect('site_link/index');
				}
				else
				{
					$this->session->set_flashdata('error','Site Link not added!');
				}	
			}
		}	
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Site_link/create', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	public function edit( $id )
	{
		is_user_employee(array(3,4));
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['navBarNumber'] 	= 2;
		$data['user_session'] 	= $user_session;
		$data['title'] 			= 'Site Links';
		$data['page_js'] 		= 'site_link_js';
		$data['result'] 		= '';

		$data['site_link_id'] 	= $id;
		// $is_link_id
		
		$is_exists 				= $this->Site_link_model->link_id_exists( $id );

		if( $is_exists )
		{
			$result 			= $this->Site_link_model->find( $id );
			$data['result'] 	= $result;
		}
		
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 			= $csrf;

		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('url', 'Url', 'trim|required|xss_clean|strip_tags|callback_valid_url_format');
			
			if( $this->form_validation->run() == FALSE )
			{
				$this->session->set_flashdata('error', 'All field is required.');
				$data['errors'] = validation_errors();
			}
			else
			{
				$title 			= $this->input->post('title', TRUE);
				$url 			= $this->input->post('url', TRUE);

				$insert_record 	= array(
					'title' => $title,
					'url'	=> $url
				);
				
				if( $this->Site_link_model->update( $insert_record, $id ) )
				{
					$this->session->set_flashdata('success','Site Link updated successfully!');
					redirect('site_link/index');
				}
				else
				{
					$this->session->set_flashdata('error','Site Link not updated!');
				}	
			}
		}	
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Site_link/edit', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================
	
	public function remove()
	{
		is_user_employee(array(3,4));
		if ($this->input->is_ajax_request()) {

			$id 	= $this -> input -> post('id');

			if( $this->Site_link_model->delete($id) )
			{
				$da['success'] 	= 1;
				$da['id'] 		= $id;
			}
			else
			{
				$da['success'] 	= 0;
			} 

			$da['hash_token'] = $this->security->get_csrf_hash();

			echo json_encode( $da );
			die;
		}
		else
		{
			$this->session->set_flashdata('warning','No direct script access allowed!');
			redirect('/home/index');
		}
	}
	//================================================

	public function check_unique_site_url( $id=false )
	{
		is_user_login();
		is_user_employee(array(3,4));
		password_change_or_expire();

		if ($this->input->is_ajax_request()) {
			
			$site_url 	= $this->input->get('url');

			$is_exists_site_url =  $this->Site_link_model->site_url_exists( $site_url, $id );
			
			
			if( empty($is_exists_site_url) )
			{
				echo "true";

			}
			else
			{
				echo "false";
			} 
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

	function valid_url_format( $str )
	{
		$pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";
		if( !preg_match($pattern, $str) )
		{
			$this->form_validation->set_message('valid_url_format', 'The URL you entered is not correctly formatted.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	//================================================
}