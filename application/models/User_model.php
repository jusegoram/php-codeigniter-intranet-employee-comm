<?php
class User_model extends CI_Model
{
	public function login( $username = false, $password = false )
	{
		$this->db->select('*');
		$this->db->from('users');
		
		$this->db->where('password', $password);

		$this->db->where('username', $username);
		
		//$this->db->or_where('email_id', $username);

		$query = $this->db->get();

		//$query->num_rows()
		// print_r($this->db->last_query());
		// die;
		if( $query->num_rows() > 0 )
		{
			return $query->row();  
		}
		else
		{ 
			return false;
		}
	}
	//===================================================

	public function find_all( $user_type = false, $user_id = false, $search = false, $job_title = false, $is_only_employee = false )
	{
		if( $search )
			$this->db->select('id');
		else
			$this->db->select('*');
		$this->db->from('users');

		if( $search ) {
			
			$like_where = '(`first_name` LIKE "%'.$search.'%" ESCAPE "!" OR  `last_name` LIKE "%'.$search.'%" ESCAPE "!")';
			$this->db->where($like_where);
		}		
		
		if( false !==  $user_type )
		{
			if( ( 3 == $user_type ) || ( 4 == $user_type )  )
			{
				$where ='(user_type != 3 AND user_type != 4)';
				$this->db->where($where);
				// $this->db->where("user_type !=" , 3);
			} else if( ( 1 == $user_type ) && ($is_only_employee) ) {
				
				$where ='(assigned_qa= "'.$user_id.'" OR assigned_supervisor= "'.$user_id.'" OR assigned_manager = "'.$user_id.'" OR user_type = "2")';
				$this->db->where($where);
			} else {
				
				$where ='(user_type = 1 OR user_type = 5 OR user_type = 6)';
				$this->db->where($where);
				if( $job_title ) {
					$this->db->where('job_title', $job_title);
				} else {
					$this->db->where('job_title !=', null);
				}
			}

		} else {

			if($is_only_employee){

				$where ='(assigned_qa= "'.$user_id.'" OR assigned_supervisor= "'.$user_id.'" OR assigned_manager = "'.$user_id.'" OR user_type = "2")';
			} else{

				$where ='(assigned_qa= "'.$user_id.'" OR assigned_supervisor= "'.$user_id.'" OR assigned_manager = "'.$user_id.'")';
			}
			$this->db->where($where);
		}

		$query = $this->db->get();
		// print_r($this->db->last_query());
		// die;
		if($query->num_rows() > 0)
		{
			$results = $query->result();
			return $results;
		}
		else
		{
			return false;
		}
	}
	//===================================================

	public function find_all_pagination( $user_type = false, $user_id = false, $search = false, $limit = false, $start = false, $order_by = false, $order_by_name = false, $is_only_employee = false )
	{

		$this->db->select('*');
		$this->db->from('users');
		
		if( $search ) {
			
			$like_where = '(`first_name` LIKE "%'.$search.'%" ESCAPE "!" OR  `last_name` LIKE "%'.$search.'%" ESCAPE "!")';
			$this->db->where($like_where);
		}

		if( false !==  $user_type )
		{
			if( ( 3 == $user_type ) || ( 4 == $user_type ) )
			{
				$where ='(user_type != 3 AND user_type != 4)';
				$this->db->where($where);
			} else {
				
				$this->db->where('user_type', $user_type);
			}
		} else {

			if($is_only_employee){

				$where ='(assigned_qa= "'.$user_id.'" OR assigned_supervisor= "'.$user_id.'" OR assigned_manager = "'.$user_id.'" OR user_type = "2")';
			} else{

				$where ='(assigned_qa= "'.$user_id.'" OR assigned_supervisor= "'.$user_id.'" OR assigned_manager = "'.$user_id.'")';
			}
			$this->db->where($where);
		}

		$this->db->order_by($order_by_name, $order_by);
		$this->db->limit($limit, $start);

		$query = $this->db->get();
		
		// print_r($this->db->last_query());
		// die;

		if($query->num_rows() > 0)
		{
			$results = $query->result();
			return $results;
		}
		else
		{
			return false;
		}
	}
	//=========================

