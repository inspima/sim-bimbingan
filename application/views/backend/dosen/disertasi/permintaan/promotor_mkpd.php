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
	<div class="col-sm-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h2 class="box-title">Informasi Disertasi</h2>

			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body">
				<?php $this->view('backend/widgets/disertasi/informasi_disertasi_judul', ['disertasi' => $disertasi]); ?>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Promotor & Ko-Promotor</h3>
			</div>
			<div class="box-body table-responsive">
				<?php $this->view('backend/widgets/disertasi/list_promotor_kopromotor', ['disertasi' => $disertasi]); ?>
			</div>
		</div>
		<!-- /.box -->
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">MKPD</h3>
			</div>
			<div class="box-body table-responsive">
				<?php
					if ($disertasi->status_mkpd == STATUS_DISERTASI_MKPD_SETUJUI_KPS):
						?>
						<?php echo form_open('dosen/disertasi/permintaan/promotor/mkpd/update'); ?>
						<?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
						<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
						<div class="form-group">
							<table class="table table-bordered">
								<tr class="bg-gray">
									<th style="width: 10%">Kode MK</th>
									<th style="width: 35%">Nama MK</th>
									<th style="width: 10%">SKS</th>
									<th style="width: 45%">Dosen</th>
								</tr>
								<?php
									$mkpds = $this->disertasi->read_disertasi_mkpd($disertasi->id_disertasi);
									foreach ($mkpds as $i => $mkpd) {
										?>
										<tr>
											<td>
												<input name="kode<?= $i+1 ?>" type="text" class="form-control" value="<?= $mkpd['kode'] ?>">
											</td>
											<td>
												<textarea name="nama<?= $i+1 ?>" class="form-control" style="resize: none"><?= $mkpd['mkpd'] ?></textarea>
											</td>
											<td>
												<input name="sks<?= $i+1 ?>" type="number" class="form-control" value="<?= $mkpd['sks'] ?>">
											</td>
											<td>
												<?php
													$mkpd_pengampus = $this->disertasi->read_disertasi_mkpd_pengampu($mkpd['id_disertasi_mkpd']);
													$arr_mkpd_pengampu=array_pluck($mkpd_pengampus,'nip');
												?>
												<select name="pengampu<?= $i+1 ?>[]" class="form-control select2" style="width: 100%;" data-placeholder="Pilih Pengampu" multiple>
													<option></option>
													<?php
														foreach ($mdosen as $list) {
															?>
															<option value="<?php echo $list['nip'] ?>" <?php echo in_array($list['nip'], $arr_mkpd_pengampu) ? 'selected' : '' ?>><?php echo $list['nama'] ?></option>
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
						<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-refresh"></i> Perbarui
						</button>
						<?= form_close() ?>
					<?php
					endif;
				?>
				<div class="divider10"></div>
				<?php $this->view('backend/widgets/disertasi/list_mkpd_promotor', ['disertasi' => $disertasi]); ?>
				<?php
					if ($disertasi->status_mkpd == STATUS_DISERTASI_MKPD_SETUJUI_KPS):
						?>
						<?php echo form_open('dosen/disertasi/permintaan/promotor/mkpd/setujui') ?>
						<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
						<button class="btn btn-sm btn-success"><i class="fa fa-check"></i> Proses Setujui
						</button><br/>
						<?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
						<?= form_close() ?>
					<?php
					endif;
				?>

			</div>
		</div>
	</div>
</div>
