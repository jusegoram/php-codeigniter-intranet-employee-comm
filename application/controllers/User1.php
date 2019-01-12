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

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
	}
	//================================================

	/*
	* This is index function for getting information about users
	* @author 		:
	* @createdOn	: 
	*/
	public function index(){
		
		is_user_employee(array(1,3));
		is_user_login();
		$data['navBarNumber'] = 3;
		password_change_or_expire();
		$data['title'] 			= 'Dashboard';
		$data['page_js'] 		= 'user_js';
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session']	= $user_session;

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;

		// $user_type = $user_session->user_type;

		// switch ( $user_type )
		// {
		// 	case '1':

		// 		$results 	= $this->User_model->find_all( false, $user_session->employee_id );
		// 		break;

		// 	case '3':

		// 		$results 	= $this->User_model->find_all(3);
		// 		break;
		// }

		// $data['results'] = $results;

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('User/index', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	public function pagination()
	{
		is_user_employee(array(1,3));

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
			$user_type 						= $user_session->user_type;

			switch ( $user_type )
			{
				case '1':

					$results 	= $this->User_model->find_all( false, $user_session->employee_id, $search_str );
					$user_lists = $this->User_model->find_all_pagination( false, $user_session->employee_id, $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by']);
					break;

				case '3':

					$results 	= $this->User_model->find_all( 3, $user_session->employee_id, $search_str );
					$user_lists = $this->User_model->find_all_pagination( 3, $user_session->employee_id, $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by']);
					break;
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
					$str = "employee_id";
					return $str;
				break;
			
				case '3':
					$str = "email";
					return $str;
				break;
			
				case '4':
					$str = "job_title";
					return $str;
				break;

				case '5':
					$str = "user_type";
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
			$filtered_data 	= array();
			$record 		= array();
			$user_session	= $this->session->userdata('USER_SESSION');
			$user_type 		= $user_session->user_type;

			if(!empty($user_lists))
			{
				$i = $index;

				foreach($user_lists as $key => $users)
				{
					
					//$filtered_data[$i] 						= $cms_pages_listing;

					$set_job_title = '';
					if( 1 == $users->job_title ) {
						$set_job_title = 'Supervisor';
					} elseif( 2 == $users->job_title ) {
						$set_job_title = 'QA';
					}
					
					$filtered_da['id'] 			= $i;
					$filtered_da['first_name'] 	= $users->first_name.' '.$users->last_name;
					$filtered_da['employee_id'] = $users->employee_id;
					$filtered_da['email'] 		= $users->email;
					$filtered_da['job_title'] 	= $set_job_title;
					$filtered_da['user_type'] 	= ( $users->user_type == 1 ) ? 'Manager' : 'Employee';
					$filtered_da['action'] 		= ( 3 == $user_type ) ? site_url('user').'~'.$users->id.'~'.$user_type : '';
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

	public function login()
	{	
		
		// $user_session		= $this->session->userdata('USER_SESSION');

		// if( isset($user_session))
		// {
		// 	redirect('Home/index');
		// }

		$data['title'] 		= 'Login';
		$data['page_js'] 	= 'user_js';

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 		= $csrf;
		// $cookie_username 	= get_cookie("username");
		// $cookie_id 		 	= get_cookie("id");

		// if( isset($cookie_username) && isset($cookie_id) )
		// {
		// 	$results = $this->User_model->find( $cookie_id );
		// 	$this->session->set_userdata('USER_SESSION', $results);
		// 	redirect('home/index');
		// 	exit;
		// }
		// else
		// {
			if(count($_POST) > 0)
			{

				$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
				$this->form_validation->set_rules('username', 'Unique ID ', 'trim|required|xss_clean|strip_tags|alpha_numeric');
				$this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean|strip_tags|alpha_numeric');

				if( $this->form_validation->run() == FALSE )
				{
					$this->session->set_flashdata('warning', 'Username & Password is required.');
					$data['errors'] = validation_errors();
				}
				else
				{
					$username 		= $this->input->post('username', TRUE);
					$password 		= $this->input->post('password', TRUE);
					$remember_me 	= $this->input->post('remember_me', TRUE);
					$password 		= md5_hash( $password );
					$results 		= $this->User_model->login( $username, $password );
					
					if( !empty($results) )
					{
						// if( $remember_me )
						// {
						// 	set_cookie( "remember_me", true, time() + (86400 * 30) );
						// 	set_cookie( "username", $username, time() + (86400 * 30) );
						// 	set_cookie( "id", $results->id, time() + (86400 * 30) );
						// }


						// $redirect_to_calling_url	= $this->session->userdata('USER_SESSION');
						
						// $redirect_to_calling_url1 = (!empty($redirect_to_calling_url)) ? $redirect_to_calling_url : 'Home/index';
						
						// print($redirect_to_calling_url1);
						// die;

					 	$this->session->set_userdata('USER_SESSION', $results);
					 	$this->session->set_flashdata('success', 'Login successfully.');
						
						redirect('Home/index');
					}
					else
					{
						$this->session->set_flashdata('warning', 'Username & Password is invalid.');
						$data['errors'] = validation_errors();
						redirect('/user/login');
					}
				}
			}
		// }

		$this->load->view('User/login', $data);
	}
	//================================================

	public function check_username( $username )
	{
		if( empty($result) )
		{
			return false;
		}
		else
		{
			$this->session->set_userdata('USER_SESSION', $result);
			return true;
		}
	}
	//================================================

	public function verify_email()
	{
		$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|strip_tags|valid_email|callback_check_email[email]');
		$data['title'] 		= 'Email';
		$data['site_url']	= site_url('users/verify_email');

		if( count( $_POST ) > 0 )
		{
			if( $this->form_validation->run() == FALSE )
			{
				$this->session->set_flashdata('error','invalid email id');
				//redirect(site_url('users/verify_email'));
				redirect('users/verify_email');
			}
			else
			{
				send_mail( $to, $subject, $message, $cc = '', $bcc = '', $attachment = '' );
			}
		}
	}
	//================================================

	public function create()
	{
		$data['navBarNumber'] = 3;
		is_user_login();
		is_user_employee(array(3));
		password_change_or_expire();
		
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['title'] 			= 'Add User';
		$data['page_js'] 		= 'user_js';

		$supervisor_results 	= $this->User_model->find_all(1, '', '', 1);
		$qa_results 			= $this->User_model->find_all(1, '', '', 2);

		$data['supervisor_results']	= $supervisor_results;
		$data['qa_results']			= $qa_results;

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 			= $csrf;

		if( count( $_POST ) > 0 )
		{

			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean|strip_tags|alpha');
			$this->form_validation->set_rules('last_name', 'Last name', 'trim|required|xss_clean|strip_tags|alpha');
			$this->form_validation->set_rules('employee_id', 'Employee Id', 'trim|required|xss_clean|strip_tags|alpha_numeric|callback_check_card|is_unique[users.employee_id]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|strip_tags|alpha_numeric|callback_check_card');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|strip_tags|valid_email');
			$this->form_validation->set_rules('user_type', 'User Type', 'trim|required|xss_clean|strip_tags|alpha_numeric');

			$check_user_type		= $this -> input -> post('user_type', TRUE);

			// print($this -> input -> post('assigned_qa', TRUE));
			// print(' ');
			// print($this -> input -> post('assigned_supervisor', TRUE));
			// die;

			if( !empty( $check_user_type ))
			{
				if( $check_user_type == 1 )
				{
					$this->form_validation->set_rules('job_title', 'Job Title', 'trim|required|xss_clean|strip_tags|alpha_numeric');
				}
				else
				{
					$this->form_validation->set_rules('assigned_supervisor', 'Assign Supervisor', 'trim|required|xss_clean|strip_tags');
					$this->form_validation->set_rules('assigned_qa', 'Assign QA', 'trim|xss_clean|strip_tags');
				}
			}

			$this->form_validation->set_rules('hire_date', 'Hire Date', 'trim|required|xss_clean|strip_tags');

			if( $this->form_validation->run() == FALSE )
			{
				$this->session->set_flashdata('warning', 'User addition failed.');
				$data['errors'] = validation_errors();
			}
			else
			{
				$first_name 		= $this -> input -> post('first_name', TRUE);
				$last_name 			= $this -> input -> post('last_name', TRUE);
				$employee_id 		= $this -> input -> post('employee_id', TRUE);
				$password 			= $this -> input -> post('password', TRUE);
				$email 				= $this -> input -> post('email', TRUE);
				$user_type			= $this -> input -> post('user_type', TRUE);
				$hire_date 			= strtotime($this -> input -> post('hire_date', TRUE));
				$username 			= $employee_id;
				$is_change_password = $this -> input -> post('is_change_password', TRUE);
				$activation_code 	= null;
				$created_date 		= time();
				$expire_time 		= null;
				$assigned_qa 		= null;
				$assigned_supervisor = null;
				$job_title 			= null;

				if( $check_user_type == 1 )
				{
					$job_title 		= $this -> input -> post('job_title', TRUE);
				}
				else
				{
					$assigned_supervisor = $this -> input -> post('assigned_supervisor', TRUE);
					$assigned_qa 		 = $this -> input -> post('assigned_qa', TRUE);


					// if( $assigned_manager[1] == 'Quality Analyst' )
					// {
					// 	$assigned_qa 	= $assigned_manager[0];
					// }
					// else
					// {
					// 	$assigned_supervisor = $assigned_manager[0];;
					// }
				}

				if( 3 == $user_type)
				{
					$username = uniqid('M');
				}

				$password_enc = md5_hash( $password );

				if( $is_change_password )
				{
					$is_change_password = 1;
				}
				else
				{
					$is_change_password = 0;
				}

				$previous_password  	= array($created_date => $password_enc);

				$insert_record = array(
					'user_type' 			=> $user_type,
					'username'  			=> $username,
					'employee_id' 			=> $employee_id,
					'email' 				=> $email,
					'password' 				=> $password_enc,
					'first_name'			=> $first_name,
					'last_name' 			=> $last_name,
					'job_title' 			=> $job_title,
					'assigned_qa'			=> $assigned_qa,
					'assigned_supervisor'	=> $assigned_supervisor,
					'is_change_password'	=> $is_change_password,
					'previous_password' 	=> json_encode($previous_password),
					'hire_date' 			=> $hire_date,
					'activation_code' 		=> $activation_code,
					'created_date'			=> $created_date
				);

				$message = 'your username is:'.$username . '<br/> and password is:' . $password;

				$subject = "User Registration";

				if( vic_mail($email, $subject, $message) )
				{
					if( $this->User_model->add( $insert_record ) )
					{
						$this->session->set_flashdata('success', 'User added successfully.');
						redirect('/user/index');
					}
					else
					{
						$this->session->set_flashdata('error', 'User insertion failed.');
						$data['errors'] = validation_errors();
					}
				}
				else
				{
					$this->session->set_flashdata('error', 'Email sending failed!');
				}
			}
		}

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('User/create', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	public function create_bulk()
	{
		$data['navBarNumber'] = 3;
		is_user_login();
		is_user_employee(array(3));
		password_change_or_expire();

		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		
		$data['title'] 			= 'Add User';
		$data['page_js'] 		= 'user_js';
		$not_added_user_array 	= array();

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 			= $csrf;

		if( !empty($_FILES) && count( $_POST ) > 0 )
		{
			$this->load->library('csv_reader');
			
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			// $this->form_validation->set_rules('file_name', 'File Name', 'trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('default_password', 'Password', 'trim|required|xss_clean|strip_tags|alpha_numeric|callback_check_card');
			
			if( $this->form_validation->run() == FALSE )
			{
				$this->session->set_flashdata('warning', 'All Field is required.');
				$data['errors'] = validation_errors();
							    			    
			}
			else
			{
				$password 			= $this->input->post('default_password', TRUE);
				$is_change_password = $this->input->post('is_change_password', TRUE);

				if($is_change_password)
				{
					$is_change_password = 1;
				}
				else
				{
					$is_change_password = 0;
				}

				$file 				= $_FILES['file_name'];
				$file_name 			= $file['name'];
				$file_name 			= space_to_symbol($file_name);
				$file_ext 			= get_extention($file_name);
				
				$file_name 			= get_extention($file_name, 'filename');
				$file_name 			= $file_name .'_' . time() . '.' . $file_ext;


				$path = CSV_ROOT_UPLOAD_PATH . '/';

				if( $this->do_upload($file_name, $field_name='file_name', $path) )
				{
					$csv_file 	= $path.$file_name;
					$results 	= $this->csv_reader->parse_file($csv_file);
					$last 		= count($results);
					$counter 	= 0;
					$counter1 	= 0;

					foreach( $results as $result )
					{
						$employee_id 		= $result['EmployeeID'];
						$first_name 		= $result['First Name'];
						$last_name 			= $result['Last Name'];
						$employee_role 		= $result['Employee Role'];
						$email 				= $result['Email ID'];
						$username 			= $result['EmployeeID'];
						$hire_date 			= strtotime($result['Date of joining']);
						$created_date 		= time(); //strtotime(date('Y-m-d'));

						$activation_code 	= null;
						$expire_time 		= null;
						$assigned_qa 		= null;
						$assigned_supervisor = null;
						
						if( !empty($result['Reporting To']))
						{
							$user_job_title = $this->User_model->user_id_exists( '', $result['Reporting To'] );
							if( $user_job_title['job_title'] )
							{
								if( 1 == $user_job_title->job_title ) {
									$assigned_supervisor = $result['Reporting To'];
								} elseif( 2 == $user_job_title->job_title ) {
									$assigned_qa = $result['Reporting To'];
								}								

								// $job_title = ( $user_job_title->job_title == 1) ? 'Supervisor' : 'QA';  
								
								// if( $job_title == 'Supervisor' ) {
								// 	$assigned_supervisor = $result['Reporting To'];
								// } else {
								// 	$assigned_qa = $result['Reporting To'];
								// }
							}
						}

						$title 				= $result['Title'];

						$check_title 		= strstr($title, ' ', true);
						$job_title 			= null;

						if( ($check_title == 'Supervisor') || ($check_title == 'QA') )
						{
							$check_title 	= ($check_title == 'Supervisor' ) ? 1 : 2;	
							$user_type 		= 1;
							$job_title		= $check_title;
						}
						else if( $title == 'CEO')
						{	
							$user_type 		= 3;
						}
						else
						{
							$user_type 		= 2;
						}
						
						$password_enc = md5_hash( $password );

						$previous_password  	= array($created_date => $password_enc);

						$insert_record = array(
							'employee_id' 		=> $employee_id,
							'user_type' 		=> $user_type,
							'username'  		=> $username,
							'email' 			=> $email,
							'job_title'			=> $job_title,
							'password' 			=> $password_enc,
							'first_name'		=> $first_name,
							'last_name' 		=> $last_name,
							'assigned_qa' 		=> $assigned_qa,
							'assigned_supervisor' => $assigned_supervisor,
							'is_change_password'=> $is_change_password,
							'hire_date' 		=> $hire_date,
							'activation_code' 	=> $activation_code,
							'created_date' 		=> $created_date,
							'previous_password' => json_encode($previous_password)
						);

						$is_exists_employee_id =  $this->User_model->user_id_exists( '', $employee_id );
						
						if( empty($is_exists_employee_id->employee_id) )
						{
							$this->User_model->add( $insert_record );
							$counter++;
						}
	
						$counter1++;
					
						$template 	= json_encode(array(
							'employee_id' 		=> $employee_id,
							'user_type' 		=> $user_type,
							'username' 			=> $username,
							'password' 			=> $password,
							'email' 			=> $email,
							'first_name'		=> $first_name,
							'last_name' 		=> $last_name,
							'is_change_password'=> $is_change_password,
							'hire_date' 		=> $hire_date,
							'activation_code' 	=> $activation_code
						));

						$insert_email_data = array(
							'email' 			=> $email,
							'template' 			=> $template
						);

						// $this->User_model->add_email_detail( $insert_email_data );

						if( $counter1 == $last )
						{
							if( $counter )
							{
								$this->session->set_flashdata('success', $counter.' user added successfully.');
							}
							else
							{
								$this->session->set_flashdata('warning', 'user not added.');
							}
							redirect('/user/index');
						}
						
						// if( !empty($email) )
						// {
						// 	$this->User_model->add( $insert_record );
							
						// 	$template 	= json_encode(array(
						// 		'employee_id' 		=> $employee_id,
						// 		'user_type' 		=> $user_type,
						// 		'username' 			=> $username,
						// 		'password' 			=> $password,
						// 		'email' 			=> $email,
						// 		'first_name'		=> $first_name,
						// 		'last_name' 		=> $last_name,
						// 		'hire_date' 		=> $hire_date,
						// 		'activation_code' 	=> $activation_code
						// 	));

						// 	$insert_email_data = array(
						// 		'email' 			=> $email,
						// 		'template' 			=> $template
						// 	);

						// 	$this->User_model->add_email_detail( $insert_email_data );
						// 	$counter++;
						// 	if( $counter == $last )
						// 	{
						// 		// $data['results'] = $this->User_model->find_all_email();
						// 		redirect('/user/create_bulk');
						// 	}
						// }
						// else
						// {
						// 	array_push($not_added_user_array, json_encode($insert_record));
						// }
					}
						// $data['results'] = $not_added_user_array;
				}
			}
		}

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('User/create_bulk', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	public function cron_mail_send()
	{
		$results = $this->User_model->find_all_email();
		$subject = "User Registration";
		
		foreach( $results as $result )
		{
			$id 		= $result->id;
			$email 		= $result->email;
			$template 	= $result->template;

			if( empty($email) )
			{
				$this->User_model->delete( $id, 'temporary_email_send' );
			}
			else
			{
				if( vic_mail($email, $subject, $template) )
				{
					$this->User_model->delete( $id, 'temporary_email_send' );
				}
			}
		}
	}
	//================================================

	public function edit( $id )
	{
		$data['navBarNumber'] 	= 3;
		is_user_login();
		is_user_employee( array(3) );
		password_change_or_expire();

		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['title'] 			= 'Users';
		$data['page_js'] 		= 'user_js';

		$supervisor_results 	= $this->User_model->find_all(1, '', '', 1);
		$qa_results 			= $this->User_model->find_all(1, '', '', 2);

		$data['supervisor_results']	= $supervisor_results;
		$data['qa_results']			= $qa_results;

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 			= $csrf;
		$data['result'] 		= '';
		$is_exists 				= $this->User_model->user_id_exists( $id );

		if( $is_exists )
		{
			$result 		= $this->User_model->find( $id );
			$data['result'] = ( $result->user_type != 3 ) ? $result : '';
		}

		// print_r($result);
		// die;

		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean|strip_tags|alpha');
			$this->form_validation->set_rules('last_name', 'Last name', 'trim|required|xss_clean|strip_tags|alpha');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|strip_tags|valid_email');
			$this->form_validation->set_rules('hire_date', 'Hire Date', 'trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('assigned_supervisor', 'Assigned Supervisor', 'trim|required|xss_clean|strip_tags');

			if( $this->form_validation->run() == FALSE )
			{
				$this->session->set_flashdata('warning', 'User addition failed.');
				$data['errors'] = validation_errors();
			}
			else
			{
				$first_name 		= $this -> input -> post('first_name', TRUE);
				$last_name 			= $this -> input -> post('last_name', TRUE);
				$email 				= $this -> input -> post('email', TRUE);
				
				$assigned_supervisor = $this -> input -> post('assigned_supervisor', TRUE);
				$assigned_qa 		 = $this -> input -> post('assigned_qa', TRUE);

				$hire_date 			= strtotime($this -> input -> post('hire_date', TRUE));
				
				$insert_record = array(
					'email' 				=> $email,
					'first_name'			=> $first_name,
					'last_name' 			=> $last_name,
					'assigned_supervisor' 	=> $assigned_supervisor,
					'assigned_qa' 			=> $assigned_qa,
					'hire_date' 			=> $hire_date
				);

				$this->User_model->update( $insert_record, $id );
				$this->session->set_flashdata('success', 'User added successfully.');
				redirect('/user/index');
			}
		}

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('User/edit', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	public function assign_users()
	{
		$data['navBarNumber'] = 3;
		is_user_login();
		is_user_employee( array(3) );
		password_change_or_expire();

		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['title'] 			= 'Users';
		$data['page_js'] 		= 'user_js';

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 			= $csrf;
		
		$all_managers 			= $this->User_model->find_all( 1 );

		// print_r($all_managers);
		// die;
		
		$data['all_managers'] 	= $all_managers;
		
		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('assigned_user', 'QA Or Supervisor', 'trim|required|xss_clean|strip_tags');
			
			if( $this->form_validation->run() == FALSE )
			{
				$this->session->set_flashdata('warning', 'User addition failed.');
				$data['errors'] = validation_errors();
			}
			else
			{
				$assigned_user 		= $this -> input -> post('assigned_user', TRUE);
				$select_employee 	= $this -> input -> post('select_employee', TRUE);

				$counter 		= 0;
				$last 			= count($select_employee);
				
				$assigned_user 	= split(':', $this -> input -> post('assigned_user', TRUE) );
				
				$assigned_user_employee_id = $assigned_user[0];
				
				$column_name 	= ( $assigned_user[1] == "Supervisor" ) ? "assigned_supervisor": "assigned_qa";

				foreach ($select_employee as $select_user_employee_id) {
					$update_record = array(
							$column_name => $assigned_user_employee_id
						);
					$this->User_model->update_assigned_user( $select_user_employee_id, $update_record );
					$counter++;
				}

				if( $counter == $last )
				{
					$this->session->set_flashdata('success', 'User Assigned successfully.');
				}
			}
		}

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('User/assign_users', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	public function find_users()
	{
		is_user_login();
		is_user_employee(array(3));
		password_change_or_expire();

		if ($this->input->is_ajax_request()) {

			$field_title 	= $this -> input -> post('fieldTitle', TRUE);
			$field_value 	= $this -> input -> post('fieldValue', TRUE);

			$column_name 	= ( $job_title == "Supervisor" ) ? "assigned_supervisor" : "assigned_qa";

			$results 		= $this->User_model->find_users( 2, $column_name);

			if( !empty($results) )
			{
				$da['success'] 	= 1;
				$da['results']	= $results;
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

	public function check_unique_employee_id()
	{
		is_user_login();
		is_user_employee(array(3));
		password_change_or_expire();

		if ($this->input->is_ajax_request()) {
			// $employee_id 	= $_GET['employee_id'];
			
			$employee_id 	= $this->input->get('employee_id');

			$is_exists_employee_id =  $this->User_model->user_id_exists( '', $employee_id );
			
			if( $is_exists_employee_id['employee_id'] == '' )
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

	public function remove()
	{
		is_user_login();
		is_user_employee(array(3));
		password_change_or_expire();

		if ($this->input->is_ajax_request()) {

			$user_session	= $this->session->userdata('USER_SESSION');
			$data['title'] 	= 'User List';
			$id 			= $this -> input -> post('id', TRUE);

			$csrf = array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			);

			$data['csrf'] 	= $csrf;
			
			if( $this->User_model->delete($id) )
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

	public function profile_setting()
	{
		is_user_login();
		password_change_or_expire();

		$data['title'] 			= 'User Profile';
		$data['page_title'] 	= "User Profile";
		$data['page_header'] 	= "User Profile";
		$data['page_js'] 		= 'user_js';

		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;

		$id 					= $user_session->id;
		$result 				= $this->User_model->find( $id );
		$data['result'] 		= $result;

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 			= $csrf;
		
		if( count( $_POST ) > 0 )
		{	
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			
			if($user_session->user_type != 2)
			{
				$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean|strip_tags|alpha');
				$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean|strip_tags|alpha');
				$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|strip_tags|alpha_numeric|callback_check_card');
				$first_name = $this -> input -> post('first_name', TRUE);
				$last_name	= $this -> input -> post('last_name', TRUE);
				$username	= $this -> input -> post('username', TRUE);
			}	

			$this->form_validation->set_rules('email', 'Email ID', 'trim|required|xss_clean|strip_tags');
			$email		= $this -> input -> post('email', TRUE);


			if( $this->form_validation->run() == FALSE )
			{
				$this->session->set_flashdata('warning', 'Profile Setting failed.');
				$data['errors'] = validation_errors();
							    			    
			}
			else
			{
				if( $user_session->user_type != 2 )
				{
					$set_data	= array('first_name' => $first_name, 'last_name' => $last_name, 'username' => $username, 'email' => $email);
				}
				else
				{
					$set_data	= array('email' => $email);
				}

				if( $this->User_model->update( $set_data, $id) )
				{
					$this->session->set_flashdata('success','Record updated successfully!');
					redirect('/home/index');
				}
				else
				{
					$this->session->set_flashdata('error','Record not updated!');
					$data['errors'] = validation_errors();
				}
			}
		}

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('User/profile_edit', $data);
		$this->load->view('layouts/footer', $data);
	}
	//==========================================================

	public function change_password()
	{
		is_user_login();
		$data['title'] 				= "Change Password";
		$data['page_js'] 			= "user_js";

		$user_session				= $this->session->userdata('USER_SESSION');
		$data['user_session'] 		= $user_session ;
		$previous_password 			= json_decode($user_session->previous_password);
		$test 						= (array) $previous_password;
		$count_previous_password   	= count($test);
		
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;

		if(count($_POST) > 0)
		{
			$id 			= $user_session->id;
			$result 		= $this->User_model->find( $id );

			$data['result'] = $result;

			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('current_password', 'Current Password', 'trim|required|xss_clean|strip_tags|alpha_numeric|callback_check_card');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|strip_tags|matches[confirm_password]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|strip_tags|alpha_numeric|callback_check_card');

			if( $this->form_validation->run() == FALSE )
			{
				$this->session->set_flashdata('warning', 'User addition failed.');
				$data['errors'] = validation_errors();
							    			    
			}
			else
			{
				$current_password 		= $this -> input -> post('current_password', TRUE);
				$new_password 			= $this -> input -> post('new_password', TRUE);
				$user_current_password 	= $result->password;
				$updated_date 			= time();

				$current_password 		= md5_hash( $current_password );
				$new_password 			= md5_hash($new_password);

				$password_match_array 	= array();
				$old_password_array 	= array();

				foreach( $previous_password as $key => $value )
				{
					array_push($password_match_array, $value);
					array_push($old_password_array, $key);
				}

				$old_password 			= min($old_password_array);

				if( $user_current_password == $current_password )
				{
					if( !in_array($new_password, $password_match_array) )
					{
						if( $count_previous_password >= 5 )
						{
							array_splice($test, 0, 1);
						}

						$test[$updated_date] = $new_password;	
						
						$test 			= json_encode($test);
						$insert_record 	= array(
							'password' 			 => $new_password,
							'is_change_password' => 0,
							'updated_date'		 => $updated_date,
							'previous_password'  => $test
						);

						if( $this->User_model->update( $insert_record, $id  ) )
						{
							$result 			= $this->User_model->find( $user_session->id );
							$this->session->set_userdata('USER_SESSION', $result);
						}
						$this->session->set_flashdata('success', 'Password changed successfully.');
						redirect('/home/index');
					}
					else
					{
						$this->session->set_flashdata('warning','Please enter another one!');
						$data['errors'] = validation_errors();
					}
				}
				else
				{
					$this->session->set_flashdata('warning','Current password is Invalid!');
					$data['errors'] = validation_errors();
				}
				

				// if( $user_current_password == $current_password)
				// {
				// 	// $new_password 	= md5_hash($new_password);
				// 	$insert_record 	= array(
				// 		'password' 			 => $new_password,
				// 		'is_change_password' => 0,
				// 		'updated_date'		 => $updated_date
				// 	);

				// 	if($this->User_model->update( $insert_record, $id  ))
				// 	{
				// 		$result 			= $this->User_model->find( $user_session->id );
				// 		$this->session->set_userdata('USER_SESSION', $result);
				// 	}

				// 	$this->session->set_flashdata('success', 'Password changed successfully.');
				// 	redirect('/home/index');
				// }
				// else
				// {
				// 	$this->session->set_flashdata('error','Current password Invalid!');
				// 	$data['errors'] = validation_errors();
				// }
			}
		}

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav', $data);
		$this->load->view('User/change_password', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	public function logout()
	{
		$this->session->sess_destroy();
		delete_cookie('remember_me');
		delete_cookie('username');
		delete_cookie('id');
		redirect('/user/login');
	}
	//================================================

	function do_upload( $file_name, $field_name, $path )
	{
		$config['upload_path'] 		= $path;
		$config['allowed_types'] 	= 'csv';
		$config['file_name']     	= $file_name;
		$config['max_size']			= '5120';
		// $config['max_width']  	= '1024';
		// $config['max_height']  	= '768';

		$this->load->library('upload', $config);

		if( ! $this->upload->do_upload( $field_name ) )
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