<?php

	if (!defined('BASEPATH')) {
		exit('No direct script access allowed');
	}

	class Penjadwalan extends CI_Model
	{

		public function cekBentrokJadwal($ruang, $tgl, $jam)
		{
			$status = true;
			$message = 'Sukses';
			$data_ruang = $this->getRuang($ruang);
			$data_jam = $this->getJam($jam);
			if ($data_ruang->ruang != 'ON') {
				$query_s1_str = "
					SELECT u.* FROM ujian u 
					JOIN jam j on j.id_jam=u.id_jam
					WHERE u.id_ruang = ? 
					AND u.tanggal = ?
					AND CAST( ? as time) BETWEEN CAST( j.mulai  AS time ) AND CAST( j.selesai  AS time )
					";
				$query_s1 = $this->db->query($query_s1_str, [
					$ruang,
					$tgl,
					$data_jam->selesai,
				]);
				$result_s1 = $query_s1->num_rows();

				$query_s2_str = "
					SELECT u.* FROM ujian_tesis u 
					JOIN jam j on j.id_jam=u.id_jam
					WHERE u.id_ruang = ? 
					AND u.tanggal = ?
					AND CAST( ? as time) BETWEEN CAST( j.mulai  AS time ) AND CAST( j.selesai  AS time )
					";
				$query_s2 = $this->db->query($query_s2_str, [
					$ruang,
					$tgl,
					$data_jam->selesai,
				]);
				$result_s2 = $query_s2->num_rows();

				$query_s3_str = "
					SELECT u.* FROM ujian_disertasi u 
					JOIN jam j on j.id_jam=u.id_jam
					WHERE u.id_ruang = ? 
					AND u.tanggal = ?
					AND CAST( ? as time) BETWEEN CAST( j.mulai  AS time ) AND CAST( j.selesai  AS time )
					AND u.status='1'";
				$query_s3 = $this->db->query($query_s3_str, [
					$ruang,
					$tgl,
					$data_jam->selesai,
				]);
				$result_s3 = $query_s3->num_rows();

				if ($result_s1 > 0 || $result_s2 > 0 || $result_s3 > 0) {
					$status = false;
					$message = 'Gagal. Sudah ada jadwal lain pada tanggal/ruang/jam yang sama';
				}
			}


			return [
				'status' => $status,
				'message' => $message
			];
		}

		public function cekBentrokPengujis($pengujis, $tgl, $jam)
		{
			$status = true;
			$message = '';
			$data_jam = $this->getJam($jam);
			foreach ($pengujis as $penguji) {
				$cek_penguji_bentrok = $this->cekBentrokPenguji($penguji['nip'], $tgl, $jam);
				if (!$cek_penguji_bentrok['status']) {
					$status = false;
					$message .= 'Penguji ' . $penguji['nama'] . ' memiliki jadwal pada '.tanggal_hari_format_indonesia($tgl).' dan jam '.$data_jam->jam.'<br/>';
				}
			}
			return [
				'status' => $status,
				'message' => $status ? 'Sukses' : 'Gagal. Terdapat penguji bentrok <br/>'.$message
			];
		}


		public function cekBentrokPenguji($nip, $tgl, $jam)
		{
			$status = true;
			$message = 'Sukses';
			$data_jam = $this->getJam($jam);
			$query_s1_str = "
					SELECT u.* FROM ujian u 
					JOIN penguji p on p.id_ujian=u.id_ujian
					JOIN jam j on j.id_jam=u.id_jam
					WHERE p.nip= ?  and p.status!='0'
					AND u.tanggal = ?
					AND CAST( ? as time) BETWEEN CAST( j.mulai  AS time ) AND CAST( j.selesai  AS time )
					";
			$query_s1 = $this->db->query($query_s1_str, [
				$nip,
				$tgl,
				$data_jam->selesai,
			]);
			$result_s1 = $query_s1->num_rows();

			$query_s2_str = "
					SELECT u.* FROM ujian_tesis u 
					JOIN penguji_tesis p on p.id_ujian=u.id_ujian
					JOIN jam j on j.id_jam=u.id_jam
					WHERE p.nip= ?  and p.status!='0'
					AND u.tanggal = ?
					AND CAST( ? as time) BETWEEN CAST( j.mulai  AS time ) AND CAST( j.selesai  AS time )
					";
			$query_s2 = $this->db->query($query_s2_str, [
				$nip,
				$tgl,
				$data_jam->selesai,
			]);
			$result_s2 = $query_s2->num_rows();

			$query_s3_str = "
					SELECT u.* FROM ujian_disertasi u 
					JOIN penguji_disertasi p on p.id_ujian=u.id_ujian
					JOIN jam j on j.id_jam=u.id_jam
					WHERE p.nip= ?  and p.status!='0'
					AND u.tanggal = ?
					AND CAST( ? as time) BETWEEN CAST( j.mulai  AS time ) AND CAST( j.selesai  AS time )
					AND u.status='1'";
			$query_s3 = $this->db->query($query_s3_str, [
				$nip,
				$tgl,
				$data_jam->selesai,
			]);
			$result_s3 = $query_s3->num_rows();

			if ($result_s1 > 0 || $result_s2 > 0 || $result_s3 > 0) {
				$status = false;
				$message = 'Penguji '.$nip.' memiliki jadwal lain pada tanggal/jam yang sama';
			}

			return [
				'status' => $status,
				'message' => $message
			];
		}

		public function getJam($id)
		{
			$this->db->select('*');
			$this->db->from('jam j');
			$this->db->where('j.id_jam', $id);
			$query = $this->db->get();
			return $query->row();
		}

		public function getRuang($id)
		{
			$this->db->select('*');
			$this->db->from('ruang');
			$this->db->where('id_ruang', $id);
			$query = $this->db->get();
			return $query->row();
		}


	}

?>
