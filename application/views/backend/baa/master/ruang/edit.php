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
			<?php echo form_open('baa/master/ruang/update'); ?>
			<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
			<?php echo formtext('hidden', 'id_ruang', $ruang->id_ruang, 'required') ?>

			<div class="box-body">
				<div class="form-group">
					<label>Gedung</label>
					<?php echo formtext('text', 'gedung', $ruang->gedung, 'required') ?>
				</div>
				<div class="form-group">
					<label>Ruang</label>
					<?php echo formtext('text', 'ruang', $ruang->ruang, 'required') ?>
				</div>
				<div class="form-group">
					<label>Digunakan untuk</label>
					<?php
						foreach ($ruang_prodis as $ruang_prodi) {
							?>
							<div class="checkbox">
								<label>
									<input type="checkbox" <?= !empty($ruang_prodi['id_ruang_prodi']) ? 'checked' : '' ?> name="prodis[]" value="<?= $ruang_prodi['id_prodi'] ?>">
									<?= $ruang_prodi['jenjang'] ?> - <?= $ruang_prodi['nm_prodi'] ?>
								</label>
							</div>
							<?php
						}
					?>

				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
				<a class="btn btn-sm btn-warning" href="<?= base_url() ?>baa/master/ruang"><i class="fa fa-close"></i> Batal</a>
			</div>
			<?= form_close() ?>
		</div>
		<!-- /.box -->
	</div>
</div>
