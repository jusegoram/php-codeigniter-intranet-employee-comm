<?php
class Performance_model extends CI_Model
{
	public function find_all( $user_id = false, $user_type = false, $search = false )
	{
		if( $search )
			$this->db->select('p.id');
		else
			$this->db->select('p.*, u.id as user_id, u.first_name, u.last_name');
		$this->db->from('performances as p');
		$this->db->join('users as u','u.id = p.user_id');

		if( $search ) {
			
			$where = '(`u`.`first_name` LIKE "%'.$search.'%" ESCAPE "!" OR  `u`.`last_name` LIKE "%'.$search.'%" ESCAPE "!")';
			$this->db->where($where);
		}

		if( !$user_type)
		{
			if( $user_id )
			{
				$this->db->where('u.id', $user_id);
			}
		} else {
			$this->db->where_in('u.id', $user_id);
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

	public function find_all_pagination( $user_id = false, $user_type = false, $search = false, $limit = false, $start = false, $order_by = false, $order_by_name = false )
	{
		$this->db->select('p.*, u.id as user_id, u.first_name, u.last_name');
		$this->db->from('performances as p');
		$this->db->join('users as u','u.id = p.user_id');

		if( !empty($search) ){
			
			$where = '(`u`.`first_name` LIKE "%'.$search.'%" ESCAPE "!" OR  `u`.`last_name` LIKE "%'.$search.'%" ESCAPE "!")';
			$this->db->where($where);
		}

		if( !$user_type)
		{
			if( $user_id )
			{
				$this->db->where('u.id', $user_id);
			}
		} else {
			$this->db->where_in('u.id', $user_id);
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


	public function find_score( $user_id = false, $user_type = false  )
	{
		$this->db->select('*');
		$this->db->from('performances');
		$this->db->where('score !=', 0);
		
		if( !$user_type){
			if( $user_id )
			{
				$this->db->where('user_id', $user_id);
			}
		} else {
			$this->db->where_in('user_id', $user_id);
		}


		$this->db->order_by('id', 'DESC');
		$this->db->limit('12');

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

	public function get_latest_time( $user_id = false )
	{
		// $this->db->select_max('created_date');
		// $this->db->from('performances');
		
		$this->db->select('performance_date');
		$this->db->from('performances');

		$m = date('m', time());
		$d = date('d', time());
		$y = date('Y', time());

		$from_date 	= mktime(0,0,0, $m, $d, $y);
		$to_date 	= mktime(23,59,59, $m, $d, $y);

		// $where_date = 'performance_date >= ' . $from_date. ' AND performance_date <=' . $to_date ;

		$this->db->where('user_id', $user_id);
		$this->db->where('performance_date <=', $to_date);
		$this->db->where('is_accepted', 0);
		$this->db->order_by('performance_date', 'desc');
		$this->db->limit(1);

		$query = $this->db->get();
		// print_r($this->db->last_query());
		// die;

		if( $query->num_rows() > 0 )
		{
			$results = $query->row('performance_date');
			return $results;
		}
		else
		{
			return false;
		}
	}
	//===================================================

	public function get_current_score( $performance_date = false, $user_id = false )
	{
		$this->db->select('score, id');
		$this->db->from('performances');
		$this->db->where('performance_date', $performance_date);
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get();

		// print_r($this->db->last_query());
		// die;
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
	//===================================================

	public function performance_id_exists( $id = false )
	{
		$this->db->select('id');
		$this->db->from('performances');
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

	public function find_assigned_employee( $id = false, $employee_id = false, $column_name = false )
	{
		$this->db->select('*');
		$this->db->from('performances as p');
		$this->db->join('users as u','u.id = p.user_id');
		$this->db->where('id', $id);
		$this->db->where($column_name, $employee_id);
		
		$query = $this ->db->get();
		print_r( $this ->db->last_query() );
		die;

		if( $query->num_rows() > 0 )
		{
			$results = $query->row();
			return $results;
		}
		else
		{
			return FALSE;
		}
	}
	//=============================================

	public function add( $data = false )
	{
		$this->db->insert('performances', $data);

		if( $this->db->affected_rows() > 0 )
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}
	}
	//===================================================

	public function add_score( $data = false, $id = false )
	{
		// print('<pre>');
		// print_r($data);
		// die;
		$this->db->where('id', $id);
		$this->db->update('performances', $data);
		return true;
	}
	//=============================================
	
	public function find( $id = false )
	{
		$this->db->select('p.*, u.id as user_id, u.first_name, u.last_name');
		$this->db->from('performances as p');
		$this->db->join('users as u','u.id = p.user_id');
		
		$this->db->where('p.id', $id);
		
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
		$this->db->update('performances', $data);
		return true;
	}
	//=============================================

	public function delete( $id = false )
	{
		$this->db->where('id', $id);
		$this->db->delete('performances');

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