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
	<div class="col-sm-12">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $subtitle ?></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<?php echo form_open_multipart('mahasiswa/disertasi/mkpd/save'); ?>
			<?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
			<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
			<div class="box-body">
				<?php
					foreach ($promotor_kopromotors as $promotor_kopromotor) {
						?>

						<div class="form-group">
							<label><?=$promotor_kopromotor['status_tim']=='1'?'Promotor':'Ko-Promotor'?></label>
							<p><?php echo $promotor_kopromotor['nama'] ?> <br/> <b><?php echo $promotor_kopromotor['nip'] ?></b></p>
						</div>
						<?php
					}
				?>
				<hr class="divider-line-thin"/>

				<div class="form-group">
					<label>Judul</label>
					<hr class="divider-line-thin"/>
					<?php echo $disertasi->judul ?>
				</div>
				<div class="form-group">
					<label>Mata Kuliah MKPD
						<i class="label label-info">Total SKS (Semua mata kuliah) harus 6 </i>
					</label>
					<table class="table table-bordered">
						<tr>
							<th style="width: 10%">Kode MK</th>
							<th style="width: 35%">Nama/Topik MK</th>
							<th style="width: 10%">SKS</th>
							<th style="width: 45%">Dosen</th>
						</tr>
						<tr>
							<td rowspan="3">
								<input name="kode1" type="text" class="form-control" value="PDH807">
							</td>
							<td>
								<textarea name="nama1" class="form-control" style="resize: none"></textarea>
							</td>
							<td rowspan="3">
								<input name="sks1" type="number" class="form-control sks-mkpd" value="6" readonly>
							</td>
							<td>
								<select name="pengampu1[]" class="form-control select2" style="width: 100%;">
									<option value="">- Pilih -</option>
									<?php
										foreach ($mdosen as $list) {
											?>
											<option value="<?php echo $list['nip'] ?>"><?php echo $list['nama'] ?></option>
											<?php
										}
									?>
								</select>
							</td>
						</tr>
						<?php
							for ($i = 2; $i <= 3; $i++) {
								?>
								<tr>
									<td>
										<textarea name="nama<?= $i ?>" class="form-control" style="resize: none"></textarea>
									</td>
									<td>
										<select name="pengampu<?= $i ?>[]" class="form-control select2" style="width: 100%;">
											<option value="">- Pilih -</option>
											<?php
												foreach ($mdosen as $list) {
													?>
													<option value="<?php echo $list['nip'] ?>"><?php echo $list['nama'] ?></option>
													<?php
												}
											?>
										</select>
									</td>
								</tr>
								<?php
							}
						?>
					</table>
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-arrow-up"></i> Ajukan</button>
			</div>
			<?= form_close() ?>
		</div>
		<!-- /.box -->
	</div>
</div>
