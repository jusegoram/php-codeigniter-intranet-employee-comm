<?php
class Issues_model extends CI_Model
{
	public function find_all( $is_enabled  = false, $search = false )
	{
		if( $search )
			$this->db->select('id');
		else
			$this->db->select('*');
		$this->db->from('issues');

		if( $is_enabled != '' )
		{
			$this->db->where('is_enabled', $is_enabled);
		}
		
		if( $search )
			$this->db->like('issue_name', $search);

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

	public function find_all_pagination( $is_enabled = false, $search = false, $limit = false, $start = false, $order_by = false, $order_by_name = false )
	{
		$this->db->select('*');
		$this->db->from('issues');

		if( $is_enabled != '' )
		{
			$this->db->where('is_enabled', $is_enabled);
		}

		if( !empty($search) ){
			$this->db->like('issue_name', $search);
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
		$this->db->insert('issues', $data);
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

	public function find($id = false)
	{
		$this->db->select('*');
		$this->db->from('issues');
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

	public function issue_id_exists( $id = false )
	{
		$this->db->select('id');
		$this->db->from('issues');
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

	public function modified( $data = false, $id = false)
	{
		$this->db->where('id', $id);
		$this->db->update('issues', $data);
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

	public function update( $data = false, $id = false )
	{
		$this->db->where('id', $id);
		$this->db->update('issues', $data);
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
			$this->db->delete('issues');
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