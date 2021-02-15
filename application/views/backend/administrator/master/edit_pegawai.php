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
				<h3 class="box-title">Edit Pegawai</h3>
			</div>
			<div class="box-body">
				<!-- /.box-header -->
				<!-- form start -->
				<?php echo form_open('dashboarda/master/user/update_pegawai'); ?>
				<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
				<?php echo formtext('hidden', 'id_user', $id_user, 'required') ?>
				<?php echo formtext('hidden', 'id_pegawai', $id_pegawai, 'required') ?>
				<div class="form-group">
					<label>NIP/NIK</label>
					<input type="text" name="nip" class="form-control" value="<?= $pegawai->nip ?>" readonly=""/>
				</div>
				<div class="form-group">
					<label>Nama</label>
					<input type="text" name="nama" class="form-control" value="<?= $pegawai->nama ?>" required=""/>
				</div>
				<div class="form-group">
					<label>Email</label>
					<input type="email" name="email" class="form-control" value="<?= $pegawai->email ?>" required=""/>
				</div>
				<div class="form-group">
					<label>No HP</label>
					<span class="text-info">Gunakan Nomor Whatsapp dengan format (+62)</span>
					<input type="text" name="no_hp" class="form-control" value="<?= $pegawai->no_hp ?>" required=""/>
				</div>
				<div class="form-group">
					<label>Hak Akses</label>
					<select name="role" class="form-control">
						<option value="1" <?= $pegawai->role == 1 ? 'selected' : '' ?>>Administrator</option>
						<option value="2" <?= $pegawai->role == 2 ? 'selected' : '' ?>>BAA</option>
						<option value="3" <?= $pegawai->role == 3 ? 'selected' : '' ?>>Admin Prodi</option>
					</select>
				</div>

				<div class="form-group">
					<label>Prodi</label>
					<span class="text-info">Khusus Admin Prodi</span>
					<select name="id_prodi" class="form-control" style="width: 100%;" required>
						<option value="0">Pilih Prodi</option>
						<?php
							foreach ($prodis as $prodi) {
								?>
								<option value="<?php echo $prodi['id_prodi'] ?>" <?= $prodi['id_prodi'] == $pegawai->id_prodi ? 'selected' : '' ?>><?php echo $prodi['jenjang'] ?> <?php echo $prodi['nm_prodi'] ?></option>
								<?php
							}
						?>
					</select>
				</div>
			</div>

			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-saved"></i> Perbarui</button>
			</div>
			<?= form_close() ?>
		</div>
		<!-- /.box -->
	</div>
</div>
