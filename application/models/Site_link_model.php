<?php
class Site_link_model extends CI_Model
{
	public function find_all( $select_id = false )
	{
		if( $select_id )
			$this->db->select('id');
		else
			$this->db->select('*');
		$this->db->from('site_links');
		
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
		$this->db->from('site_links');
		
		if( !empty($search) ){
			$this->db->like('title', $search);
		}

		$this->db->order_by($order_by_name, $order_by);
		
		 if($limit != false){
			$this->db->limit($limit, $start);
		}
		// $this->db->limit($limit, $start);	

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
		$this->db->insert('site_links', $data);
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
		$this->db->from('site_links');
		$this->db->where('id', $id);
		
		$query = $this->db->get();
		if($query->num_rows() > 0)
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

	public function link_id_exists( $id = false )
	{
		$this->db->select('id');
		$this->db->from('site_links');
		$this->db->where('id', $id);
		
		$query = $this ->db->get();
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	//=============================================

	public function site_url_exists( $site_url = false, $id = false )
	{
		$this->db->from('site_links');
		
		if( !empty($id) ) {

			$this->db->select('id');
			$this->db->where('url', $site_url);
			$this->db->where('id !=', $id);
		} else {

			$this->db->select('id');
			$this->db->where('url', $site_url);
		}

		$query = $this ->db->get();

		if( $query->num_rows() > 0 )
		{
			$results = $query->result();
			return $results;
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
		$this->db->update('site_links', $data);
		return true;
	}
	//=============================================

	public function delete( $id = false )
	{
		$this->db->where('id', $id);
		$this->db->delete('site_links');

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