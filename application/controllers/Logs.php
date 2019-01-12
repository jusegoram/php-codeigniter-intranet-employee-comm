<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->model('Logs_model');
		$this->load->model('Issues_model');
		is_user_login();
		password_change_or_expire();
	}
	//================================================

	public function index()
	{
		$data['navBarNumber'] 	= 8;
		$data['title'] 			= 'Logs';
		$data['page_js'] 		= 'logs_js';
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		
		// $data['results']		= $this->Logs_model->find_all();
		$data['issues']			= $this->Issues_model->find_all( 1 );

		$all_field_name			= $this->Logs_model->find_logs_field_name();
		$all_field_name			= ( !empty($all_field_name) ) ? $all_field_name : array();
		$data['all_field_name']	= $all_field_name;

		$field_value_array 		= array();
		
		foreach ($all_field_name as $value) {
			array_push($field_value_array, $value->field_value);
		}


		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;
		
		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('regarding_issue_id', 'Issue Name', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('avaya_number', 'Avaya Number', 'trim|required|xss_clean|strip_tags|alpha_numeric|callback_check_card');
			$this->form_validation->set_rules('logs_array[FIELD_ONE]', 'Log One', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('logs_array[FIELD_TWO]', 'Log Two', 'trim|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('logs_array[FIELD_THREE]', 'Log Three', 'trim|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('logs_array[FIELD_FOUR]', 'Log Four', 'trim|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('logs_array[FIELD_FIVE]', 'Log Five', 'trim|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('logs_array[FIELD_SIX]', 'Log Six', 'trim|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('logs_array[FIELD_SEVEN]', 'Log Seven', 'trim|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('logs_array[FIELD_EIGHT]', 'Log Eight', 'trim|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('logs_array[FIELD_NINE]', 'Log Nine', 'trim|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('logs_array[FIELD_TEN]', 'Log Ten', 'trim|xss_clean|strip_tags|callback_check_card');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('warning', 'Log addition failed.');
				$data['errors'] = validation_errors();
			}
			else
			{
				$user_id 				= $user_session->id;

				$logs_array 			= $this -> input -> post('logs_array[]', TRUE);
				
				$logs_array1 			= $this -> input -> post('logs_array[FIELD_ONE]', TRUE);
				$logs_array2 			= $this -> input -> post('logs_array[FIELD_TWO]', TRUE);
				$filtered_array 		= array_filter($logs_array);
				
				$regarding_issue_id 	= $this -> input -> post('regarding_issue_id', TRUE);
				$avaya_number 			= $this -> input -> post('avaya_number', TRUE);

				$logs_array 			= json_encode($filtered_array);
				$created_date 			= time();
				
				if( count(json_decode($logs_array,1)) != 0 )
				{	
					$insert_record = array(
						'user_id' 				=> $user_id,
						'avaya_number' 			=> $avaya_number,
						'user_logs' 			=> $logs_array,
						'field_name'			=> json_encode($field_value_array),
						'regarding_issue_id' 	=> $regarding_issue_id,
						'created_date' 			=> $created_date
					);

					$this->Logs_model->add( $insert_record );
					$this->session->set_flashdata('success', 'Log added successfully.');
					redirect('/Logs/index');
				}
				else
				{
					$this->session->set_flashdata('warning', 'Minimum one Field is required.');
				}
			}
		}

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		
		if( $user_session->user_type == 2 )
		{
			$this->load->view('Logs/create', $data);
		}
		else
		{
			$this->load->view('Logs/index', $data);	
		}

		

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
			
			
			if ( (1 == $user_session->user_type) || (5 == $user_session->user_type) || (6 == $user_session->user_type) )  {
				$users 	= $this->User_model->find_all( false, $user_session->employee_id );
				
				$ids = '';
				if(!empty($users)){
					foreach ($users as $user) {
						$ids[]  =  $user->id;
					}
				}

				$results			= $this->Logs_model->find_all( $ids, $search_str );
				$user_lists 		= $this->Logs_model->find_all_pagination( $ids, $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by']);

			}
			else
			{
				$results			= $this->Logs_model->find_all( false, $search_str );
				$user_lists 		= $this->Logs_model->find_all_pagination( false, $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by']);
			}


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
					$str = "avaya_number";
					return $str;
				break;
			
				case '3':
					$str = "issue_name";
					return $str;
				break;
				
				case '4':
					$str = "created_date";
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
					$filtered_da['avaya_number'] 				= $users->avaya_number;
					$filtered_da['issue_name'] 					= $users->issue_name;
					$filtered_da['created_date'] 				= date('Y-m-d H:i:s', $users->created_date);
					$filtered_da['action'] 						= site_url('logs').'~'.$users->id.'~'.$user_type;
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

	public function logs_field_name()
	{
		$data['navBarNumber'] 	= 8;
		
		is_user_employee( array(3,4) );

		$data['title'] 			= 'Add Logs Field Name';
		$data['page_js'] 		= 'logs_field_name_js';
		
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;


		$records			= $this->Logs_model->find_logs_field_name();
		$data['records'] 	= (!empty($records)) ? $records : array();
		
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 			= $csrf;

		
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Logs/logs_field_name', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	public function add_field_name()
	{
		is_user_login();
		is_user_employee(array(3,4));
		password_change_or_expire();

		if ($this->input->is_ajax_request()) {

			$id 			= $this -> input -> post('id', TRUE);
			$field_value 	= $this -> input -> post('fieldValue', TRUE);

			$insert_record = array( 'field_value' => $field_value );
			$results 		= $this->Logs_model->add_logs_field_name( $id, $insert_record );

			if( !empty($results) )
			{
				$da['success'] 	= 1;
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

	public function details( $id )
	{
		$data['navBarNumber'] 	= 8;
		$data['title'] 			= 'Logs';
		$data['page_js'] 		= 'logs_js';
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['result'] 		= '';
		$is_exists 				= $this->Logs_model->logs_id_exists( $id );

		if( $is_exists )
		{

			$result 			= $this->Logs_model->find( $id );

			$data['logs_arr']	= (array) json_decode($result->user_logs);
			
			$all_field_name		= $this->Logs_model->find_logs_field_name();
			$data['field_results'] = (!empty($all_field_name)) ? $all_field_name:'';
		}

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Logs/details', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	public function remove()
	{
		is_user_employee(array(3,4));
	
		if ($this->input->is_ajax_request()) {

			$id 	= $this -> input -> post('id');

			if( $this->Logs_model->delete($id) )
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

	function export_logs()
	{
		$data['navBarNumber'] 	= 8;
		is_user_employee(array(3,4));

		$data['title'] 			= 'Export';
		$data['page_js'] 		= 'export_js';
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		
		$data['issues']			= $this->Issues_model->find_all( 1 );
		
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;
		
		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('regarding_issue_id', 'Issue Name', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('date_start', 'Date Start', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('date_end', 'Date End', 'trim|required|xss_clean|strip_tags|callback_check_card');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('warning', 'Logs Export Failed.');
				$data['errors'] = validation_errors();
			}
			else
			{
				$regarding_issue_id = $this -> input -> post('regarding_issue_id', TRUE);
				$date_start 		= strtotime( $this -> input -> post('date_start', TRUE) );
				$date_end 			= strtotime( $this -> input -> post('date_end', TRUE) );

				$header_arr 		= $this->Logs_model->find_all_logs_header( $regarding_issue_id, $date_start, $date_end );
				$logs				= $this->Logs_model->find_all_logs( $regarding_issue_id, $date_start, $date_end );

				$all_field_name		= $this->Logs_model->find_logs_field_name();
				$field_results 		= (!empty($all_field_name)) ? $all_field_name:'';

				// print('<pre>');
				// print_r($header_arr);
				// die;
				
				header('Content-Type: text/csv; charset=utf-8');
				header('Content-Disposition: attachment; filename=issue_logs.csv');
				$output = fopen('php://output', 'w');

				$header_array 	= array('Employee ID', 'Employee Name', 'Issue', 'Avaya Number', 'Date' );
				$empty_array 	= array('Employee ID' =>'', 'Employee Name' => '', 'Issue' => '', 'Avaya Number' => '', 'Date' => '' );


				if(!empty($logs))
				{
					foreach ($header_arr as $header_obj)
					{
						$header_check_arr1 	= json_decode($header_obj->field_name);
						$header_arr1 		=  array_merge($header_array,$header_check_arr1);
						
						fputcsv($output, $header_arr1);
						
						foreach($logs as $log_ar)
						{
							$header_check_arr2 = json_decode($log_ar->field_name);
							$logs_arr			= (array) json_decode($log_ar->user_logs);

							if(!array_diff($header_check_arr1, $header_check_arr2))
							{
								$full_name = $log_ar->first_name.' '.$log_ar->last_name;
								$arr = array(	
									'Employee ID' 	=> $log_ar->employee_id,
									'Employee Name' => $full_name,
									'Issue' 	 	=> $log_ar->issue_name,
									'Avaya Number' 	=> $log_ar->avaya_number,
									'Date' 	 		=> date('Y-m-d H:i:s', $log_ar->created_date)
								);

								foreach ($field_results as $key => $field_result_obj)
								{
									$arr[$header_check_arr2[$key]] = $logs_arr[$field_result_obj->field_title];
									$empty_array[$header_check_arr2[$key]] = '';
								}

								fputcsv($output, $arr);
							}
						}
						fputcsv($output, $empty_array);
					}
					die;
				}
				else
				{
					$this->session->set_flashdata('warning', 'No logs available please select another one.');
					$data['errors'] = validation_errors();
					redirect('/Logs/export_logs');
				}


				//================================================================
				// if( !empty($logs) )
				// {
				// 	$all_field_name		= $this->Logs_model->find_logs_field_name();
				// 	$field_results 		= (!empty($all_field_name)) ? $all_field_name:'';


					// header('Content-Type: text/csv; charset=utf-8');
					// header('Content-Disposition: attachment; filename=issue_logs.csv');
					// $output = fopen('php://output', 'w');
					
					// $header_array 	= array('Employee ID', 'Employee Name', 'Issue', 'Avaya Number', 'Date' );

					// foreach ($all_field_name as $field_name) {
					// 	array_push($header_array, $field_name->field_value);
					// }

					// fputcsv($output, $header_array);
					// $check_arr 		= '';
					// foreach ($logs as $log)
					// {

						// $field_name_in_current_logs = json_decode($log->field_name);
						
						
						/* First Time Header Code */
						// if(empty($check_arr) || !array_diff($field_name_in_current_logs, $check_arr))
						// {
						// 	$header_arr = array_merge($header_array,$field_name_in_current_logs);
						// 	$check_arr 	= $field_name_in_current_logs;
							
						// 	echo "<pre>";
						// 	print_r($header_arr);
						// 	die;

							//fputcsv($output, $header_arr);	
						// }

						// if(!empty($check_arr) && array_diff($field_name_in_current_logs, $check_arr))
						// {
						// 	$header_arr =  array_merge($header_array,$field_name_in_current_logs);
						// 	$check_arr 	=  $field_name_in_current_logs;
							//fputcsv($output, $header_arr);

						// }

						

						// $user_id 	= $log->user_id;
						// $logs_arr	= (array) json_decode($log->user_logs);
						
						// $full_name = $log->first_name.' '.$log->last_name;
						// $arr 	= array(	
						// 		'Employee ID' 	=> $log->employee_id,
						// 		'Employee Name' => $full_name,
						// 		'Issue' 	 	=> $log->issue_name,
						// 		'Avaya Number' 	=> $log->avaya_number,
						// 		'Date' 	 		=> date('Y-m-d H:i:s', $log->created_date)
						// 	);

						// if( !empty( $field_results ) )
						// {
						// 	foreach ($field_results as $field_result_obj)
						// 	{
						// 		$arr[$field_result_obj->field_value] = $logs_arr[$field_result_obj->field_title];
						// 	}
						// }
						
						//fputcsv($output, $arr);
				// 	}
				// 	die;
				// }
				// else
				// {
				// 	$this->session->set_flashdata('warning', 'No logs available please select another one.');
				// 	$data['errors'] = validation_errors();
				// 	redirect('/Logs/export_logs');
				// }
				//========================================================================
			}
		}

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Logs/export_logs', $data);
		$this->load->view('layouts/footer', $data);
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