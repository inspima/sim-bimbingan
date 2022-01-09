<?php
	if ($jenis == TAHAPAN_SKRIPSI_PROPOSAL): // PROPOSAL
		$status = $this->transaksi_skripsi->get_status_tahapan($skripsi->status_proposal, TAHAPAN_SKRIPSI_PROPOSAL);
		?>
		<span class="btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
	<?php
	elseif ($jenis == TAHAPAN_SKRIPSI_UJIAN) :// UJIAN SKRIPSI
		$status = $this->transaksi_skripsi->get_status_tahapan($skripsi->status_skripsi, TAHAPAN_SKRIPSI_UJIAN);
		?>
		<span class="btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
	<?php


	endif;
