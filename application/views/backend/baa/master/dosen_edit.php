<?php if ($this->session->flashdata('msg')): ?>
	<?php
	$class_alert = 'alert ' . $this->session->flashdata('msg-title') . ' alert-dismissable';
	?>
	<div class='<?= $class_alert ?>'>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4><i class="icon fa fa-check"></i> Notifikasi</h4>
		<?php echo $this->session->flashdata('msg'); ?>
	</div>
<?php endif; ?>
<div class="row">
	<!-- left column -->
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Edit Dosen</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<?php echo form_open('baa/master/dosen/update'); ?>
			<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
			<?php echo formtext('hidden', 'id_pegawai', $dosen->id_pegawai, 'required') ?>
			<div class="box-body">
				<div class="form-group">
					<label>NIP/NIK</label>
					<input type="text" name="nip" class="form-control" value="<?= $dosen->nip ?>" readonly=""/>
				</div>
				<div class="form-group">
					<label>Nama</label>
					<input type="text" name="nama" class="form-control" value="<?= $dosen->nama ?>" required=""/>
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" name="email" class="form-control" value="<?= $dosen->email ?>" required=""/>
				</div>
				<div class="form-group">
					<label>Departemen</label>
					<select name="id_departemen" class="form-control select2" style="width: 100%;" required>
						<option value="">- Pilih -</option>
						<?php
							foreach ($departemen as $list) {
								?>
								<option value="<?php echo $list['id_departemen'] ?>" <?= $list['id_departemen'] == $dosen->id_departemen ? 'selected' : '' ?>><?php echo $list['departemen'] ?></option>
								<?php
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Jenjang</label>
					<select name="id_jenjang" class="form-control select2" style="width: 100%;" required>
						<option value="">- Pilih -</option>
						<?php
							foreach ($jenjang as $list) {
								?>
								<option value="<?php echo $list['id_jenjang'] ?>" <?= $list['id_jenjang'] == $dosen->id_jenjang ? 'selected' : '' ?>><?php echo $list['nm_jenjang'] ?></option>
								<?php
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Jabatan</label>
					<select name="jabatan" class="form-control select2" style="width: 100%;" required>
						<option value="">- Pilih -</option>
						<?php
							foreach ($jabatan as $list) {
								?>
								<option value="<?php echo $list['nama_jabatan'] ?>" <?= $list['nama_jabatan'] == $dosen->jabatan ? 'selected' : '' ?>><?php echo $list['nama_jabatan'] ?></option>
								<?php
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Pangkat</label>
					<select name="pangkat" class="form-control select2" style="width: 100%;" required>
						<option value="">- Pilih -</option>
						<?php
							foreach ($pangkat as $list) {
								?>
								<option value="<?php echo $list['nama_pangkat'] ?>" <?= $list['nama_pangkat'] == $dosen->pangkat ? 'selected' : '' ?>><?php echo $list['nama_pangkat'] ?></option>
								<?php
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Golongan</label>
					<select name="golongan" class="form-control select2" style="width: 100%;" required>
						<option value="">- Pilih -</option>
						<?php
							foreach ($golongan as $list) {
								?>
								<option value="<?php echo $list['nama_golongan'] ?>" <?= $list['nama_golongan'] == $dosen->golongan ? 'selected' : '' ?>><?php echo $list['nama_golongan'] ?></option>
								<?php
							}
						?>
					</select>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="external" value="1"> Dosen Eksternal
					</label>
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<div class="callout callout-info">Default password adalah <b>iurisfh</b> bisa diganti pada fitur profile
				</div>
				<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Simpan</button>
			</div>
			<?= form_close() ?>
		</div>
		<!-- /.box -->
	</div>
</div>
