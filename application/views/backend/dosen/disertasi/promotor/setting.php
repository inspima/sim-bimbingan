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
			<?php echo form_open('dosen/disertasi/kualifikasi/promotor_save'); ?>
			<div class="box-body table-responsive">
				<div class="callout callout-info">Pengajuan oleh mahasiswa, data dapat dirubah oleh KPS</div>
				<?php
					if ($disertasi->status_kualifikasi >= STATUS_DISERTASI_KUALIFIKASI_SELESAI) {
						?>
						<div class="form-group">
							<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
							<?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
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
							<select name="status_tim" class="form-control">
								<option value="1">Promotor</option>
								<option value="2">Ko Promotor</option>
							</select>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan
							</button>
						</div>
						<?php echo form_close() ?>
						<?php $this->view('backend/widgets/disertasi/list_promotor_kopromotor', ['disertasi' => $disertasi]); ?>
						<?php
						if ($disertasi->status_promotor == STATUS_DISERTASI_PROMOTOR_SETUJUI):
							?>
							<?php echo form_open('dosen/disertasi/promotor/setujui'); ?>
							<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
							<?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
							<hr class="divider-line-thin"/>
							<div class="form-group pull-right">
								<button type="submit" class="btn btn-sm btn-success">
									<i class="fa fa-check-square-o"></i> Setujui Pengajuan
								</button>
							</div>
							<?php echo form_close() ?>
						<?php
						else:
							?>
							<?php echo form_open('dosen/disertasi/promotor/kirim_whatsapp'); ?>
							<div class="form-group">
								<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
								<?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
								<button type="submit" class="btn btn-sm btn-success">
									<i class="fa fa-comment"></i> Kirim Notifikasi Whatsapp
								</button>
							</div>
							<?php echo form_close() ?>
						<?php
						endif;
						?>
						<?php
					} else {
						?>
						<div class="form-group">
							<p>Ujian kualifikasi belum selesai</p>
						</div>
						<?php
					}
				?>
			</div>
		</div>
	</div>
</div>
