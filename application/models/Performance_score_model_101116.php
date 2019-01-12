<?php
class Performance_score_model extends CI_Model
{
	public function find_score( $employee_id, $score_type )
	{
		$this->db->select('*');
		$this->db->from('performance_scores');
		$this->db->where('employee_id', $employee_id);

		if( $score_type){
			$this->db->where('score_type', $score_type);
		} else {
			$this->db->where('score_type', 1 );
		}

		$this->db->order_by('date', 'DESC');
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

	public function find_all_assigned_number( $employee_id, $search, $score_type )
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


		$this->db->where('u.assigned_qa', $employee_id );
		$this->db->or_where('u.assigned_supervisor', $employee_id );

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

	public function find_all_assigned( $employee_id, $search, $limit, $start, $order_by, $order_by_name, $score_type )
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


		$this->db->where('u.assigned_qa', $employee_id );
		$this->db->or_where('u.assigned_supervisor', $employee_id );
		
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

	public function user_id_exists( $employee_id, $date, $score_type )
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

	public function add( $data )
	{
		$this->db->insert('performance_scores', $data);
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

	public function update( $data, $employee_id, $score_type, $date )
	{
		$this->db->where('employee_id', $employee_id);
		$this->db->where('score_type', $score_type);
		$this->db->where('date', $date);
		$this->db->update('performance_scores', $data);
		return true;
	}
	//=============================================
}