	public function find_all_admin( $user_type = false, $search = false, $limit = false, $start = false, $order_by = false, $order_by_name = false )
	{

		$this->db->select('*');
		$this->db->from('users');
		
		if( $search ) {
			
			$like_where = '(`first_name` LIKE "%'.$search.'%" ESCAPE "!" OR  `last_name` LIKE "%'.$search.'%" ESCAPE "!")';
			$this->db->where($like_where);
		}

		$this->db->where('user_type', $user_type);
		
		$this->db->order_by($order_by_name, $order_by);
		$this->db->limit($limit, $start);

		$query = $this->db->get();
		
		// print_r($this->db->last_query());
		// die;

		if($query->num_rows() > 0)
		{
			$results = $query->result();
			return $results;
		}
		else
		{
			return false;
		}
	}
	//=========================

	public function find_users( $user_type = false, $column_name = false )
	{
		$this->db->select('employee_id, first_name, last_name');
		$this->db->from('users');
		
		if( $column_name == 'assigned_manager' ){

			$where ='(user_type = 5 OR user_type = 6 OR user_type = 2)';
			$this->db->where($where);
		} else {

			$this->db->where("user_type" , $user_type);
		}

		$where ='('.$column_name.'= "" OR '.$column_name.' IS NULL)';

		$this->db->where($where);

		// $this->db->where($column_name, null);
		
		$query = $this->db->get();

		// print_r( $this->db->last_query() );
		// die;
		
		if($query->num_rows() > 0)
		{
			$results = $query->result();

			return $results;
		}
		else
		{
			return false;
		}
	}
	//===================================================

	public function update_assigned_user( $employee_id = false, $data = false )
	{
		$this->db->where("employee_id", $employee_id);
		$this->db->update('users', $data);
		return true;
	}
	//===================================================

	public function add( $data = false )
	{
		$this->db->insert('users', $data);
		if ($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//===================================================

	public function user_id_exists( $id = false, $employee_id = false )
	{
		$this->db->from('users');
		
		if( $employee_id != '' )
		{
			$this->db->select('*');
			$this->db->where('employee_id', $employee_id);
		}
		else
		{
			$this->db->select('id');
			$this->db->where('id', $id);
		}
		
		$query = $this ->db->get();
		if( $query->num_rows() > 0 )
		{
			if( $employee_id != '' )
			{
				$results = $query->result();
				return $results;
			}
			else
			{
				return TRUE;
			}
		}
		else
		{
			return FALSE;
		}
	}
	//============================================= 

	public function add_email_detail( $data = false )
	{
		$this->db->insert('temporary_email_send', $data);
		if ($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//===================================================

	public function find_all_email()
	{
		$this->db->select('*');
		$this->db->from('temporary_email_send');
		$this->db->where('email', '');
		
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$results = $query->result();
			return $results;
		}
		else
		{
			return false;
		}
	}
	//===================================================

	public function find( $id = false )
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id', $id);
		
		$query = $this->db->get();
		if( $query->num_rows() > 0 )
		{
			$results = $query->row();
			return $results; 
		}
		else
		{
			return false;
		}
	}
	//=============================================

	public function update( $data = false, $id = false )
	{
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		return true;
	}
	//=============================================

	public function update_assign_user( $data = false, $id = false )
	{
		$this->db->where('employee_id', $id);
		$this->db->update('users', $data);
		return true;
	}
	//=============================================

	public function delete( $id = false, $table_name = false )
	{
		$this->db->where('id', $id);
		
		if( $table_name != '' )
		{
			$this->db->delete($table_name);
		}
		else
		{
			$this->db->delete('users');
		}

		if( $this->db->affected_rows() > 0 )
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
	//=============================================
}