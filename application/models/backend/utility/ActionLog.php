<?php

	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class ActionLog extends CI_Model
	{
		public $config;

		public function __construct()
		{
			parent::__construct();;
		}

		public function getSkripsi($id_skripsi)
		{
			$this->db->select('s.*');
			$this->db->from('skripsi s');
			$this->db->where('s.id_skripsi', $id_skripsi);
			$query = $this->db->get();
			return $query->row();
		}

		function saveActionLogByIdSkripsi($id_skripsi, $actor, $verb, $object, $status)
		{
			$skripsi = $this->getSkripsi($id_skripsi);
			$subject=$skripsi->nim;
			$action=$status ? 'Persetujuan' : 'Tolak';
			$description = $action.' '.$verb.' '.$object.' '.$subject;
			$data = [
				'actor' => $actor,
				'subject' => $subject,
				'object' => $object,
				'verb' => $verb,
				'action' => $action,
				'description' => $description,
				'date' => date('Y-m-d'),
				'time' => date('Y-m-d H:i:s')
			];
			$this->db->insert('action_logs', $data);
		}

		public function read()
		{
			$this->db->select('*');
			$this->db->from('action_logs');
			$this->db->order_by('time', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}


	}
