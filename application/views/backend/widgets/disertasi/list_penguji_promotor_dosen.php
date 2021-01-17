<?php echo form_open('dosen/disertasi/'.$this->uri->segment('3').'/penguji_promotor_save'); ?>
<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
<?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
<?php echo formtext('hidden', 'id_ujian', $id_ujian, 'required') ?>

<div class="form-group">
	<table class="table table-bordered">
		<tr class="bg-gray">
			<th>Nama</th>
		</tr>
		<?php
			foreach ($promotors as $index => $promotor) {
				?>
				<tr>
					<td><?= $index + 1 ?>. <?php echo $promotor['nama'] ?><br/><b><?php echo $promotor['nip'] ?></b></td>
				</tr>
				<?php
			}
		?>
	</table>
</div>
<div class="form-group">
	<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambahkan</button>
</div>
<?php echo form_close() ?>
