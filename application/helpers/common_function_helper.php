<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function is_user_login(){
	
	$CI = & get_instance();
	$record = $CI->session->userdata('USER_SESSION');
	if(empty($record) )
	{
		redirect(site_url('/user/login'));
	}
}
//==========================================================

function is_user_employee($user_arr){
	
	$CI = & get_instance();
	$record = $CI->session->userdata('USER_SESSION');
	
	if( !in_array($record->user_type, $user_arr) )
	{
		$CI->session->set_flashdata('error', 'You are not authorised person to access this panel.');
		$data['errors'] = validation_errors();
		redirect('/Home/index');
	}
}
//==========================================================

function assigned_employees_list( $id )
{	
	$CI 		  = & get_instance();
	$user_session = $CI->session->userdata('USER_SESSION');
	$CI->load->model('User_model');
	
	$users 	= $CI->User_model->find_all( false, $user_session->employee_id );

	$employees_array = array();

	foreach ($users as $value) {
		array_push($employees_array, $value->id );
	}

	// print_r($employees_array);
	// die;
	if( in_array($id, $employees_array ) )
	{
		// die('true');
		return true;	
	}
	else
	{
		// die('false');
		return false;	
	}

}
//==========================================================

function password_change_or_expire()
{
	$CI =& get_instance();

	$CI->load->model('Settings_model');

	$user_session			= $CI->session->userdata('USER_SESSION');
	$data['user_session'] 	= $user_session;

	$data['page_js'] 		= 'user_js';

	$results 				= $CI->Settings_model->find_all();
	$days 					= (!empty($results)) ? $results[0]->password_expire_time :'';
	
	$today_date 			= time();

	$expired_date 			= '';

	if( !empty($user_session->updated_date) && $days !='' )
	{	
		$updated_date = $user_session->updated_date;
		$expired_date = mktime( 0, 0, 0, date( 'm', $updated_date ), date( 'd', $updated_date ) + $days, date( 'y', $updated_date ) );
	}
	elseif(!empty($user_session->created_date) && $days !='')
	{
		$created_date 		= $user_session->created_date;
		$expired_date = mktime( 0, 0, 0, date( 'm', $created_date ), date( 'd', $created_date ) + $days, date( 'y', $created_date ) );	
		
	}

	// $user_session->{"today_date"} = $today_date;
	// $user_session->{"expired_date"} = $expired_date;

	$user_session->today_date = $today_date;
	$user_session->expired_date = $expired_date;

	$CI->session->set_userdata('USER_SESSION', $user_session);

	// print_r($CI->session->userdata('USER_SESSION'));
	// die;


	if( ($user_session->is_change_password) || ( !empty($expired_date) && date('Y-m-d',$today_date) > date('Y-m-d',$expired_date) ) )
	{
		redirect('/user/change_password/');
	}
}


if(!function_exists('pass_encrypt')){
	
	function pass_encrypt( $string ){
		
		$CI =& get_instance();
		$CI->encrypt->set_cipher( MCRYPT_BLOWFISH );

		$key = $CI->config->item( 'encryption_key' );

		$encrypted_string = $CI->encrypt->encode( $string, $key );
		
		return $encrypted_string;
	}
}
//==========================================================

if ( ! function_exists('get_user_session_info'))
{
	function get_user_session_info($param = 'id')
	{
	    $CI =& get_instance();
	    
	    $session_data	=	$CI->session->userdata('USER_SESSION');
	    
	    if( !empty($session_data) ){
	    	return $session_data->$param;
	    }
	    return false;
	}
}
//==========================================================

if(!function_exists('pass_decrypt')){
	
	function pass_decrypt( $string ){
		
		$CI =& get_instance();
		$CI->encrypt->set_cipher( MCRYPT_BLOWFISH );
		$key = $CI->config->item( 'encryption_key' );

		$encrypted_string = $CI->encrypt->decode( $string, $key );

		return $encrypted_string;
	}
}
//==========================================================

if ( ! function_exists('md5_hash')){
	
	function md5_hash( $string ){
		
		$CI =& get_instance();

		$key = $CI->config->item( 'encryption_key' );

		if(!empty($string))	{
			$string = $key.$string;
			return md5($string);
		}
	}
}
//==========================================================

if ( ! function_exists('generate_random_string')){        
	
	function generate_random_string($length = 10) {
	    
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
}
//==========================================================

if(!function_exists('vic_mail')){
	
	function vic_mail( $to, $subject, $message, $cc = '', $bcc = '', $attachment = '' ){
		
		$CI =& get_instance();

		$CI->email->set_newline("\r\n");

		$from_email = $CI->config->item( 'from_email' );
		$from_name = $CI->config->item( 'from_name' );

		$CI->email->clear(TRUE);

		$CI->email->from( $from_email, $from_name);
		//$CI->email->reply_to('you@example.com', 'Your Name');

		$CI->email->to( $to );

		$CI->email->subject( $subject );
		
		$CI->email->message( $message );
		//$CI->email->set_alt_message('This is the alternative message');

		if( !empty($cc) ){
			$CI->email->cc( $cc );
		}

		if( !empty($bcc) ){
			$CI->email->bcc( $bcc );
		}

		if( !empty($attachment) ){
			$CI->email->attach( $attachment );
		}


		if($CI->email->send()){
		
			return true;
		} else {
			return false;
		}
	}
}
//==========================================================

if(!function_exists('space_to_symbol')){
	function space_to_symbol( $text, $replacewith = '_' )
	{
		return preg_replace( '/[^a-zA-Z0-9\.]/', $replacewith, $text );
	}
}
//==============================================================

if(!function_exists('get_extention')){
	function get_extention( $file_name, $option = 'extension' )
	{
		// option : filename
		if ( !empty( $file_name ) ) {
			$ext = pathinfo( $file_name );
			
			return $ext[ $option ];
		} //!empty( $file_name )
		return false;
	}
}
//==============================================================

function check_card_number($credit_card_number)
{
	$flag = 0;
	if(preg_match('/^3\d{3}[ \-]?\d{6}[ \-]?\d{5}$/', $credit_card_number))
	{	
		return true;
	}
	else if(preg_match('/^4\d{3}[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $credit_card_number))
	{
		return true;
	}
	else if(preg_match('/^5\d{3}[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $credit_card_number))
	{
		return true;
	}
	else if(preg_match('/^6011[ \-]?\d{4}[ \-]?\d{4}[ \-]?\d{4}$/', $credit_card_number))
	{
		return true;
	}
	else if(preg_match('/^(?:(?:2131|1800|35\d{3})\d{11})$/', $credit_card_number))
	{
		return true;
	}
	else if(preg_match('/^(?:3(?:0[0-5]|[68][0-9])[0-9]{11})$/', $credit_card_number))
	{
		return true;
	}
	else if(preg_match('/\d+/', $credit_card_number))
	{
		preg_match_all('/\d+/', $credit_card_number, $strArray);
		$i = 0;
	    for($i=0; $i<count($strArray[0]);$i++)
	    {
	    	$lengthDigits 	= strlen($strArray[0][$i]);
	    	if($lengthDigits > 11)
	    	{
	    		$flag += 1;
	    	}
	    }
	    if($flag > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}
//==============================================================

?>