<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Home_model');
	}
	//================================================

	public function index()
	{
		// echo mktime( 0, 0, 0, date( 'm', time() ), date( 'd', time() ) - 4, date( 'y', time() ) );
		// die;


		is_user_login();
		password_change_or_expire();
		
		$this->load->model('Performance_model');
		$this->load->model('Notification_model');
		$this->load->model('Global_notification_model');
		$this->load->model('Welcome_quotes_model');
		
		$user_session			= $this->session->userdata('USER_SESSION');
		$data['user_session'] 	= $user_session;
		$data['page_js'] 		= 'user_js';
		$data['navBarNumber'] 	= 1;

		
		$data['title'] 			= 'Dashboard';
		$is_todays_qoutes 		= $this->Welcome_quotes_model->get_current_welcome_qoute( strtotime(date('Y-m-d')));

		if( empty($is_todays_qoutes) )
		{
			$is_todays_qoutes 		= $this->Welcome_quotes_model->get_current_welcome_qoute();					
		}
		
		$data['welcome_quotes_results'] = $is_todays_qoutes;
		$this->load->view('layouts/header', $data);
		$this->load->view('layouts/nav');

		// print_r($user_session->id);
		// die;

		$latest_time 					= $this->Performance_model->get_latest_time( $user_session->id );
		$data['current_Performance'] 	= '';

		if( !empty($latest_time) )
		{
			$current_Performance 		= $this->Performance_model->get_current_score( $latest_time, $user_session->id );
			$data['current_Performance']= $current_Performance;
		}

		// print_r($current_Performance->id);
		// die;

		// $agreement_notifiation_results 	= $this->Notification_model->get_notification_by_assigned_user( $user_session->id, 2, strtotime(date('Y-m-d')) );

		// $traning_notifiation_results 	= $this->Notification_model->get_notification_by_assigned_user( $user_session->id, 3, strtotime(date('Y-m-d')) );

		// $warning_notifiation_results 	= $this->Notification_model->get_notification_by_assigned_user( $user_session->id, 1, strtotime(date('Y-m-d')) );


		$agreement_notifiation_results 	= $this->Notification_model->get_notification_by_assigned_user( $user_session->id, 2, time() );

		$traning_notifiation_results 	= $this->Notification_model->get_notification_by_assigned_user( $user_session->id, 3, time() );

		$warning_notifiation_results 	= $this->Notification_model->get_notification_by_assigned_user( $user_session->id, 1, time() );



		// print_r($warning_notifiation_results);
		// die;

		// $agreement_global_notifiation_results 	= $this->Global_notification_model->get_notification_by_assigned_user( $user_session->id, 2, strtotime(date('Y-m-d')), 2 );
		// $warning_global_notifiation_results 	= $this->Global_notification_model->get_notification_by_assigned_user( $user_session->id, 1, strtotime(date('Y-m-d')), 2 );

		$data['agreement_notifiation_results'] 	= $agreement_notifiation_results;
		$data['warning_notifiation_results'] 	= $warning_notifiation_results;
		$data['traning_notifiation_results'] 	= $traning_notifiation_results;

		// $data['agreement_global_notifiation_results'] 	= $agreement_global_notifiation_results;
		// $data['warning_global_notifiation_results'] 	= $warning_global_notifiation_results;
		

		switch( $user_session->user_type )
		{
			case 1 :	
				$this->load->view('Home/dashboard_manager', $data);	
				break;
			case 5 :	
				$this->load->view('Home/dashboard_manager', $data);	
				break;
			case 6 :	
				$this->load->view('Home/dashboard_manager', $data);	
				break;
			
			case 2:	
				$this->load->view('Home/dashboard_employee', $data);	
				break;

			case 3:	
				$this->load->view('Home/index', $data);
				break;
			case 4 :	
				$this->load->view('Home/index', $data);
				break;
		}
		$this->load->view('layouts/footer', $data);
	}
	//================================================
}