<?php

	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class ActionLog extends CI_Model
	{
		public $config;

		public function __construct()
		{
			parent::__construct();
		}

		function getUserDevice()
		{
			$this->load->library('user_agent');
			if ($this->agent->is_browser()) {
				$agent = $this->agent->browser() . ' ' . $this->agent->version();
			} else if ($this->agent->is_robot()) {
				$agent = $this->agent->robot();
			} else if ($this->agent->is_mobile()) {
				$agent = $this->agent->mobile();
			} else {
				$agent = 'Unidentified User Agent';
			}

			return $this->agent->platform() . ' - ' . $agent;
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
			$subject = $skripsi->nim;
			$action = $status ? 'Persetujuan' : 'Tolak';
			$description = $action . ' ' . $verb . ' ' . $object . ' ' . $subject;
			$data = [
				'actor' => $actor,
				'subject' => $subject,
				'object' => $object,
				'verb' => $verb,
				'action' => $action,
				'description' => $description,
				'ip_address' => $this->input->ip_address(),
				'device' => $this->getUserDevice(),
				'date' => date('Y-m-d'),
				'time' => date('Y-m-d H:i:s')
			];
			$this->db->insert('action_logs', $data);
		}

		public function read()
		{
			$this->db->select('a.*,p.nama');
			$this->db->from('action_logs a');
			$this->db->join('pegawai p', 'p.nip = a.actor');
			$this->db->order_by('a.time', 'desc');

			$query = $this->db->get();
			return $query->result_array();
		}


	}
