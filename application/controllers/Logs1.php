<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Logs_model');
		$this->load->model('Issues_model');
		is_user_login();
		password_change_or_expire();
	}
	//================================================

	public function index()
	{
		$data['title'] 			= 'Logs';
		$data['page_js'] 		= 'logs_js';
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['results']		= $this->Logs_model->find_all();
		$data['issues']			= $this->Issues_model->find_all();

		// print('<pre>');
		// print_r($data['results']);
		// die;

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
			// $this->form_validation->set_rules('logs_array[]', 'Logs', 'trim|required|xss_clean|strip_tags');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('warning', 'Log addition failed.');
				$data['errors'] = validation_errors();
			}
			else
			{
				$user_id 				= $user_session->id;

				$regarding_issue_id 	= $this -> input -> post('regarding_issue_id', TRUE);
				$avaya_number 			= $this -> input -> post('avaya_number', TRUE);
				$logs_array 			= $this -> input -> post('logs_array', TRUE);
				$logs_array 			= json_encode(array_filter($logs_array));
				$created_date 			= time();
				
				if( count(json_decode($logs_array,1)) != 0 )
				{	
					$insert_record = array(
						'user_id' 				=> $user_id,
						'avaya_number' 			=> $avaya_number,
						'user_logs' 			=> $logs_array,
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

	public function remove()
	{
		is_user_login();
		is_user_employee(array(3));
		password_change_or_expire();

		$user_session	= $this->session->userdata('USER_SESSION');
		$data['title'] 	= 'User List';
		$id 			= $this -> input -> post('id', TRUE);

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;
		
		if( $this->Logs_model->delete($id) )
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
	//================================================

	public function details( $id )
	{
		$data['title'] 			= 'Logs';
		$data['page_js'] 		= 'logs_js';
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['result'] 		= '';
		$is_exists 				= $this->Logs_model->logs_id_exists( $id );

		if( $is_exists )
		{
			$result 			= $this->Logs_model->find( $id );
			$data['result'] 	= $result;
		}

		// print('<pre>');
		// print_r(json_decode($data['result']->user_logs,1));
		// print_r($data['result']);
		// print_r(json_decode(array_filter($data['result'])));
		// die;
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Logs/details', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	function export_logs()
	{
		$data['title'] 			= 'Export';
		$data['page_js'] 		= 'export_js';
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		
		$this->load->model('User_model');
		
		$data['issues']			= $this->Issues_model->find_all();
		
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;
		
		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('regarding_issue_id', 'Issue Name', 'trim|required|xss_clean|strip_tags|callback_check_card');
			
			if ($this->form_validation->run() == FALSE)
			{
				$this->session->set_flashdata('warning', 'Logs Export Failed.');
				$data['errors'] = validation_errors();
			}
			else
			{
				$regarding_issue_id = $this -> input -> post('regarding_issue_id', TRUE);
				$logs				= $this->Logs_model->find_all_logs( $regarding_issue_id );

				// print('<pre>');
				// print_r($logs);
				// die;
				
				header('Content-Type: text/csv; charset=utf-8');
				header('Content-Disposition: attachment; filename=issue_logs.csv');

				// create a file pointer connected to the output stream
				$output = fopen('php://output', 'w');

				// output the column headings
				fputcsv($output, array('Employee ID', 'Employee Name', 'Logs', 'Issue', 'Avaya Number', 'Date'));

				// loop over the rows, outputting them
				foreach ($logs as $log)
				{
					$user_id 	= $log->user_id;
					$total_logs = json_decode($log->user_logs);

					for( $i = 0; $i < count( $total_logs ); $i++)
					{
						$full_name = $log->first_name.' '.$log->last_name;
						
						$arr 	= array(	
								'Employee ID' 	=> $log->employee_id,
								'Employee Name' => $full_name,
								'Logs' 	 		=> $total_logs[$i],
								'Issue' 	 	=> $log->issue_name,
								'Avaya Number' 	=> $log->avaya_number,
								'Date' 	 		=> date('Y-m-d H:i:s', $log->created_date)
							);

						fputcsv($output, $arr);
					}
				}
				// $this->session->set_flashdata('success', 'Export successfully.');
				die;
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