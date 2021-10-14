<?php
/**
*
*/

class Admin_model extends CI_Model
{
	public function __construct()
	{

	}

	function update_user_data($arr, $userid)
	{
		$this->db->where('id', $id);
		$this->db->update('users', $arr);
	}
}

?>