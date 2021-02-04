<?php

	$session_data = $this->session->userdata('logged_in');
	$role = $session_data['role'];
	$sebagai = $session_data['sebagai'];
	$is_verifikasi = '';
	if ($sebagai == '3') {
		$is_verifikasi = $session_data['verifikasi'];
	}
	if ($sebagai) {
		if ($sebagai == '1') { // dosen
			redirect('dashboardd', 'refresh');
		} else if ($sebagai == '2') { // tendik
			if ($role == '1') { // Admin
				redirect('dashboarda', 'refresh');
			} else if ($role == '2') { // BAA
				redirect('dashboardb', 'refresh');
			}else if ($role == '3') { // BAA
				redirect('prodi/dashboard', 'refresh');
			}
		} else if ($sebagai == '3') { // mahasiswa
			if ($is_verifikasi == '1') {
				redirect('dashboardm', 'refresh');
			} else {
				redirect('auth/verifikasi', 'refresh');
			}
		}
	} else {
		$this->load->view('backend/incl/sess_dest');
	}
?>
