<?php
class Welcome_quotes_model extends CI_Model
{
	public function find_all( $select_id = false )
	{
		if( $select_id )
			$this->db->select('id');
		else
			$this->db->select('*');
		$this->db->from('welcome_quotes');
		
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
	
	public function find_all_pagination( $search = false, $limit = false, $start = false, $order_by = false, $order_by_name = false )
	{
		$this->db->select('*');
		$this->db->from('welcome_quotes');
		
		if( !empty($search) ){
			$this->db->like('welcome_quote', $search);
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

	public function add( $data = false )
	{
		$this->db->insert('welcome_quotes', $data);
		if( $this->db->affected_rows() > 0 )
		{
			return true;
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
		$this->db->from('welcome_quotes');
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

	public function quotes_id_exists( $id = false )
	{
		$this->db->select('id');
		$this->db->from('welcome_quotes');
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

	public function update( $data = false, $id = false )
	{
		$this->db->where('id', $id);
		$this->db->update('welcome_quotes', $data);
		return true;
	}
	//=============================================

	public function delete( $id = false )
	{
		$this->db->where('id', $id);
		$this->db->delete('welcome_quotes');

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

	public function get_current_welcome_qoute( $current_time = false )
	{
		$this->db->select('*');
		$this->db->from('welcome_quotes as wq');
		
		if( $current_time )
		{
			$this->db->where( 'wq.welcome_quote_date', $current_time );
		}
		else
		{
			$this->db->where( 'wq.welcome_quote_date <', strtotime(date('Y-m-d')) );
			$this->db->limit(1, 1);
		}

		$this->db->order_by('id', 'DESC');
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
	//===================================================

	public function get_welcome_note_by_assigned_user( $user_id = false )
	{
		$this->db->select('wq.title, wq.description');
		
		$this->db->from('user_welcome_quotes as uwq');
		
		$this->db->join('users as u','u.id = uwq.user_id');
		$this->db->join('welcome_quotes as wq','wq.id = uwq.welcome_qoute_id');
		
		$this->db->where('u.id', $user_id);

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
}