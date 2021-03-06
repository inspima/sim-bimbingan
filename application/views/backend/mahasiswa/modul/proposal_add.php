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
			<?php echo form_open_multipart('dashboardm/modul/proposal/save'); ?>
			<div class="box-body">
				<div class="form-group">
					<label>Terdaftar di Pekan Skripsi : </label>
					<?php echo formtext('hidden', 'id_pekan', $pekan['id_pekan'], 'required') ?>
					<p style="font-size: 1.2em;" class="text-light-blue"><i><?= $pekan['nama'] ?></i></p>
				</div>
				<div class="form-group">
					<label>Bagian (Departemen)</label>
					<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
					<?php echo formtext('hidden', 'id_gelombang', $gelombang->id_gelombang, 'required') ?>
					<select name="id_departemen" class="form-control select2" style="width: 100%;" required>
						<option value="">Pilih</option>
						<?php
							foreach ($departemen as $list) {
								?>
								<option value="<?php echo $list['id_departemen'] ?>"><?php echo $list['departemen'] ?></option>
								<?php
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Judul</label>
					<textarea class="form-control" name="judul" style="resize: none;" rows="4" required></textarea>
				</div>
				<div class="form-group">
					<label>Upload BAB 1 (format file .pdf maks 10mb)</label>
					<input type="file" name="berkas_proposal" class="form-control" required>
				</div>

			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
				<a class="btn btn-sm btn-warning" href="<?= base_url() ?>dashboardm/modul/proposal"><i class="fa fa-close"></i> Batal</a>
			</div>
			<?= form_close() ?>
		</div>
		<!-- /.box -->
	</div>
</div>
