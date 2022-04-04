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
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body">
				<div class="col-sm-6">
					<h3 class="box-title">Ujian Proposal</h3>
					<hr/>
					<div class="form-group">
						<label>Judul</label><br/>
						<?php
							$judul = $this->proposal->read_judul($proposal->id_skripsi);
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
				<div class="col-sm-6">
					<h3 class="box-title">Penguji</h3>
					<hr/>
					<div class="form-group">
						<?php
							foreach ($pengujis as $penguji) {
								?>
								<p>
									<?php
										if ($penguji['status_tim'] == '1') {
											?>
											<button type="submit" class="btn btn-xs btn-primary"> Ketua</button>
											<?php
										} else if ($penguji['status_tim'] == '2') {
											?>
											<button type="submit" class="btn btn-xs btn-primary"> Anggota</button>
											<?php
										}
									?>

									<?php echo $penguji['nama'] ?><br/><?= $penguji['nip'] ?>

								</p>

								<?php
							}
						?>
					</div>
				</div>

			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
</div>
<div class="row">

	<!-- left column -->
	<div class="col-sm-12">
		<!-- general form elements -->
		<div class="box box-default">
			<!-- /.box-header -->
			<div class="box-header bg-olive-active">
				<h3 class="box-title"><b>Revisi</b></h3>
			</div>
			<!-- form start -->
			<div class="box-body">
				<div class="row">
					<div class="col-sm-6">
						<h4><b>Form Revisi</b></h4>
						<hr class="divider5"/>
						<?php echo form_open_multipart('dashboardm/modul/proposal/revisi/save'); ?>
						<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
						<?php echo formtext('hidden', 'id_mhs', $proposal->id_mahasiswa, 'required') ?>
						<?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
						<div class="form-group">
							<label>Nama Penguji</label>
							<?php echo formtext('hidden', 'persetujuan_judul', $judul->persetujuan, 'required') ?>
							<select name="id_dosen" class="form-control select2" style="width: 100%;" required>
								<?php
									foreach ($pengujis as $penguji) {
										if ($penguji['status_revisi'] != '1') {
											?>
											<option value="<?php echo $penguji['id_pegawai'] ?>"><?php echo $penguji['nama'] ?></option>
											<?php
										}
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label>Isi Revisi</label>
							<textarea class="form-control" name="revisi" rows="4" style="resize: none" required></textarea>
						</div>
						<div class="form-group">
							<label>Upload Bukti Revisi</label>
							<input type="file" name="bukti_revisi" class="form-control" required>
						</div>
						<p>
							<button type="submit" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-saved"></i> Simpan</button>
						</p>
						<?= form_close() ?>
					</div>
					<div class="col-sm-6">
						<h4><b>Status Revisi Penguji</b></h4>
						<hr class="divider5"/>
						<table class="table table-bordered table-striped">
							<tr class="bg-blue-gradient">
								<th>No</th>
								<th>Nama Dosen</th>
								<th class="text-center">Revisi</th>
								<th class="text-center">Status</th>
							</tr>
							<?php
								$no = 1;
								foreach ($pengujis as $penguji) {
									?>

									<tr>
										<td><?= $no++ ?></td>
										<td><?= $penguji['nama'] ?></td>
										<td>
											<button class="btn btn-warning btn-xs" onclick="$('#revisi-<?= $penguji['id_penguji'] ?>').toggle();">Tampilkan Isi</button>
										</td>
										<td>
											<?php
												if ($penguji['status_revisi'] == '1') {
													?>
													<label class="label label-success">Selesai</label>
													<?php
												} else {
													?>
													<label class="label label-danger">Belum</label>
													<?php
												}
											?>
										</td>
									</tr>
									<tr id="revisi-<?= $penguji['id_penguji'] ?>" style="display: none">
										<td colspan="4">
											<?= !empty($penguji['revisi']) ? $penguji['revisi'] : '<label class="label label-danger">Kosong</label>' ?>
										</td>
									</tr>

									<?php
								}
							?>

						</table>
					</div>
				</div>
				<hr class="divider10"/>
				<h4><b>Riwayat Revisi</b></h4>
				<table class="table table-bordered table-striped">
					<tr class="bg-blue-gradient">
						<th>No</th>
						<th>Nama Dosen</th>
						<th>Isi Revisi</th>
						<th class="text-center">Tgl Bimbingan</th>
						<th class="text-center">Persetujuan</th>
						<th>Aksi</th>
					</tr>
					<?php
						if (!empty($riwayat_revisis)) {

							$no = 1;
							foreach ($riwayat_revisis as $riwayat_revisi) {
								?>
								<tr>
									<td><?= $no++ ?></td>
									<td><b><?= $riwayat_revisi['nama'] ?></b></td>
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
												<?= form_open('dashboardm/modul/proposal/revisi/delete') ?>
												<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
												<?php echo formtext('hidden', 'id_revisi', $riwayat_revisi['id_bimbingan_revisi_skripsi'], 'required') ?>
												<button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove-circle"></i> Hapus</button>
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
			</div>
		</div>
		<!-- /.box -->
	</div>
</div>
