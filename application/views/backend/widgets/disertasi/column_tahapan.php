<?php
	$tugas_akhir = $this->disertasi->detail($disertasi['id_disertasi']);
	if (!empty($tugas_akhir)) {
		$status = '';
		if ($tugas_akhir->status_kualifikasi > 0) {
			$status = 'Ujian Kualifikasi';
		}
		if ($tugas_akhir->status_mpkk > 0) {
			$status = 'MKPKK';
		}
		if ($tugas_akhir->status_proposal > 0) {
			$status = 'Ujian Proposal';
		}
		if ($tugas_akhir->status_mkpd > 0) {
			$status = 'MKPD';
		}
		if ($tugas_akhir->status_kelayakan > 0) {
			$status = 'Ujian Kelayakan';
		}
		if ($tugas_akhir->status_tertutup > 0) {
			$status = 'Ujian Tertutup';
		}
		if ($tugas_akhir->status_terbuka > 0) {
			$status = 'Ujian Terbuka';
		}
		?>
		<button class="btn btn-xs btn-primary"><?= $status ?></button>
		<?php
	} else {
		?>
		<button class="btn btn-xs btn-danger">Kosong</button>
		<?php
	}
