<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	// Tes Perubahan
	class Api extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();

			//END SESS
			//START MODEL
			$this->load->model('backend/master/setting', 'setting');
			$this->load->model('backend/transaksi/skripsi', 'skripsi');
			$this->load->model('backend/transaksi/tesis', 'tesis');
			$this->load->model('backend/transaksi/disertasi', 'disertasi');
			//END MODEL
		}

		function responseDataOnly($data)
		{
			return $this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(
					json_encode(
						$data
					)
				);
		}

		function responseSuccess($data)
		{
			return $this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(
					json_encode(
						[
							'status' => '1',
							'message' => 'Success',
							'data' => $data,
						]
					)
				);
		}

		function responseError($message)
		{
			return $this->output
				->set_content_type('application/json')
				->set_status_header(500)
				->set_output(
					json_encode(
						[
							'status' => '0',
							'message' => $message,
						]
					)
				);
		}

		public function jadwal_get_data_kalender()
		{
			$results = [];
			try {
				$datas = $this->skripsi->read_jadwal_all();
				foreach ($datas as $data) {
					$tugas_akhir = $this->skripsi->detail_by_id($data['id_skripsi']);
					if (!empty($tugas_akhir)) {
						$results[] = [
							'id' => $data['id_ujian'],
							'type' => JENJANG_S1,
							'title' => $tugas_akhir->nim . ' - ' . ($data['jenis_ujian'] == 1 ? "Proposal Skripsi" : "Skripsi") . ' - ' . $data['ruang'],
							'start' => date('Y-m-d', strtotime($data['tanggal'])) . 'T' . preg_replace('/\s+/', '', $data['jam']),
							'backgroundColor' => '#fc0303'
						];
					}

				}
				$datas = $this->tesis->read_jadwal_all();
				foreach ($datas as $data) {
					$tugas_akhir = $this->tesis->detail($data['id_tesis']);
					if (!empty($tugas_akhir)) {
						$results[] = [
							'id' => $data['id_ujian'],
							'type' => JENJANG_S2,
							'title' => $tugas_akhir->nim . ' - ' . ($data['jenis_ujian'] == 1 ? "Proposal Tesis" : "Tesis") . ' - ' . $data['ruang'],
							'start' => date('Y-m-d', strtotime($data['tanggal'])) . 'T' . preg_replace('/\s+/', '', $data['jam']),
							'backgroundColor' => $tugas_akhir->id_prodi == S2_ILMU_HUKUM ? '#1191ed' : '#10408f'
						];
					}
				}
				$datas = $this->disertasi->read_jadwal_all();
				foreach ($datas as $data) {
					$tugas_akhir = $this->disertasi->detail($data['id_disertasi']);
					if (!empty($tugas_akhir)) {
						$jenis_ujian='';
						if($data['jenis_ujian']==UJIAN_DISERTASI_KUALIFIKASI){
							$jenis_ujian='Ujian Kualifikasi';
						}else if($data['jenis_ujian']==UJIAN_DISERTASI_PROPOSAL){
							$jenis_ujian='Ujian Proposal';
						}else if($data['jenis_ujian']==UJIAN_DISERTASI_KELAYAKAN){
							$jenis_ujian='Ujian Kelayakan';
						}else if($data['jenis_ujian']==UJIAN_DISERTASI_TERTUTUP){
							$jenis_ujian='Ujian Tertutup';
						}else if($data['jenis_ujian']==UJIAN_DISERTASI_TERBUKA){
							$jenis_ujian='Ujian Terbuka';
						}
						$results[] = [
							'id' => $data['id_ujian'],
							'type' => JENJANG_S3,
							'title' => $tugas_akhir->nim . ' - ' . $jenis_ujian . ' - ' . $data['ruang'],
							'start' => date('Y-m-d', strtotime($data['tanggal'])) . 'T' . preg_replace('/\s+/', '', $data['jam']),
							'backgroundColor' => '#f0a637'
						];
					}
				}
				return $this->responseDataOnly($results);
			} catch (Exception $e) {
				return $this->responseError($e->getMessage());
			}
		}

		public function jadwal_get_detail($id, $type)
		{
			$results = [];
			$html_penguji = '';
			try {
				if ($type == JENJANG_S1) {
					$ujian = $this->skripsi->read_ujian_by_id($id);
					$tugas_akhir = $this->skripsi->detail_by_id($ujian->id_skripsi);
					$judul = $this->skripsi->read_judul($tugas_akhir->id_skripsi);
					$pengujis = $this->skripsi->read_penguji($id);
					foreach ($pengujis as $penguji) {
						$html_penguji .= $penguji['nama'] . '<br/>';
					}
					$results = [
						'kegiatan' => 'Ujian ' . ($ujian->jenis_ujian == 1 ? 'Proposal Skripsi' : 'Skripsi'),
						'nama' => $tugas_akhir->nama,
						'nim' => $tugas_akhir->nim,
						'judul' => $judul->judul,
						'tanggal' => tanggal_hari_format_indonesia($ujian->tanggal),
						'waktu' => $ujian->jam,
						'ruang' => $ujian->ruang . ' ' . $ujian->gedung,
						'penguji' => $html_penguji,
					];
				} else if ($type == JENJANG_S2) {
					$ujian = $this->tesis->read_jadwal_by_id($id);
					$tugas_akhir = $this->tesis->detail($ujian->id_tesis);
					$judul = $this->tesis->read_judul($tugas_akhir->id_tesis, $tugas_akhir->jenis);
					$pengujis = $this->tesis->read_penguji($id);
					foreach ($pengujis as $penguji) {
						$html_penguji .= $penguji['nama'] . '<br/>';
					}
					$results = [
						'kegiatan' => 'Ujian ' . ($ujian->jenis_ujian == 1 ? 'Proposal Tesis' : 'Tesis'),
						'nama' => $tugas_akhir->nama,
						'nim' => $tugas_akhir->nim,
						'judul' => $judul->judul,
						'tanggal' => tanggal_hari_format_indonesia($ujian->tanggal),
						'waktu' => $ujian->jam,
						'ruang' => $ujian->ruang . ' ' . $ujian->gedung,
						'penguji' => $html_penguji,
					];
				} else if ($type == JENJANG_S3) {
					$ujian = $this->disertasi->detail_ujian($id);
					$tugas_akhir = $this->disertasi->detail($ujian->id_disertasi);
					$judul = $this->disertasi->read_judul($tugas_akhir->id_disertasi);
					$pengujis = $this->disertasi->read_penguji($id);
					foreach ($pengujis as $penguji) {
						$html_penguji .= $penguji['nama'] . '<br/>';
					}
					$jenis_ujian='';
					if($ujian->jenis_ujian ==UJIAN_DISERTASI_KUALIFIKASI){
						$jenis_ujian='Ujian Kualifikasi';
					}else if($ujian->jenis_ujian ==UJIAN_DISERTASI_PROPOSAL){
						$jenis_ujian='Ujian Proposal';
					}else if($ujian->jenis_ujian ==UJIAN_DISERTASI_KELAYAKAN){
						$jenis_ujian='Ujian Kelayakan';
					}else if($ujian->jenis_ujian ==UJIAN_DISERTASI_TERTUTUP){
						$jenis_ujian='Ujian Tertutup';
					}else if($ujian->jenis_ujian ==UJIAN_DISERTASI_TERBUKA){
						$jenis_ujian='Ujian Terbuka';
					}
					$results = [
						'kegiatan' =>  $jenis_ujian,
						'nama' => $tugas_akhir->nama,
						'nim' => $tugas_akhir->nim,
						'judul' => $judul->judul,
						'tanggal' => tanggal_hari_format_indonesia($ujian->tanggal),
						'waktu' => $ujian->jam,
						'ruang' => $ujian->ruang . ' ' . $ujian->gedung,
						'penguji' => $html_penguji,
					];
				}

				return $this->responseDataOnly($results);
			} catch (Exception $e) {
				return $this->responseError($e->getMessage());
			}
		}

	}

?>
