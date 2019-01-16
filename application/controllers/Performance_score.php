<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Performance_score extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Performance_score_model');
		$this->load->model('User_model');
		is_user_login();
		password_change_or_expire();
	}
	//================================================

	public function index()
	{
		$data['title'] 			= 'Performance Score';
		$data['page_js'] 		= 'performance_score_js';
		$data['navBarNumber'] 	= 7;

		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['result'] 		= '';

		$added_score_array 		= array();

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;

		if( !empty($_FILES))
		{
			$this->load->library('csv_reader');

			$score_type 	= $this->input->post('score_type');

			$file 			= $_FILES['file_name'];

			$file_name 		= $file['name'];
			$file_name 		= space_to_symbol($file_name);
			$file_ext 		= get_extention($file_name);

			$file_name 		= get_extention($file_name, 'filename');

			$file_name 		= $file_name .'_' . time() . '.' . $file_ext;

			$path = CSV_ROOT_UPLOAD_PATH . '/';
			$is_error = $this->do_upload($file_name, 'file_name', $path);

			$file_header_array 	= array(
				'Employee ID', 'Name', 'Client', 'Date', 'Score'
			);

			if( !$is_error['error'] )
			{
				$csv_file 	= $path.$file_name;
				$results 	= $this->csv_reader->parse_file($csv_file);

				$last 		= count($results);
				$counter 	= 0;
				$counter1 	= 0;

				$file_header = array();

				foreach ($results[1] as $key => $header_result) {
					array_push($file_header, $key);
				}

				if( array_diff($file_header_array, $file_header) ) {

					$response['error'] = 'Please import valid csv file!';
					$response['hash_token'] = $this->security->get_csrf_hash();
					echo json_encode($response);
					die;
				}

				foreach( $results as $result )
				{
					$employee_id 		= $result['Employee ID'];
					$name 				= $result['Name'];
					$avaya_number 		= $result['Client'];
					$date 				= $result['Date'];
					$score 				= $result['Score'];

					$insert_record = array(
						"employee_id" 		=> $employee_id,
						"name" 				=> $name,
						"avaya_number" 		=> $avaya_number,
						"date" 				=> strtotime($date),
						"score_type"		=> $score_type,
						"score"				=> $score
					);

					$show_record = array(
						"employee_id" 		=> $employee_id,
						"name" 				=> $name,
						"avaya_number" 		=> $avaya_number,
						"date" 				=> $date,
						"score_type"		=> $score_type,
						"score"				=> $score
					);

					if( !empty($employee_id) && !empty($name) && !empty($avaya_number) && !empty($date) && !empty($score) ) {

						$is_user_exists  =  $this->User_model->user_id_exists( '', $employee_id );

						if( !empty($is_user_exists) )
						{
							if( (1 == $score_type) || (2 == $score_type) ) {

								$counter1++;
								$inserted_id = $this->Performance_score_model->add( $insert_record );

								$show_record['action'] = 'Record added~2';
								$final_arr[] = $show_record;
								// $show_record['action'] = $inserted_id;
								// $final_arr[] = $show_record;
							} else {

								$is_exists_employee_id  =  $this->Performance_score_model->user_id_exists( $employee_id, strtotime($date), $score_type );
								$update_score_type 		= $is_exists_employee_id->score_type;
								$update_date 			= $is_exists_employee_id->date;

								if( empty($is_exists_employee_id) ) {
									$counter1++;
									$inserted_id = $this->Performance_score_model->add( $insert_record );

									$show_record['action'] = 'Record added~2';
									$final_arr[] = $show_record;

									// $show_record['action'] = $inserted_id;
									// $final_arr[] = $show_record;
								} else {

									// $counter1++;
									$show_record['action'] = 'Duplicate entry~1';
									$final_arr[] = $show_record;

									// $this->Performance_score_model->update( $insert_record, $employee_id, $update_score_type, $update_date );
									// $updated_id = $this->Performance_score_model->find_updated_id( $employee_id, $update_score_type, $update_date );
									// $show_record['action'] = site_url('performance_score').'~'.$updated_id;
									// $final_arr[] = $show_record;
								}
							}
						} else {
							$show_record['action'] = 'Employee does not exists~1';
							$final_arr[] = $show_record;
						}
					} else {
						$show_record['action'] = 'All fields are required~1';
						$final_arr[] = $show_record;
					}
					$counter++;
				}

				if( $counter == $last )
				{
					$response['records'] = $final_arr;
					$response['hash_token'] = $this->security->get_csrf_hash();

					echo json_encode($response);
					die;
				}
				die;
			} else {

				$response['error'] = 'The file you are attempting to upload is not allowed';
				$response['hash_token'] = $this->security->get_csrf_hash();

				echo json_encode($response);
				die;
			}
		}


		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		if( ( 3 == $user_session->user_type ) || ( 4 == $user_session->user_type ) ) {

			$this->load->view('Performance/add_scores_admin', $data);
		} elseif( (1 == $user_session->user_type) || (5 == $user_session->user_type) || (6 == $user_session->user_type) ) {

			$this->load->view('Performance/add_scores_manager', $data);
		} else {

			$this->load->view('Performance/add_scores', $data);
		}

		$this->load->view('layouts/footer', $data);
	}
	//================================================

	public function remove()
	{
		is_user_employee(array(3,4));
		if ($this->input->is_ajax_request()) {

			$id 	= $this -> input -> post('id');

			if( $this->Performance_score_model->delete($id) )
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

	public function find_performance_score()
	{
		if ($this->input->is_ajax_request()) {

			$user_session	= $this->session->userdata('USER_SESSION');
			$employee_id 	= $user_session->employee_id;
			$score_type  	= $this -> input -> post('score_type');

			$user_employee_id = $this -> input -> post('employee_id');


			if( !empty($user_employee_id) ){

				$all_score_records = $this->Performance_score_model->find_score( $user_employee_id, $score_type, true );
			} else {
				$all_score_records = $this->Performance_score_model->find_score( $employee_id, $score_type );
			}

			// print('<pre>');
			// print_r($all_score_records);
			// die;

			if(!empty($all_score_records))
			{
				foreach($all_score_records as $key => $all_score_record)
				{
					$filtered_da['s_n'] 			= $key+1;
					$filtered_da['name'] 			= $all_score_record->name;
					$filtered_da['avaya_number'] 	= $all_score_record->avaya_number;
					$filtered_da['date'] 			= date( 'Y-m-d H:i:s', $all_score_record->date );
					$filtered_da['score'] 			= $all_score_record->score;

					$filtered_data[] = $filtered_da;
				}
			}

			$response['hash_token'] = $this->security->get_csrf_hash();

			if( !empty($filtered_data) )
				$response['data']   	= $filtered_data;
			else
				$response['data']   	= '';

			echo json_encode($response);
			exit;
		} else {
			$this->session->set_flashdata('warning','No direct script access allowed!');
			redirect('/home/index');
		}
	}
	//================================================

	public function view_performance_score()
	{
		is_user_employee(array(3,4));
		$data['title'] 			= 'Performance Score';
		$data['page_js'] 		= 'performance_score_js';
		$data['navBarNumber'] 	= 7;

		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['result'] 		= '';

		$added_score_array 		= array();

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);

		$data['csrf'] 	= $csrf;

		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');
		$this->load->view('Performance/view_performance_scores', $data);
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

			$score_type  	= $this->input->post('score_type');

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

			if( ( 1 == $user_session->user_type ) || ( 5 == $user_session->user_type) || ( 6 == $user_session->user_type) ) {

				$results 		= $this->Performance_score_model->find_all_assigned_number( $user_session->employee_id, $search_str, $score_type );
				$user_lists 	= $this->Performance_score_model->find_all_assigned( $user_session->employee_id, $search_str,  $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by'], $score_type );
			} else {

				$user_lists 	= $this->Performance_score_model->find_all_performance_score( $search_str,  $query_parameter['limit'], $query_parameter['start'], $query_parameter['type'], $query_parameter['order_by'], $score_type );
				$results 			= $user_lists;
			}

			// print('<pre>');
			// print_r($user_lists);
			// die;

			$response['data']         		= $this->user_filter( $user_lists, $query_parameter['start']+1 );

			$response['recordsFiltered'] 	= (!empty($results)) ? count($results) :0;

			$response['hash_token']   		= $this->security->get_csrf_hash();

			$response['recordsTotal']   	= (!empty($results)) ? count($results) :0;

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
			$user_session	= $this->session->userdata('USER_SESSION');

			switch ($column)
			{

				// by default order byid
				case '0':
					$str = "id";
					return $str;
				break;

				// order by title
				case '1':
					$str = ( ( 1 == $user_session->user_type ) || ( 5 == $user_session->user_type ) || ( 6 == $user_session->user_type ) ) ? "first_name" : "name";
					return $str;
				break;

				case '2':
					$str = "employee_id";
					return $str;
				break;

				case '3':
					$str = ( ( 1 == $user_session->user_type ) || ( 5 == $user_session->user_type ) || ( 6 == $user_session->user_type ) ) ? "email" : "score";
					return $str;
				break;

				case '4':
					$str = "avaya_number";
					return $str;
				break;

				case '5':
					$str = "date";
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

					$filtered_da['id'] 							= $i;
					$filtered_da['first_name'] 					= ( ( 1 == $user_session->user_type ) || ( 5 == $user_session->user_type ) || ( 6 == $user_session->user_type ) ) ? $users->first_name.' '.$users->last_name.'~&'.$users->employee_id.'~&'.$users->score_type : $users->name;
					$filtered_da['employee_id'] 				= $users->employee_id;
					if( ( 1 == $user_session->user_type ) || ( 5 == $user_session->user_type ) || ( 6 == $user_session->user_type ) ) {

						$filtered_da['email'] 					= $users->email;
					} else {
						$filtered_da['score'] 					= $users->score;
						$filtered_da['avaya_number'] 			= $users->avaya_number;
						$filtered_da['date'] 					= date('Y-m-d H:i:s', $users->date);
						$filtered_da['action'] 					= site_url('performance_score').'~'.$users->id;
					}

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

	function export_sample_score()
	{
		is_user_employee(array(3,4));
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=performance_score_sample.csv');
		$output = fopen('php://output', 'w');

		$header_array 	= array(
			'Employee ID', 'Name', 'Client', 'Date', 'Score'
		);

		fputcsv($output, $header_array);

		$append_record = array(
			"Employee ID" 	=> "RCC123",
			"Name" 			=> "John Smith",
			"Client" 		=> "Client(Campaign)",
			"Date" 			=> "2016-09-27",
			"Score" 		=> "8"
		);
		fputcsv($output, $append_record);
	}
	//================================================

}