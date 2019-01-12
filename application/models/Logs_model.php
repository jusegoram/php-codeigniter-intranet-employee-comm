<?php
class Logs_model extends CI_Model
{
	public function find_all( $user_id = false, $search = false )
	{
		if( $search )
			$this->db->select('l.id');
		else
			$this->db->select('i.issue_name, l.* , u.employee_id as employee_id, u.first_name, u.last_name');
		$this->db->from('logs as l');
		$this->db->join('users as u','u.id = l.user_id');
		$this->db->join('issues as i','i.id = l.regarding_issue_id');
		
		if( $user_id )
		{
			$this->db->where_in('u.id', $user_id);
		}

		if( $search ) {

			$where = '(`u`.`first_name` LIKE "%'.$search.'%" ESCAPE "!" OR  `u`.`last_name` LIKE "%'.$search.'%" ESCAPE "!")';
			$this->db->where($where);
		}

		$query = $this->db->get();
		if( $query->num_rows() > 0 )
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

	public function find_all_pagination( $user_id = false, $search = false, $limit = false, $start = false, $order_by = false, $order_by_name = false )
	{
		$this->db->select('i.issue_name, l.* , u.employee_id as employee_id, u.first_name, u.last_name');
		$this->db->from('logs as l');
		$this->db->join('users as u','u.id = l.user_id');
		$this->db->join('issues as i','i.id = l.regarding_issue_id');
		
		if( $user_id )
		{
			$this->db->where_in('u.id', $user_id);
		}

		if( !empty($search) ){
			$where = '(`u`.`first_name` LIKE "%'.$search.'%" ESCAPE "!" OR  `u`.`last_name` LIKE "%'.$search.'%" ESCAPE "!")';
			$this->db->where($where);
		}
		
		$this->db->order_by($order_by_name, $order_by);
		$this->db->limit($limit, $start);
		
		$query = $this->db->get();
		if( $query->num_rows() > 0 )
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

	public function find_all_logs( $id = false, $start_date = false, $end_date = false )
	{
		$this->db->select('l.*, i.issue_name, u.employee_id as employee_id, u.first_name, u.last_name');
		$this->db->from('logs as l');
		$this->db->join('users as u','u.id = l.user_id', 'left');
		$this->db->join('issues as i','i.id = l.regarding_issue_id', 'left');

		$this->db->where( 'l.regarding_issue_id', $id );

		$m = date('m', $end_date);
		$d = date('d', $end_date);
		$y = date('Y', $end_date);

		$from_date 	= mktime(0,0,0, $m, $d, $y);
		$to_date 	= mktime(23,59,59, $m, $d, $y);

		$where = 'l.created_date >='. $start_date . ' AND l.created_date <=' . $to_date;
		$this->db->where($where);
		
		$query = $this->db->get();

		if( $query->num_rows() > 0 )
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

	public function find_all_logs_header( $id = false, $start_date = false, $end_date = false )
	{
		// $this->db->select('DISTINCT(l.field_name), i.issue_name, u.employee_id as employee_id, u.first_name, u.last_name');
		$this->db->distinct();
		$this->db->select('l.field_name');
		$this->db->from('logs as l');
		$this->db->join('users as u','u.id = l.user_id', 'left');
		$this->db->join('issues as i','i.id = l.regarding_issue_id', 'left');
		$this->db->where( 'l.regarding_issue_id', $id );
		
		$m = date('m', $end_date);
		$d = date('d', $end_date);
		$y = date('Y', $end_date);

		$from_date 	= mktime(0,0,0, $m, $d, $y);
		$to_date 	= mktime(23,59,59, $m, $d, $y);

		$where = 'l.created_date >='. $start_date . ' AND l.created_date <=' . $to_date;
		$this->db->where($where);

		$query = $this->db->get();
		
		if( $query->num_rows() > 0 )
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

	public function add( $data = false )
	{
		$this->db->insert('logs', $data);

		if ($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}
	}
	//===================================================

	public function find( $id = false )
	{
		$this->db->select('user_logs');
		$this->db->from('logs');
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

	public function logs_id_exists( $id = false )
	{
		$this->db->select('id');
		$this->db->from('logs');
		$this->db->where('id', $id);
		
		$query = $this ->db->get();
		if( $query->num_rows() > 0 )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	//=============================================

	public function find_logs_field_name()
	{
		$this->db->select('*');
		$this->db->from('logs_field_name');
		
		$query = $this->db->get();
		
		if( $query->num_rows() > 0 )
		{
			$results = $query->result();
			return $results;
		}
		else
		{
			return false;
		}
	}
	//=============================================

	public function add_logs_field_name( $id = false, $data = false )
	{
		$this->db->where('id', $id);	
		$this->db->update('logs_field_name', $data);
		return true;
	}
	//=============================================

	public function update( $data = false, $id = false )
	{
		$this->db->where('id', $id);
		$this->db->update('logs', $data);
		return true;
	}
	//=============================================

	public function delete( $id = false )
	{
		$this->db->where('id', $id);
		$this->db->delete('logs');

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