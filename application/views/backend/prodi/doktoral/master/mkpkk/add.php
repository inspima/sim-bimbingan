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
			<?php echo form_open('prodi/doktoral/master/mkpkk/save'); ?>
			<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
			<div class="box-body">
				<div class="form-group">
					<label>Departemen</label>
					<select name="id_departemen" class="form-control select2" style="width: 100%;" required>
						<option value="">- Pilih -</option>
						<?php
							foreach ($departemen as $list) {
								?>
								<option value="<?php echo $list['id_departemen'] ?>" ><?php echo $list['departemen'] ?></option>
								<?php
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Kode</label>
					<?php echo formtext('text', 'kode', '', 'required') ?>
				</div>
				<div class="form-group">
					<label>Nama</label>
					<?php echo formtext('text', 'nama', '', 'required') ?>
				</div>
				<div class="form-group">
					<label>SKS</label>
					<?php echo formtext_angka('number', 'sks', '', 'required') ?>
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
				<a class="btn btn-sm btn-warning" href="<?= base_url() ?>prodi/doktoral/master/mkpkk"><i class="fa fa-close"></i> Batal</a>
			</div>
			<?= form_close() ?>
		</div>
		<!-- /.box -->
	</div>
</div>
