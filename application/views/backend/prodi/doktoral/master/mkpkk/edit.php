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
				<h3 class="box-title"><?php echo $subtitle ?></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<?php echo form_open('prodi/doktoral/master/mkpkk/update'); ?>
			<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
			<?php echo formtext('hidden', 'id_mkpkk', $mkpkk->id_mkpkk, 'required') ?>

			<div class="box-body">

				<div class="form-group">
					<label>Departemen</label>
					<select name="id_departemen" class="form-control select2" style="width: 100%;" required>
						<option value="">- Pilih -</option>
						<?php
							foreach ($departemen as $list) {
								?>
								<option value="<?php echo $list['id_departemen'] ?>" <?= $list['id_departemen'] == $mkpkk->id_departemen ? 'selected' : '' ?>><?php echo $list['departemen'] ?></option>
								<?php
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<label>Kode</label>
					<?php echo formtext('text', 'kode', $mkpkk->kode, 'required') ?>
				</div>

				<div class="form-group">
					<label>Nama</label>
					<?php echo formtext('text', 'nama', $mkpkk->nama, 'required') ?>
				</div>

				<div class="form-group">
					<label>SKS</label>
					<?php echo formtext('number', 'sks', $mkpkk->sks, 'required') ?>
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
			</div>
			<?= form_close() ?>
		</div>
		<!-- /.box -->
	</div>

	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Pengampu MK</h3>
			</div>
			<!-- /.box-header -->

			<div class="box-body">
				<?php echo form_open('prodi/doktoral/master/mkpkk/save_pengampu'); ?>

				<div class="form-group">
					<label>Pengampu</label>
					<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
					<?php echo formtext('hidden', 'id_mkpkk', $mkpkk->id_mkpkk, 'required') ?>
					<select name="nip" class="form-control select2" style="width: 100%;" required>
						<option value="">- Pilih -</option>
						<?php
							foreach ($mdosen as $list) {
								?>
								<option value="<?php echo $list['nip'] ?>"><?php echo $list['nama'] ?></option>
								<?php
							}
						?>
					</select>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah</button>
				</div>

				<?php echo form_close() ?>
				<table class="table table-bordered">
					<tr>
						<th>Nama</th>
						<th>Status Tim</th>
						<th>Aksi</th>
					</tr>
					<?php
						foreach ($mkpkk_pengampu as $pengampu) {
							?>
							<tr>
								<td><?= $pengampu['nama'] ?> <br/><b><?= $pengampu['nip'] ?></b></td>
								<td class="text-center">
									<?php
										if ($pengampu['pjmk'] == '1') {
											?>
											<?php echo form_open('prodi/doktoral/master/mkpkk/update_pjmk'); ?>
											<div class="form-group">
												<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
												<?php echo formtext('hidden', 'id_mkpkk_pengampu', $pengampu['id_mkpkk_pengampu'], 'required') ?>
												<?php echo formtext('hidden', 'pjmk', 0, 'required') ?>
												<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-user"></i> PJMK</button>
											</div>
											<?php echo form_close() ?>
											<?php
										} else {
											?>
											<?php echo form_open('prodi/doktoral/master/mkpkk/update_pjmk'); ?>
											<div class="form-group">
												<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
												<?php echo formtext('hidden', 'id_mkpkk_pengampu', $pengampu['id_mkpkk_pengampu'], 'required') ?>
												<?php echo formtext('hidden', 'pjmk', 1, 'required') ?>
												<button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-user"></i> Anggota</button>
											</div>
											<?php echo form_close() ?>
											<?php
										}
									?>
								</td>
<!--								<td class="text-center">-->
<!--									--><?php
//										if ($pengampu['status'] == '1') {
//											?>
<!--											--><?php //echo form_open('prodi/doktoral/master/mkpkk/update_status'); ?>
<!--											<div class="form-group">-->
<!--												--><?php //echo formtext('hidden', 'hand', 'center19', 'required') ?>
<!--												--><?php //echo formtext('hidden', 'id_mkpkk_pengampu', $pengampu['id_mkpkk_pengampu'], 'required') ?>
<!--												--><?php //echo formtext('hidden', 'status', 0, 'required') ?>
<!--												<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Aktif</button>-->
<!--											</div>-->
<!--											--><?php //echo form_close() ?>
<!--											--><?php
//										} else {
//											?>
<!--											--><?php //echo form_open('prodi/doktoral/master/mkpkk/update_status'); ?>
<!--											<div class="form-group">-->
<!--												--><?php //echo formtext('hidden', 'hand', 'center19', 'required') ?>
<!--												--><?php //echo formtext('hidden', 'id_mkpkk_pengampu', $pengampu['id_mkpkk_pengampu'], 'required') ?>
<!--												--><?php //echo formtext('hidden', 'status', 1, 'required') ?>
<!--												<button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-close"></i> Tidak</button>-->
<!--											</div>-->
<!--											--><?php //echo form_close() ?>
<!--											--><?php
//										}
//									?>
<!--								</td>-->
								<td>
									<?php echo form_open('prodi/doktoral/master/mkpkk/delete_pengampu'); ?>
									<div class="form-group">
										<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
										<?php echo formtext('hidden', 'id_mkpkk_pengampu', $pengampu['id_mkpkk_pengampu'], 'required') ?>
										<button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-close"></i> Hapus</button>
									</div>
									<?php echo form_close() ?>
								</td>
							</tr>
							<?php
						}
					?>
				</table>
			</div>
		</div>
		<!-- /.box -->
	</div>
</div>
