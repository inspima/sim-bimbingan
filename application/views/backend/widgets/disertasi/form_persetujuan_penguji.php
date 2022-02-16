<?php
	if ($penguji->status == '1') {
		if ($jenis == UJIAN_DISERTASI_KUALIFIKASI) {
			if ($disertasi->status_kualifikasi >= STATUS_DISERTASI_KUALIFIKASI_SETUJUI_KPS) {
				?>
				<?php echo form_open('dosen/disertasi/permintaan/penguji/setujui') ?>
				<?php echo formtext('hidden', 'id_penguji', $penguji->id_penguji, 'required') ?>
				<?php echo formtext('hidden', 'id_disertasi', $id_disertasi, 'required') ?>
				<?php echo formtext('hidden', 'id_ujian', $jadwal->id_ujian, 'required') ?>
				<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
				<button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses Setujui</button><br/>
				<?php echo form_close() ?>
				<?php
			}
		} else {
			?>
			<?php echo form_open('dosen/disertasi/permintaan/penguji/setujui') ?>
			<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
			<?php echo formtext('hidden', 'id_penguji', $penguji->id_penguji, 'required') ?>
			<?php echo formtext('hidden', 'id_disertasi', $id_disertasi, 'required') ?>
			<?php echo formtext('hidden', 'id_ujian', $jadwal->id_ujian, 'required') ?>
			<button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses Setujui</button><br/>
			<?php echo form_close() ?>
			<?php
		}

	}
