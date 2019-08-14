<?php
class Notification_model extends CI_Model
{
	public function find_all( $user_id = false, $user_type = false, $search = false, $is_global = false, $is_assigned_employee = false, $is_both = false, $uid = false )
	{
		if( $search )
			$this->db->select('n.id');
		else
			$this->db->select('n.*, u.id as user_id, u.first_name, u.last_name, , s.id as submitted_by, s.first_name as submit_first_name, s.last_name as submit_last_name');
		$this->db->from('notifications as n');
		$this->db->join('users as u','u.id = n.user_id');
		$this->db->join('users as s','s.id = n.submitted_by');

		if( $search ) {

			$where = '(`u`.`first_name` LIKE "%'.$search.'%" ESCAPE "!" OR  `u`.`last_name` LIKE "%'.$search.'%" ESCAPE "!")';
			$this->db->where($where);
		}

		if( !$user_type){

			if( $user_id )
			{
				$this->db->where('u.id', $user_id);
			} elseif($is_assigned_employee) {

				$where = '(u.id IN('.implode(',', $is_assigned_employee ).') OR u.user_type = 2 )';
				$this->db->where($where);
			}
		} else {
			$where = '(u.id IN('.implode(',', $user_id).')';
			$this->db->where($where);
		}

		if( $is_global ){

			// $this->db->where('n.is_global', $is_global);
			if( $is_both ){
				$find_both = '(n.is_global = 1 OR n.is_global = 2 )';
				$this->db->where($find_both);
			} else {

				$this->db->where('n.is_global', $is_global);
			}
		} else {

			$this->db->where('n.notification_date <=', strtotime(date('Y-m-d')));
		}

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

	public function find_all_pagination( $user_id = false, $user_type = false, $search = false, $limit = false, $start = false, $order_by = false, $order_by_name = false, $is_global = false, $is_assigned_employee = false, $is_both = false )
	{
		$this->db->select('n.*, u.id as user_id, u.first_name, u.last_name, s.id as submitted_by, s.first_name as submit_first_name, s.last_name as submit_last_name');
		$this->db->from('notifications as n');
		$this->db->join('users as u','u.id = n.user_id');
		$this->db->join('users as s','s.id = n.submitted_by');

		if( !empty($search) ){

			$where = '(`u`.`first_name` LIKE "%'.$search.'%" ESCAPE "!" OR  `u`.`last_name` LIKE "%'.$search.'%" ESCAPE "!")';
			$this->db->where($where);
		}

		if( !$user_type){
			if( $user_id )
			{
				$this->db->where('u.id', $user_id);
			} elseif($is_assigned_employee) {

				$where = '(u.id IN('.implode(',', $is_assigned_employee ).') OR u.user_type = 2 )';
				$this->db->where($where);
			}
		} else {
			$this->db->where_in('u.id', $user_id);
		}

		if( $is_global ){
			if( $is_both ){
				$find_both = '(n.is_global = 1 OR n.is_global = 2 )';
				$this->db->where($find_both);
			} else {

				$this->db->where('n.is_global', $is_global);
			}
		} else {

			$this->db->where('n.notification_date <=', strtotime(date('Y-m-d')));
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

	public function get_notification_by_assigned_user( $user_id = false, $notification_type = false, $current_date =false )
	{
		$this->db->select('n.*, u.id as user_id, u.first_name, u.last_name, s.id as submitted_by, s.first_name as submit_first_name, s.last_name as submit_last_name');
		$this->db->from('notifications as n');
		$this->db->join('users as u','u.id = n.user_id');
		$this->db->join('users as s','s.id = n.submitted_by');
		$this->db->where('u.id', $user_id);

		if( $notification_type )
		{
			$this->db->where('n.notification_type', $notification_type);
			$this->db->where('n.is_accepted', 0);
		}

		$m = date('m', $current_date);
		$d = date('d', $current_date);
		$y = date('Y', $current_date);

		$from_date 	= mktime(0,0,0, $m, $d, $y);
		$to_date 	= mktime(23,59,59, $m, $d, $y);

		$where_date = 'n.notification_date >= ' . $from_date. ' AND n.notification_date <=' . $to_date ;
		$this->db->where( $where_date );
		$this->db->where('u.id', $user_id);
		$this->db->order_by('n.created_date', 'desc');

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
		$this->db->insert('notifications', $data);

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

	public function notification_id_exists( $id = false )
	{
		$this->db->select('id');
		$this->db->from('notifications');
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

	public function find( $id = false, $is_accepted = false )
	{
		$this->db->select('n.*, u.id as user_id, u.first_name, u.last_name, s.id as submitted_by, s.first_name as submit_first_name, s.last_name as submit_last_name, u.user_type');
		$this->db->from('notifications as n');
		$this->db->join('users as u','u.id = n.user_id');
		$this->db->join('users as s','s.id = n.submitted_by');

		$this->db->where('n.id', $id);
		$this->db->where('n.is_global', 1);

		if( $is_accepted ){
			$this->db->where('n.is_accepted', 0);
		}

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
		$this->db->update('notifications', $data);
		return true;
	}
	//=============================================

	public function delete( $id = false )
	{
		$this->db->where('id', $id);
		$this->db->delete('notifications');

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
	public function find_notifications_export( $start_date = false, $end_date = false )
	{
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		$m = date('m', $end_date);
		$d = date('d', $end_date);
		$y = date('Y', $end_date);

		$from_date 	= mktime(0,0,0, $m, $d, $y);
		$to_date 	= mktime(23,59,59, $m, $d, $y);

		$query = 'SELECT t1.employee_id, t1.agent_first_name, t1.agent_last_name, t1.document_name, t1.notification_date, t1.is_accepted, t1.is_global, t1.submitted_by, t2.first_name, t2.last_name
		FROM (	SELECT u.employee_id, u.first_name as agent_first_name, u.last_name as agent_last_name, u.assigned_supervisor, u.assigned_manager, n.document_name, n.notification_date, n.submitted_by, n.is_accepted, n.is_global
				FROM notifications as n
				INNER JOIN users as u
				ON n.user_id = u.id) AS t1
		INNER JOIN users  AS t2
		ON t1.submitted_by = t2.id WHERE t1.notification_date >='. $start_date .' AND t1.notification_date <=' . $to_date .'';
		$result = $this->db->query($query);
			$delimiter = ",";
			$newline = "\r\n";
			$filename = "Notification_Export.csv";
			$out = $this->dbutil->csv_from_result($result, $delimiter, $newline);
			force_download($filename, $out);
	}
}