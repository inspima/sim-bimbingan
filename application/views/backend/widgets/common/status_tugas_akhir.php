<?php
	// S1
	if ($mahasiswa['id_jenjang'] == JENJANG_S1) {
		$tugas_akhir = $this->tugas_akhir->detail_skripsi($mahasiswa['nim']);
		if (!empty($tugas_akhir)):
			$jenis = $tugas_akhir->jenis;
			if ($jenis == TAHAPAN_SKRIPSI_PROPOSAL): // PROPOSAL
				$status = $this->skripsi->get_status_tahapan($tugas_akhir->status_proposal, TAHAPAN_SKRIPSI_PROPOSAL);
				?>
				<span class="btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
			<?php
			elseif ($jenis == TAHAPAN_SKRIPSI_UJIAN) :// UJIAN
				$status = $this->skripsi->get_status_tahapan($tugas_akhir->status_skripsi, TAHAPAN_SKRIPSI_UJIAN);
				?>
				<span class="btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
			<?php
			endif;
		else:
			?>
			<span class="btn btn-xs btn-danger">Kosong</span>
		<?php
		endif;
	} else if ($mahasiswa['id_jenjang'] == JENJANG_S2) {
		$tugas_akhir = $this->tugas_akhir->detail_tesis($mahasiswa['nim']);
		if (!empty($tugas_akhir)):
			$jenis = $tugas_akhir->jenis;
			if ($jenis == TAHAPAN_TESIS_JUDUL): // JUDUL
				$status = $this->tesis->get_status_tahapan($tugas_akhir->status_judul, TAHAPAN_TESIS_JUDUL);
				?>
				<span class="btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
			<?php
			elseif ($jenis == TAHAPAN_TESIS_PROPOSAL) :// PROPOSAL
				$status = $this->tesis->get_status_tahapan($tugas_akhir->status_proposal, TAHAPAN_TESIS_PROPOSAL);
				?>
				<span class="btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
			<?php
			elseif ($jenis == TAHAPAN_TESIS_MKPT) :// MKPT
				$status = $this->tesis->get_status_tahapan($tugas_akhir->status_mkpt, TAHAPAN_TESIS_MKPT);
				?>
				<span class="btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
			<?php
			elseif ($jenis == TAHAPAN_TESIS_UJIAN) :// UJIAN
				$status = $this->tesis->get_status_tahapan($tugas_akhir->status_tesis, TAHAPAN_TESIS_UJIAN);
				?>
				<span class="btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
			<?php
			endif;
		else:
			?>
			<span class="btn btn-xs btn-danger">Kosong</span>
		<?php
		endif;
	} else if ($mahasiswa['id_jenjang'] == JENJANG_S3) {
		$tugas_akhir = $this->tugas_akhir->detail_disertasi($mahasiswa['nim']);
		if (!empty($tugas_akhir)):
			$jenis = $tugas_akhir->jenis;
			if ($jenis == TAHAPAN_DISERTASI_KUALIFIKASI&&$tugas_akhir->status_promotor<1): // KUALIFIKASI
				$status = $this->disertasi->get_status_tahapan($tugas_akhir->status_kualifikasi, TAHAPAN_DISERTASI_KUALIFIKASI);
				?>
				<span class="btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
			<?php
			elseif ($jenis == TAHAPAN_DISERTASI_KUALIFIKASI&&$tugas_akhir->status_promotor>0) :// PROMTOR
				$status = $this->disertasi->get_status_tahapan($tugas_akhir->status_promotor, TAHAPAN_DISERTASI_PROMOTOR);
				?>
				<span class="btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
			<?php
			elseif ($jenis == TAHAPAN_DISERTASI_MPKK) :// MPKK
				$status = $this->disertasi->get_status_tahapan($tugas_akhir->status_mpkk, TAHAPAN_DISERTASI_MPKK);
				?>
				<span class="btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
			<?php
			elseif ($jenis == TAHAPAN_DISERTASI_PROPOSAL) :// PROPOSAL
				$status = $this->disertasi->get_status_tahapan($tugas_akhir->status_proposal, TAHAPAN_DISERTASI_PROPOSAL);
				?>
				<span class="btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
			<?php
			elseif ($jenis == TAHAPAN_DISERTASI_MKPD) :// MKPD
				$status = $this->disertasi->get_status_tahapan($tugas_akhir->status_mkpd, TAHAPAN_DISERTASI_MKPD);
				?>
				<span class="btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
			<?php
			elseif ($jenis == TAHAPAN_DISERTASI_KELAYAKAN) :// KELAYAKAN
				$status = $this->disertasi->get_status_tahapan($tugas_akhir->status_kelayakan, TAHAPAN_DISERTASI_KELAYAKAN);
				?>
				<span class="btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
			<?php
			elseif ($jenis == TAHAPAN_DISERTASI_TERTUTUP) :// UJIAN TERTUTUP

				$status = $this->disertasi->get_status_tahapan($tugas_akhir->status_tertutup, TAHAPAN_DISERTASI_TERTUTUP);
				?>
				<span class="btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
			<?php
			elseif ($jenis == TAHAPAN_DISERTASI_TERBUKA) :// UJIAN TERBUKA

				$status = $this->disertasi->get_status_tahapan($tugas_akhir->status_terbuka, TAHAPAN_DISERTASI_TERBUKA);
				?>
				<span class="btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
			<?php
			endif;
		else:
			?>
			<span class="btn btn-xs btn-danger">Kosong</span>
		<?php
		endif;
	}

