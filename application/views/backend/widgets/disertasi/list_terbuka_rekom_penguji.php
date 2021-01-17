<table class="table table-condensed ">
	<tr class="bg-gray">
		<th>Nama</th>
		<th>Opsi</th>
	</tr>
	<?php
		$rekomendasi_dosens = $this->disertasi->read_rekomendasi_penguji_terbuka();
		foreach ($rekomendasi_dosens as $rekomendasi_dosen) {
			?>
			<tr>
				<td><?php echo $rekomendasi_dosen['nama'] ?><br/><b><?php echo $rekomendasi_dosen['nip'] ?></b></td>
				<td>
					<?php echo form_open('dosen/disertasi/terbuka/penguji_rekomendasi_save') ?>
					<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
					<?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
					<?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
					<?php echo formtext('hidden', 'nip', $rekomendasi_dosen['nip'], 'required') ?>
					<button type="submit" class="btn btn-xs btn-success"><i class="fa fa-add"></i> Tambahkan</button>
					<?php echo form_close() ?>
				</td>
			</tr>
			<?php
		}
	?>
</table>
