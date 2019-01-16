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

		is_user_employee(array(1,3,4,5,6));
		is_user_login();
		$data['navBarNumber'] = 3;
		password_change_or_expire();

		$data['title'] 			= 'Users';
		$data['page_js'] 		= 'user_js';
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session']	= $user_session;

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('User/index', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	public function pagination()
	{
		is_user_employee(array(1,3,4,5,6));
		password_change_or_expire();

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
				case 1:

					$results 	= $this->User_model->find_all( false, $user_session->employee_id, $search_str );
					$user_lists = $this->User_model->find_all_pagination( false, $user_session->employee_id, $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by']);

					// $results 	= $this->User_model->find_all( false, $user_session->employee_id, $search_str, '', true );
					// $user_lists = $this->User_model->find_all_pagination( false, $user_session->employee_id, $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by'], true);
					break;

				case 5:

					$results 	= $this->User_model->find_all( false, $user_session->employee_id, $search_str );
					$user_lists = $this->User_model->find_all_pagination( false, $user_session->employee_id, $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by']);
					break;

				case 6:

					$results 	= $this->User_model->find_all( false, $user_session->employee_id, $search_str );
					$user_lists = $this->User_model->find_all_pagination( false, $user_session->employee_id, $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by']);
					break;

				case 3:

					$results 	= $this->User_model->find_all( 3, $user_session->employee_id, $search_str );
					$user_lists = $this->User_model->find_all_pagination( 3, $user_session->employee_id, $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by']);
					break;

				case 4:

					$results 	= $this->User_model->find_all( 4, $user_session->employee_id, $search_str );
					$user_lists = $this->User_model->find_all_pagination( 4, $user_session->employee_id, $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by']);
					break;
			}

			// print('<pre>');
			// print_r($user_type);
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
					$str = "employee_id";
					return $str;
				break;

				case '3':
					$str = "avaya_number";
					return $str;
				break;

				case '4':
					$str = "email";
					return $str;
				break;

				case '5':
					$str = "job_title";
					return $str;
				break;

				case '6':
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

					$set_job_title = '';
					if( 1 == $users->job_title ) {
						$set_job_title = 'Supervisor';
					} elseif( 2 == $users->job_title ) {
						$set_job_title = 'QA';
					} elseif( 3 == $users->job_title ) {
						$set_job_title = 'Manager';
					}

					$filtered_da['id'] 			= $i;
					$filtered_da['first_name'] 	= $users->first_name.' '.$users->last_name;
					$filtered_da['employee_id'] = $users->employee_id;
					$filtered_da['avaya_number'] = $users->avaya_number;
					$filtered_da['email'] 		= $users->email;
					$filtered_da['job_title'] 	= ( $set_job_title ) ? $set_job_title : 'Employee';
					$filtered_da['user_type'] 	= ( ( 1 == $users->user_type ) || ( 5 == $users->user_type ) || ( 6 == $users->user_type ) ) ? $set_job_title : ( (4 == $users->user_type)?'Admin': 'Employee');
					$filtered_da['action'] 		= ( ( 3 == $user_type ) || ( 4 == $user_type ) ) ? site_url('user').'~'.$users->id.'~'.$user_type : '';

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

	public function view_admin_list(){

		is_user_login();
		is_user_employee(array(3));
		password_change_or_expire();
		$data['navBarNumber'] = 3;

		$data['title'] 			= 'Users';
		$data['page_js'] 		= 'user_js';
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session']	= $user_session;
		$data['show_admin_list'] = 1;

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('User/view_admin_list', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	public function admin_pagination()
	{
		is_user_employee(array(3));
		password_change_or_expire();

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
			$query_parameter['order_by'] 	= $this->admin_manage_orderby_for_article($order_details);
			$query_parameter['type'] 		= $order_details[0]['dir'];

			$search_str 					= $search_str['value'];

			$user_session					= $this->session->userdata('USER_SESSION');
			$user_type 						= $user_session->user_type;

			$results 	= $this->User_model->find_all_admin( 4, $search_str );
			$user_lists = $this->User_model->find_all_admin( 4, $search_str, $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by']);

			$response['data']            	= $this->admin_user_filter( $user_lists, $query_parameter['start']+1 );
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
	public function admin_manage_orderby_for_article($order_details)
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
					$str = "avaya_number";
					return $str;
				break;

				case '4':
					$str = "email";
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
	public function admin_user_filter($user_lists, $index )
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

					$filtered_da['id'] 			= $i;
					$filtered_da['first_name'] 	= $users->first_name.' '.$users->last_name;
					$filtered_da['employee_id'] = $users->employee_id;
					$filtered_da['avaya_number'] = $users->avaya_number;
					$filtered_da['email'] 		= $users->email;
					$filtered_da['user_type'] 	= ( (1 == $users->user_type) || (5 == $users->user_type) || (6 == $users->user_type) ) ? $set_job_title : ( (4 == $users->user_type)?'Admin': 'Employee');
					$filtered_da['action'] 		= ( ( 3 == $user_type ) || ( 4 == $user_type ) ) ? site_url('user').'~'.$users->id.'~'.$user_type : '';

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
		$data['title'] 		= 'Login';
		$data['page_js'] 	= 'user_js';

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 		= $csrf;
		if(count($_POST) > 0)
		{

			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('username', 'Unique ID ', 'trim|required|xss_clean|strip_tags|alpha_numeric');
			$this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean|strip_tags');

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
					if( 1 == $results->is_enabled ){
						$this->session->set_userdata('USER_SESSION', $results);
					 	$this->session->set_flashdata('success', 'Login successfully.');
						redirect('Home/index');
					} else {
						$this->session->set_flashdata('warning', "You do not have permission to access this system.");
						redirect('/user/login');
					}
				} else {
					$this->session->set_flashdata('warning', 'Username & Password is invalid.');
					$data['errors'] = validation_errors();
					redirect('/user/login');
				}
			}
		}

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
		$data['title'] 		= 'Email';
		$data['site_url']	= site_url('users/verify_email');

		if( count( $_POST ) > 0 )
		{
			if( $this->form_validation->run() == FALSE )
			{
				$this->session->set_flashdata('error','invalid email id');
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
		is_user_employee(array(3,4));
		password_change_or_expire();

		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['title'] 			= 'Users';
		$data['page_js'] 		= 'user_js';

		$supervisor_results 	= $this->User_model->find_all(5, '', '', 1);
		$qa_results 			= $this->User_model->find_all(6, '', '', 2);
		$manager_results 		= $this->User_model->find_all(1, '', '', 3);

		$data['supervisor_results']	= $supervisor_results;
		$data['qa_results']			= $qa_results;
		$data['manager_results']	= $manager_results;

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
			$this->form_validation->set_rules('avaya_number', 'Avaya Number', 'trim|required|xss_clean|strip_tags|alpha_numeric|callback_check_card');
			$this->form_validation->set_rules('employee_id', 'Employee Id', 'trim|required|xss_clean|strip_tags|alpha_numeric|callback_check_card|is_unique[users.employee_id]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|strip_tags|callback_password_check|callback_check_card');
			$this->form_validation->set_rules('user_type', 'User Type', 'trim|required|xss_clean|strip_tags|alpha_numeric');

			$check_user_type		= $this -> input -> post('user_type', TRUE);

			if( !empty( $check_user_type ))
			{
				if( 1 == $check_user_type ) {

					$this->form_validation->set_rules('job_title', 'Job Title', 'trim|required|xss_clean|strip_tags|alpha_numeric');
				} elseif( ( $check_user_type == 5 ) || ( $check_user_type == 6 ) ) {

					$this->form_validation->set_rules('job_title', 'Job Title', 'trim|required|xss_clean|strip_tags|alpha_numeric');
					$this->form_validation->set_rules('assigned_manager', 'Assign Manager', 'trim|xss_clean|strip_tags');
				} elseif( 2 == $check_user_type ) {

					$this->form_validation->set_rules('assigned_supervisor', 'Assign Supervisor', 'trim|xss_clean|strip_tags');
					$this->form_validation->set_rules('assigned_qa', 'Assign QA', 'trim|xss_clean|strip_tags');
					$this->form_validation->set_rules('assigned_manager', 'Assign Manager', 'trim|xss_clean|strip_tags');
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
				$avaya_number 		= $this -> input -> post('avaya_number', TRUE);
				$employee_id 		= $this -> input -> post('employee_id', TRUE);
				$password 			= $this -> input -> post('password', TRUE);
				$email 				= $this -> input -> post('email', TRUE);
				$hire_date 			= strtotime($this -> input -> post('hire_date', TRUE));
				$username 			= $employee_id;
				$is_change_password = $this -> input -> post('is_change_password', TRUE);
				$activation_code 	= null;
				$created_date 		= time();
				$expire_time 		= null;
				$assigned_qa 		= null;
				$assigned_supervisor = null;
				$assigned_manager 	= null;
				$job_title 			= null;

				if( ( 4 == $check_user_type ) && ( 3 == $user_session->user_type ) ) {

					$user_type		= 4;
				} elseif( 1 == $check_user_type ) {

					$user_type		= 1;
					$job_title 		= $this -> input -> post('job_title', TRUE);
				} elseif( ( $check_user_type == 5 ) || ( $check_user_type == 6 ) ) {

					// $user_type			= 1;
					$user_type			= $check_user_type;
					$job_title 			= $this -> input -> post('job_title', TRUE);
					$assigned_manager 	= $this -> input -> post('assigned_manager', TRUE);
				} else {

					$user_type			 = 2;
					$assigned_supervisor = $this -> input -> post('assigned_supervisor', TRUE);
					$assigned_qa 		 = $this -> input -> post('assigned_qa', TRUE);
					$assigned_manager 	 = $this -> input -> post('assigned_manager', TRUE);
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
					'avaya_number'  		=> $avaya_number,
					'employee_id' 			=> $employee_id,
					'email' 				=> $email,
					'password' 				=> $password_enc,
					'first_name'			=> $first_name,
					'last_name' 			=> $last_name,
					'job_title' 			=> $job_title,
					'assigned_qa'			=> $assigned_qa,
					'assigned_supervisor'	=> $assigned_supervisor,
					'assigned_manager'		=> $assigned_manager,
					'is_change_password'	=> $is_change_password,
					'previous_password' 	=> json_encode($previous_password),
					'hire_date' 			=> $hire_date,
					'activation_code' 		=> $activation_code,
					'created_date'			=> $created_date
				);

				if( $this->User_model->add( $insert_record ) )
				{
					$this->session->set_flashdata('success', 'User added successfully.');
					redirect('/user/index');
				}
				else
				{
					$this->session->set_flashdata('error', 'User addition failed.');
					$data['errors'] = validation_errors();
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
		is_user_employee(array(3,4));
		password_change_or_expire();

		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;

		$data['title'] 			= 'Users';
		$data['page_js'] 		= 'user_js';
		$not_added_user_array 	= array();

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 			= $csrf;

		if( !empty($_FILES['file_name']['name']) && isset($_POST) )
		{
			$this->load->library('csv_reader');

			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('default_password', 'Password', 'trim|required|xss_clean|strip_tags|callback_password_check|callback_check_card');

			if( $this->form_validation->run() == FALSE ) {

				$this->session->set_flashdata('warning', 'Please enter valid password!');
				$data['errors'] = validation_errors();
			} else {

				$password 			= $this->input->post('default_password', TRUE);
				$is_change_password = $this->input->post('is_change_password', TRUE);

				if($is_change_password) {

					$is_change_password = 1;
				} else {

					$is_change_password = 0;
				}

				$file 				= $_FILES['file_name'];
				$file_name 			= $file['name'];
				$file_name 			= space_to_symbol($file_name);
				$file_ext 			= get_extention($file_name);

				$file_name 			= get_extention($file_name, 'filename');
				$file_name 			= $file_name .'_' . time() . '.' . $file_ext;

				$file_header_array 	= array(
					'Employee ID', 'First Name', 'Last Name', 'Client', 'Campaign', 'User Type', 'Title', "Supervisor's Employee ID", "QA's Employee ID", "Manager's Employee ID", 'Date of joining'
				);

				$path = CSV_ROOT_UPLOAD_PATH . '/';

				$is_uploaded = $this->do_upload($file_name, $field_name='file_name', $path);

				if( !$is_uploaded['error'] ) {

					$csv_file 	= $path.$file_name;
					$results 	= $this->csv_reader->parse_file($csv_file);

					$last 		= count($results);
					$counter 	= 0;
					$counter1 	= 0;
					$not_added_counter 	= 0;
					$file_header = array();

					foreach ($results[1] as $key => $header_result) {
						array_push($file_header, $key);
					}

					if( array_diff($file_header_array, $file_header) ) {

						$this->session->set_flashdata('warning', 'Please import valid csv file!');
						redirect('/user/create_bulk');
					}

					foreach( $results as $result ) {

						$employee_id 		= $result['Employee ID'];
						$first_name 		= $result['First Name'];
						$last_name 			= $result['Last Name'];
						$email 				= $result['Client'];
						$username 			= $result['Employee ID'];
						$avaya_number 		= $result['Campaign'];
						$hire_date 			= strtotime($result['Date of joining']);
						$created_date 		= time(); //strtotime(date('Y-m-d'));

						$activation_code 	= null;
						$expire_time 		= null;
						$assigned_qa 		= null;
						$assigned_supervisor = null;
						$assigned_manager 	= null;
						$job_title 			= null;

						$find_user_type 	= $result['User Type'];

						if( !empty($employee_id) && !empty($first_name) && !empty($last_name) && !empty($avaya_number) && !empty($find_user_type) ){

							if( ($find_user_type == 'Employee') || ($find_user_type == 'employee') ) {
								if( !empty($result["Supervisor's Employee ID"])) {
									$assigned_supervisor = $result["Supervisor's Employee ID"];
									$is_exists_assigned_supervisor =  $this->User_model->user_id_exists( '', $assigned_supervisor );
								}

								if( !empty($result["QA's Employee ID"])) {
									$assigned_qa = $result["QA's Employee ID"];
									$is_exists_assigned_qa =  $this->User_model->user_id_exists( '', $assigned_qa );
								}

								if( !empty($result["Manager's Employee ID"])) {
									$assigned_manager = $result["Manager's Employee ID"];
									$is_exists_assigned_manager =  $this->User_model->user_id_exists( '', $assigned_manager );
								}

								$user_type = 2;
							} elseif( ($find_user_type == 'Manager') ||  ($find_user_type == 'manager') ) {

								$user_type 		= 1;
								$job_title 		= 3;

							} elseif( ($find_user_type == 'Quality Analyst') ||  ($find_user_type == 'quality analyst') ) {

								if( !empty($result["Manager's Employee ID"])) {
									$assigned_manager = $result["Manager's Employee ID"];
									$is_exists_assigned_manager =  $this->User_model->user_id_exists( '', $assigned_manager );
								}

								$user_type 		= 6;
								$job_title 		= 2;

							} elseif( ($find_user_type == 'Supervisor') ||  ($find_user_type == 'supervisor') ) {

								if( !empty($result["Manager's Employee ID"])) {
									$assigned_manager = $result["Manager's Employee ID"];
									$is_exists_assigned_manager =  $this->User_model->user_id_exists( '', $assigned_manager );
								}

								$user_type 		= 5;
								$job_title 		= 1;

							} elseif( ($find_user_type == 'ADMIN') || ($find_user_type == 'Admin') || ($find_user_type == 'admin') ) {
								$user_type = 4;
							}


							$password_enc = md5_hash( $password );

							$previous_password  	= array($created_date => $password_enc);

							$insert_record = array(
								'employee_id' 		=> $employee_id,
								'user_type' 		=> $user_type,
								'avaya_number' 		=> $avaya_number,
								'username'  		=> $username,
								'email' 			=> $email,
								'job_title'			=> $job_title,
								'password' 			=> $password_enc,
								'first_name'		=> $first_name,
								'last_name' 		=> $last_name,
								'assigned_qa' 		=> $assigned_qa,
								'assigned_supervisor' => $assigned_supervisor,
								'assigned_manager' 	=> $assigned_manager,
								'is_change_password'=> $is_change_password,
								'hire_date' 		=> $hire_date,
								'activation_code' 	=> $activation_code,
								'created_date' 		=> $created_date,
								'previous_password' => json_encode($previous_password)
							);

							$is_exists_employee_id =  $this->User_model->user_id_exists( '', $employee_id );

							$not_inserted_record = array(
								'employee_id' 		=> $employee_id,
								'user_type' 		=> $user_type,
								'avaya_number' 		=> $avaya_number,
								'email' 			=> $email,
								'job_title'			=> $job_title,
								'first_name'		=> $first_name,
								'last_name' 		=> $last_name,
								'assigned_qa' 		=> $assigned_qa,
								'assigned_supervisor' => $assigned_supervisor,
								'assigned_manager' 	=> $assigned_manager,
								'hire_date' 		=> $hire_date
							);

							if( empty($is_exists_employee_id) ) {

								if( (!empty($assigned_qa) && empty($is_exists_assigned_qa)) || (!empty($assigned_supervisor) && empty($is_exists_assigned_supervisor)) || (!empty($assigned_manager) && empty($is_exists_assigned_manager)) ){

									$not_inserted_record['reason']	= '<strong style="color:red;">Assigned QA or Supervisor or Manager does not exists</strong>';
									$not_added_counter++;
									$not_added_record[] = $not_inserted_record;

								} else {

									$this->User_model->add( $insert_record );
									$counter++;
								}

							} else {

								$not_inserted_record['reason']	= '<strong style="color:red;">Employee Already exists</strong>';
								$not_added_counter++;
								$not_added_record[] = $not_inserted_record;
							}

						} else {

							$not_inserted_record = array(
								'employee_id' 		=> $employee_id,
								'user_type' 		=> $user_type,
								'avaya_number' 		=> $avaya_number,
								'email' 			=> $email,
								'job_title'			=> $job_title,
								'first_name'		=> $first_name,
								'last_name' 		=> $last_name,
								'assigned_qa' 		=> $assigned_qa,
								'assigned_supervisor' => $assigned_supervisor,
								'assigned_manager' 	=> $assigned_manager,
								'hire_date' 		=> $hire_date,
								'reason'			=> '<strong style="color:red;">All important fields are required</strong>'
							);
							$not_added_counter++;
							$not_added_record[] = $not_inserted_record;
						}

						$counter1++;
					}

					$data['not_added_record'] 	= $not_added_record;

					if( $counter1 == $last ) {

						if( !empty($not_added_record ) ) {
							$this->session->set_flashdata('warning', $not_added_counter.' User(s) is/are not added!');

						} elseif( $counter ) {
							$this->session->set_flashdata('success', $counter.' user added successfully.');
							redirect('/user/index');
						}
					}
				} else {

					$this->session->set_flashdata('warning', ' The file you are attempting to upload is not allowed.');
				}
			}
		}

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('User/create_bulk', $data);
		$this->load->view('layouts/footer', $data);
	}
	//================================================

	function export_sample_users()
	{
		is_user_employee(array(3,4));
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=bulk_users_sample.csv');
		$output = fopen('php://output', 'w');

		$header_array 	= array(
			'Employee ID', 'First Name', 'Last Name', 'Client', 'Campaign', 'User Type', 'Title', "Supervisor's Employee ID", "QA's Employee ID", "Manager's Employee ID", 'Date of joining'
		);

		fputcsv($output, $header_array);

		$append_record = array(
			"Employee ID" 			=> "RCC123",
			"First Name" 			=> "John",
			"Last Name" 			=> "Smith",
			"Client"	 			=> "" ,
			"Campaign" 			=> "12abc",
			"User Type" 			=> "Employee",
			"Title" 				=> "",
			"Supervisor's Employee ID" => "s123",
			"QA's Employee ID" 		=> "qa123",
			"Manager's Employee ID" => "m123",
			"Date of joining" 		=> "2016-09-27"
		);
		fputcsv($output, $append_record);

		$append_record1 = array(
			"Employee ID" 			=> "RCC124",
			"First Name" 			=> "Sebatian",
			"Last Name" 			=> "Gomez",
			"Client"	 			=> "rcc@mailinator.com" ,
			"Campaign" 				=> "13abc",
			"User Type" 			=> "Manager",
			"Title" 				=> "Supervisor",
			"Supervisor's Employee ID" => "",
			"QA's Employee ID" 		=> "",
			"Manager's Employee ID" => "",
			"Date of joining" 		=> "2016-09-27"
		);

		fputcsv($output, $append_record1);
	}
	//================================================

	public function edit( $id )
	{
		$data['navBarNumber'] 	= 3;
		is_user_login();
		is_user_employee( array(3,4) );
		password_change_or_expire();

		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['title'] 			= 'Users';
		$data['page_js'] 		= 'user_js';

		$supervisor_results 	= $this->User_model->find_all(1, '', '', 1);
		$qa_results 			= $this->User_model->find_all(1, '', '', 2);
		$manager_results		= $this->User_model->find_all(1, '', '', 3);

		$data['supervisor_results']	= $supervisor_results;
		$data['qa_results']			= $qa_results;
		$data['manager_results']	= $manager_results;

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 			= $csrf;
		$data['result'] 		= '';
		$is_exists 				= $this->User_model->user_id_exists( $id );

		if( empty( $is_exists ) )
		{
			$this->session->set_flashdata('error', 'Record not existed.');
			redirect('/user/index');
		}

		$result 		= $this->User_model->find( $id );

		if( $result->id != $user_session->id ){

			if( 4 == $user_session->user_type ){
				$data['result'] = ( ( $result->user_type != 3 ) && ( $result->user_type != 4 )  ) ? $result : '';
			} else {

				$data['result'] = ( $result->user_type != 3 ) ? $result : '';
			}

		} else {

			$data['result'] = '';
		}

		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean|strip_tags|alpha');
			$this->form_validation->set_rules('last_name', 'Last name', 'trim|required|xss_clean|strip_tags|alpha');
			$this->form_validation->set_rules('avaya_number', 'Avaya Number', 'trim|required|xss_clean|strip_tags|alpha_numeric|callback_check_card');
			$this->form_validation->set_rules('hire_date', 'Hire Date', 'trim|required|xss_clean|strip_tags');

			$password 		= $this -> input -> post('edit_password', TRUE);

			if( !empty($password) ){

				$this->form_validation->set_rules('edit_password', 'Password', 'trim|required|xss_clean|strip_tags|callback_password_check|callback_check_card');
			}

			if( 2 == $result->user_type ) {
				$this->form_validation->set_rules('assigned_supervisor', 'Assigned Supervisor', 'trim|xss_clean|strip_tags');
			}

			if( $this->form_validation->run() == FALSE )
			{
				$this->session->set_flashdata('warning', 'User updation failed.');
				$data['errors'] = validation_errors();
			}
			else
			{
				$first_name 		= $this -> input -> post('first_name', TRUE);
				$last_name 			= $this -> input -> post('last_name', TRUE);
				// $password 			= $this -> input -> post('edit_password', TRUE);
				$avaya_number 		= $this -> input -> post('avaya_number', TRUE);
				$email 				= $this -> input -> post('email', TRUE);
				$hire_date 			= strtotime($this -> input -> post('hire_date', TRUE));

				if( 2 == $result->user_type ) {

					$assigned_supervisor = $this -> input -> post('assigned_supervisor', TRUE);
					$assigned_qa 		 = $this -> input -> post('assigned_qa', TRUE);
					$assigned_manager 	 = $this -> input -> post('assigned_manager', TRUE);

					$insert_record = array(
						'email' 				=> $email,
						'first_name'			=> $first_name,
						'avaya_number'			=> $avaya_number,
						'last_name' 			=> $last_name,
						'assigned_supervisor' 	=> $assigned_supervisor,
						'assigned_qa' 			=> $assigned_qa,
						'assigned_manager' 		=> $assigned_manager,
						'hire_date' 			=> $hire_date
					);
				} else {
					$assigned_manager 	 = $this -> input -> post('assigned_manager', TRUE);
					$insert_record = array(
						'email' 				=> $email,
						'first_name'			=> $first_name,
						'avaya_number'			=> $avaya_number,
						'last_name' 			=> $last_name,
						'hire_date' 			=> $hire_date
					);
					if( !empty($assigned_manager) ){
						$insert_record['assigned_manager'] = $assigned_manager;
					}
				}

				if( !empty($password) ){
					$insert_record['password'] = md5_hash($password);
				}

				$this->User_model->update( $insert_record, $id );
				$this->session->set_flashdata('success', 'User updated successfully.');
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
		is_user_employee( array(3,4) );
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

		$data['all_managers'] 	= $all_managers;

		if( count( $_POST ) > 0 )
		{
			$this->form_validation->set_error_delimiters('<p class="has-error">', '</p>');
			$this->form_validation->set_rules('assigned_user', 'Supervisor, QA or Manager', 'trim|required|xss_clean|strip_tags');
			$this->form_validation->set_rules('select_employee[]', 'Select Employee', 'trim|required|xss_clean|strip_tags');

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

				$assigned_user 	= explode(':', $assigned_user );

				$assigned_user_employee_id = $assigned_user[0];

				if( $assigned_user[1] == "Supervisor" ) {
					$column_name = "assigned_supervisor";
				} elseif ( $assigned_user[1] == "Quality Analyst" ) {
					$column_name = "assigned_qa";
				} else {
					$column_name = "assigned_manager";
				}

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
		is_user_employee(array(3,4));
		password_change_or_expire();

		if ($this->input->is_ajax_request()) {

			$job_title 		= $this -> input -> post('job_title', TRUE);

			if( $job_title == "Supervisor" ) {
				$column_name = "assigned_supervisor";
			} elseif ( $job_title == "Quality Analyst" ) {
				$column_name = "assigned_qa";
			} else {
				$column_name = "assigned_manager";
			}

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
		is_user_employee(array(3,4));
		password_change_or_expire();

		if ($this->input->is_ajax_request()) {
			// $employee_id 	= $_GET['employee_id'];

			$employee_id 	= $this->input->get('employee_id');

			$is_exists_employee_id =  $this->User_model->user_id_exists( '', $employee_id );

			if( empty($is_exists_employee_id) )
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
		is_user_employee(array(3,4));
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
				$this->form_validation->set_rules('avaya_number', 'Avaya Number', 'trim|required|xss_clean|strip_tags|alpha_numeric|callback_check_card');
				$first_name = $this -> input -> post('first_name', TRUE);
				$last_name	= $this -> input -> post('last_name', TRUE);
				$username	= $this -> input -> post('username', TRUE);
				$avaya_number	= $this -> input -> post('avaya_number', TRUE);
			}

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
					$set_data	= array('first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'avaya_number'=>$avaya_number);
				}
				else
				{
					$set_data	= array('email' => $email);
				}

				if( $this->User_model->update( $set_data, $id) )
				{
					$result 			= $this->User_model->find( $user_session->id );
					$this->session->set_userdata('USER_SESSION', $result);
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
			$this->form_validation->set_rules('current_password', 'Current Password', 'trim|required|xss_clean|strip_tags|callback_check_card');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|strip_tags|callback_password_check|callback_check_card');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|strip_tags|matches[new_password]');

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
			$this->form_validation->set_message("check_card", 'Chain numbers are not allowed');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	//================================================

	function password_check($str)
	{
		if ( preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{12,}$/', $str) ) {
			return TRUE;
		}
		$this->form_validation->set_message("password_check", 'Password must contain atleast one number,<br/>one speacial character, one upper and lower<br/>lettes with minimum 12 char length');
		return FALSE;
	}
}