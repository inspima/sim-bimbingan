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
				<h3 class="box-title">Informasi Ujian</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body">
				<div class="form-group">
					<label>Nama</label><br/>
					<?php
						echo $proposal->nama;
					?>
				</div>
				<div class="form-group">
					<label>Nim</label><br/>
					<?php
						echo $proposal->nim;
					?>
				</div>
				<div class="form-group">
					<label>Judul</label><br/>
					<?php
						$judul = $this->skripsi->read_judul($proposal->id_skripsi);
						echo $judul->judul;
					?>
				</div>
				<div class="form-group">
					<label>Berkas Proposal</label>
					<p>
						<a href="<?php echo base_url() ?>assets/upload/proposal/<?php echo $proposal->berkas_proposal ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="50px" height="auto"></a>
					</p>
				</div>
				<div class="form-group">
					<label>Tanggal</label>
					<p class="text-muted"><?php echo woday_toindo($ujian->tanggal); ?></p>

				</div>

				<div class="form-group">
					<label>Ruang</label>
					<p class="text-muted"><?php echo $ujian->ruang . ' - ' . $ujian->gedung; ?></p>
				</div>

				<div class="form-group">
					<label>Jam</label>
					<p class="text-muted"><?php echo $ujian->jam; ?></p>
				</div>

				<div class="form-group">
					<label>Hasil Ujian</label>
					<p>
						<?php
							if ($proposal->status_ujian_proposal == '0') {
								echo 'Belum ujian';
							} else if ($proposal->status_ujian_proposal == '1') {
								echo 'Layak dan dapat dilanjutkan untuk penulisan skripsi';
							} else if ($proposal->status_ujian_proposal == '2') {
								echo 'Layak dengan catatan perbaikan dan dapat dilanjutkan untuk penulisan skripsi';
							} else if ($proposal->status_ujian_proposal == '3') {
								echo 'Tidak layak dan harus diuji kembali';
							}
						?>
					</p>
				</div>


			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>

	<div class="col-md-12">
		<!-- general form elements -->
		<div class="box box-default">
			<div class="box-header bg-olive-active">
				<h3 class="box-title">Bimbingan Revisi</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body table-responsive">
				<?php
					if ($detail_penguji->status_revisi == '1') {
						?>
						<p class="callout callout-success "><b>Status Revisi : </b>Sudah selesai</p>
						<?php
					} else {
						?>
						<p class="callout callout-danger "><b>Status Revisi : </b>Belum selesai</p>
						<?php
					}
				?>
				<?= form_open('dosen/sarjana/proposal/penguji_riwayat/revisi/update') ?>
				<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
				<?php echo formtext('hidden', 'id_penguji', $detail_penguji->id_penguji, 'required') ?>
				<div class="form-group">
					<label>Catatan Revisi</label>
					<textarea class="form-control text-editor-bootstrap" name="revisi" rows="7" style="resize: none" required><?= $detail_penguji->revisi ?></textarea>
				</div>
				<?php
					if ($detail_penguji->status_revisi == '0'||empty($detail_penguji->status_revisi)) {
						?>
						<p>
							<button type="submit" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-saved"></i> Simpan</button>
						</p>
						<?php
					}
				?>
				<?= form_close() ?>
				<hr class="divider10"/>
				<h4><b>Riwayat Revisi</b></h4>
				<table class="table table-bordered table-striped">
					<tr class="bg-blue-gradient">
						<th>No</th>
						<th>Revisi</th>
						<th class="text-center">Tgl Bimbingan</th>
						<th class="text-center">Status Persetujuan</th>
						<th>Aksi</th>
					</tr>
					<?php
						if (!empty($riwayat_revisis)) {
							$no = 1;
							foreach ($riwayat_revisis as $riwayat_revisi) {
								?>
								<tr>
									<td><?= $no++ ?></td>
									<td><?= $riwayat_revisi['revisi'] ?> <br/>
										<a href="<?php echo base_url() ?>assets/upload/mahasiswa/skripsi/revisi/<?php echo $riwayat_revisi['file'] ?>" class="btn btn-xs btn-danger" style="margin: 5px"><i class="fa  fa-file-pdf-o"></i> File</a>
									</td>
									<td><?= tanggal_hari_format_indonesia($riwayat_revisi['tgl']) ?></td>
									<td>
										<?php
											if ($riwayat_revisi['status_persetujuan'] == '1') {
												?>
												<label class="label label-success">Sudah</label>
												<p class="text-muted"><?= tanggal_hari_format_indonesia($riwayat_revisi['waktu_persetujuan']) ?></p>
												<?php
											} else {
												?>
												<label class="label label-danger">Belum</label>
												<?php
											}
										?>
									</td>
									<td>
										<?php
											if ($riwayat_revisi['status_persetujuan'] == '0') {
												?>
												<?= form_open('dosen/sarjana/proposal/penguji_riwayat/revisi/update_riwayat') ?>
												<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
												<?php echo formtext('hidden', 'id_revisi', $riwayat_revisi['id_bimbingan_revisi_skripsi'], 'required') ?>
												<button type="submit" class="btn btn-xs btn-success"><i class="fa fa-check-circle-o"></i> Setujui</button>
												<?= form_close() ?>
												<?php
											}
										?>
									</td>
								</tr>
								<?php
							}
						} else {
							?>
							<tr>
								<td class="text-center" colspan="6"><p class="label label-danger">Data Kosong</p></td>
							</tr>
							<?php
						}
					?>
				</table>
				<?php
					if (($detail_penguji->status_revisi == '0'||empty($detail_penguji->status_revisi))&&!empty($riwayat_revisis)) {
						?>
						<?= form_open('dosen/sarjana/proposal/penguji_riwayat/revisi/setujui') ?>
						<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
						<?php echo formtext('hidden', 'id_penguji', $detail_penguji->id_penguji, 'required') ?>
						<button type="submit" class="btn btn-sm btn-primary" style="margin: 15px 0px"><i class="fa fa-check-circle-o"></i> Selesaikan Revisi</button>
						<?= form_close() ?>
						<?php
					}
				?>
			</div>
		</div>
		<!-- /.box -->
	</div>

</div>


