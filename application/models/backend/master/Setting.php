<?php

	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Setting extends CI_Model
	{

		function get_value($name)
		{
			$this->db->select('*');
			$this->db->from('setting');
			$this->db->where('name', $name);
			$query = $this->db->get();
			$result = $query->row();
			return $result->value;
		}


	}

?>
