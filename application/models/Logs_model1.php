<?php
class Logs_model extends CI_Model
{
	public function find_all( $user_id = false )
	{
		$this->db->select('i.issue_name, l.* , u.employee_id as employee_id, u.first_name, u.last_name');
		$this->db->from('logs as l');
		$this->db->join('users as u','u.id = l.user_id');
		$this->db->join('issues as i','i.id = l.regarding_issue_id');
		
		if( $user_id )
		{
			$this->db->where('u.id', $user_id);
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

	public function find_all_logs( $id )
	{
		$this->db->select('l.*, i.issue_name, u.employee_id as employee_id, u.first_name, u.last_name');
		$this->db->from('logs as l');
		$this->db->join('users as u','u.id = l.user_id', 'left');
		$this->db->join('issues as i','i.id = l.regarding_issue_id', 'left');

		$this->db->where('regarding_issue_id', $id);
		
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

	public function add( $data )
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

	public function delete( $id, $table_name = '' )
	{
		$this->db->where('id', $id);
		
		if( $table_name != '' )
		{
			$this->db->delete($table_name);
		}
		else
		{
			$this->db->delete('logs');
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

	public function find( $id )
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

	public function logs_id_exists( $id )
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

	public function update( $data, $id )
	{
		$this->db->where('id', $id);
		$this->db->update('logs', $data);
		return true;
	}
	//=============================================

	public function delete( $id )
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