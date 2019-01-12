<?php
class Performance_score_model extends CI_Model
{
	public function find_score( $employee_id = false, $score_type = false, $is_manager = false )
	{
		$this->db->select('*');
		$this->db->from('performance_scores');
		$this->db->where('employee_id', $employee_id);

		if( $score_type){
			$this->db->where('score_type', $score_type);
		} else {
			$this->db->where('score_type', 1 );
		}

		$m = date('m', time());
		$d = date('d', time());
		$y = date('Y', time());

		$from_date 	= mktime(0,0,0, $m, $d, $y);
		$to_date 	= mktime(23,59,59, $m, $d, $y);

		if( !$is_manager ){
		
			$this->db->where('date <=', $to_date );
		}
		$this->db->order_by('date', 'DESC');
		$this->db->limit('12');

		$query = $this->db->get();

		// print_r($this->db->last_query());
		// die;
		
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

	public function find_all_assigned_number( $employee_id = false, $search = false, $score_type = false )
	{
		
		$this->db->distinct();
		$this->db->select('u.id');
		$this->db->from('users as u');
		$this->db->join('performance_scores as ps','u.employee_id = ps.employee_id');

		if( $search ) {
			$where = '`ps`.`score_type` = '.$score_type.' AND  (`u`.`first_name` LIKE "%'.$search.'%" ESCAPE "!" OR  `u`.`last_name` LIKE "%'.$search.'%" ESCAPE "!")';
			$this->db->where($where);
		} else {
			$this->db->where('ps.score_type', $score_type );
		}

		$where ='(u.assigned_qa= "'.$employee_id.'" OR u.assigned_supervisor= "'.$employee_id.'" OR u.assigned_manager = "'.$employee_id.'")';
		$this->db->where($where);
		// $this->db->where('u.assigned_qa', $employee_id );
		// $this->db->or_where('u.assigned_supervisor', $employee_id );

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

	public function find_all_assigned( $employee_id = false, $search = false, $limit = false, $start = false, $order_by = false, $order_by_name = false, $score_type = false )
	{
		
		$this->db->distinct();
		$this->db->select('u.*, ps.score_type' );
		$this->db->from('users as u');
		$this->db->join('performance_scores as ps', 'ps.employee_id = u.employee_id');

		if( $search ) {
			$where = '`ps`.`score_type` = '.$score_type.' AND  (`u`.`first_name` LIKE "%'.$search.'%" ESCAPE "!" OR  `u`.`last_name` LIKE "%'.$search.'%" ESCAPE "!")';
			$this->db->where($where);
		} else {
			$this->db->where('ps.score_type', $score_type );
		}


		$where ='(u.assigned_qa= "'.$employee_id.'" OR u.assigned_supervisor= "'.$employee_id.'" OR u.assigned_manager = "'.$employee_id.'")';
		$this->db->where($where);
		// $this->db->where('u.assigned_qa', $employee_id );
		// $this->db->or_where('u.assigned_supervisor', $employee_id );
		
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

	public function find_all_performance_score( $search = false, $limit = false, $start = false, $order_by = false, $order_by_name = false, $score_type = false )
	{
		$this->db->select('*' );
		$this->db->from('performance_scores');
		
		if( $search ) {
			$where = '`score_type` = '.$score_type.' AND  (`name` LIKE "%'.$search.'%" ESCAPE "!")';
			$this->db->where($where);
		} else {
			$this->db->where('score_type', $score_type );
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


	public function user_id_exists( $employee_id = false, $date = false, $score_type = false )
	{
		$this->db->select('*');
		$this->db->from('performance_scores');
		$this->db->where('employee_id', $employee_id);
		$this->db->where('date', $date );
		$this->db->where('score_type', $score_type );
		
		$query = $this->db->get();
		
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
	//===================================================

	public function add( $data = false )
	{
		$this->db->insert('performance_scores', $data);
		if ($this->db->affected_rows() > 0)
		{
			$insert_id = $this->db->insert_id();
			return  $insert_id;
		}
		else
		{
			return false;
		}
	}
	//===================================================

	public function update( $data = false, $employee_id = false, $score_type = false, $date = false )
	{
		$this->db->where('employee_id', $employee_id);
		$this->db->where('score_type', $score_type);
		$this->db->where('date', $date);
		$this->db->update('performance_scores', $data);
		return true;
	}
	//=============================================
	
	public function find_updated_id( $employee_id = false, $score_type = false, $date = false )
	{
		$this->db->select('id');
		$this->db->from('performance_scores');
		$this->db->where('employee_id', $employee_id);
		$this->db->where('score_type', $score_type);
		$this->db->where('date', $date);

		$query = $this->db->get();
		if( $query->num_rows() > 0 )
		{
			$results = $query->row('id');
			return $results;
		}
		else
		{
			return false;
		}
	}
	//=============================================

	public function delete( $id = false )
	{
		$this->db->where('id', $id);
		$this->db->delete('performance_scores');

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