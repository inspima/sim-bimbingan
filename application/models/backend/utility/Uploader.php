<?php

	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Uploader extends CI_Model
	{
		public $config;

		public function __construct()
		{
			parent::__construct();
			// LIBRARY
			$this->config['upload_path'] = './assets/upload';
			$this->config['allowed_types'] = 'pdf';
			$this->config['max_size'] = MAX_SIZE_FILE_UPLOAD;
			$this->config['remove_spaces'] = true;
			$this->config['file_ext_tolower'] = true;
			$this->config['detect_mime'] = true;
			$this->config['mod_mime_fix'] = true;
			$this->config['overwrite'] = true;
			$this->config['file_name'] = 'file.pdf';
			$this->load->library('upload', $this->config);
		}

		public function changeConfig($key, $value)
		{
			$this->config[$key] = $value;
		}

		public function doUpload($file_upload)
		{
			$this->upload->initialize($this->config);
			if ($this->upload->do_upload($file_upload)) {
				return [
					'status' => 1,
					'message' => 'Success'
				];
			} else {
				return [
					'status' => 0,
					'message' => 'Failed to upload ' . $file_upload . ' ' . $this->upload->display_errors(),
				];
			}
		}

	}
