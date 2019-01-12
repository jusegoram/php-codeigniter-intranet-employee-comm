<?php
class Settings_model extends CI_Model
{
	public function find_all()
	{
		$this->db->select('*');
		$this->db->from('settings');
		
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
		$this->db->insert('settings', $data);
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
		$this->db->from('settings');
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
		$this->db->update('settings', $data);
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
			$this->db->delete('settings');
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