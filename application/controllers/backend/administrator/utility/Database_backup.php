<?php

	defined('BASEPATH') or exit('No direct script access allowed');

	class Database_backup extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();

			//START SESS
			$this->session_data = $this->session->userdata('logged_in');

			if (!$this->session_data) {
				redirect('logout', 'refresh');
			} else {
				if ($this->session_data['sebagai'] != 2 and $this->session_data['role'] != 1) {
					redirect('logout', 'refresh');
				}
			}
			//END SESS
			//START MODEL
			$this->load->model('backend/user');
			$this->load->model('backend/administrator/master/departemen_model', 'departemen');
			$this->load->model('backend/master/prodi');
			$this->load->model('backend/utility/notification', 'notifikasi');
			//END MODEL
		}

		public function index()
		{
			$this->db->select('*');
			$this->db->from('database_backups');
			$this->db->order_by('time', 'desc');
			$query = $this->db->get();
			$backups = $query->result_array();
			$data = array(
				// PAGE //
				'title' => 'Database Backup',
				'subtitle' => 'Administrator',
				'section' => 'backend/administrator/utility/database_backup',
				// DATA //
				'user' => $this->user->read(),
				'backups'=>$backups,
			);
			$this->load->view('backend/index_sidebar', $data);
		}


		public function create_backup()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				try {
					// Load the DB utility class
					$this->load->dbutil();
					$filename = date('YmdHi');
					$filename_sql = 'layanan_fh_' . $filename;
					$prefs = array(
						'format' => 'zip',                       // gzip, zip, txt
						'filename' => $filename_sql . '.sql',              // File name - NEEDED ONLY WITH ZIP FILES
					);

					// Backup your entire database and assign it to a variable
					$backup = $this->dbutil->backup($prefs);

					// Load the file helper and write the file to your server
					$this->load->helper('file');
					write_file('./assets/backups/' . $filename . '.zip', $backup);

					// Check Database
					// Fetch Backup
					$this->db->select('*');
					$this->db->from('database_backups');
					$this->db->where('filename', $filename.'.zip');
					$query = $this->db->get();
					$backup = $query->row();
					if(empty($backup)){
						// Insert to database
						$data = array(
							'filename' => $filename . '.zip',
						);
						$this->db->insert('database_backups', $data);
					}


					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Database berhasil dibackup');
					redirect_back();
				} catch (Exception $e) {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', $e->getMessage());
					redirect_back();
				}

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

		public function delete_backup()
		{
			$hand = $this->input->post('hand', true);
			if ($hand == 'center19') {
				$id = $this->input->post('id', true);
				try {
					// Fetch Backup
					$this->db->select('*');
					$this->db->from('database_backups');
					$this->db->order_by('time', 'desc');
					$this->db->where('id_db_backup', $id);
					$query = $this->db->get();
					$backup = $query->row();
					// Delete File
					unlink('./assets/backups/'.$backup->filename);
					// Delete Data
					$this->db->where('id_db_backup', $id);
					$this->db->delete('database_backups');

					$this->session->set_flashdata('msg-title', 'alert-success');
					$this->session->set_flashdata('msg', 'Backup Database berhasil dihapus');
					redirect_back();
				} catch (Exception $e) {
					$this->session->set_flashdata('msg-title', 'alert-danger');
					$this->session->set_flashdata('msg', $e->getMessage());
					redirect_back();
				}

			} else {
				$this->session->set_flashdata('msg-title', 'alert-danger');
				$this->session->set_flashdata('msg', 'Terjadi Kesalahan');
				redirect_back();
			}
		}

	}

?>
