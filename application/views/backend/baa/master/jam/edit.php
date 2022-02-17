<div class="row">
	<!-- left column -->
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $subtitle ?></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<?php echo form_open('baa/master/jam/update'); ?>
			<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
			<?php echo formtext('hidden', 'id_jam', $jam->id_jam, 'required') ?>

			<div class="box-body">
				<div class="form-group">
					<label>Nama Jam</label>
					<?php echo formtext('text', 'jam', $jam->jam, 'required') ?>
				</div>
				<div class="form-group">
					<label>Digunakan untuk</label>
					<?php
						foreach ($jam_prodis as $jam_prodi) {
							?>
							<div class="checkbox">
								<label>
									<input type="checkbox" <?= !empty($jam_prodi['id_jam_prodi']) ? 'checked' : '' ?> name="prodis[]" value="<?= $jam_prodi['id_prodi'] ?>">
									<?= $jam_prodi['jenjang'] ?> - <?= $jam_prodi['nm_prodi'] ?>
								</label>
							</div>
							<?php
						}
					?>

				</div>
			</div>

			<div class="box-body">
				<div class="form-group">
					<label>Mulai</label>
					<div class="input-group">
						<input type="text" name="mulai" value="<?=$jam->mulai?>" class="form-control timepicker" autocomplete="false" required readonly>
						<div class="input-group-addon">
							<i class="fa fa-clock-o"></i>
						</div>
					</div>
				</div>
			</div>
			<div class="box-body">
				<div class="form-group">
					<label>Selesai</label>
					<div class="input-group">
						<input type="text" name="selesai" value="<?=$jam->selesai?>" class="form-control timepicker" autocomplete="false" required readonly>
						<div class="input-group-addon">
							<i class="fa fa-clock-o"></i>
						</div>
					</div>
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
				<a class="btn btn-sm btn-warning" href="<?= base_url() ?>baa/master/jam"><i class="fa fa-close"></i> Batal</a>
			</div>
			<?= form_close() ?>
		</div>
		<!-- /.box -->
	</div>
</div>
