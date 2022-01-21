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
	<div class="col-sm-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Dokumen</h3>
			</div>
			<div class="box-body">

				<div class="form-group">
					<label>Judul Dokumen</label>
					<hr class="divider-line-thin"/>
					<?php echo $dokumen->nama ?>
				</div>
				<div class="form-group">
					<label>NIM</label>
					<hr class="divider-line-thin"/>
					<?php echo $dokumen->identitas ?>
				</div>
				<div class="form-group">
					<label>Nama Mahasiswa</label>
					<hr class="divider-line-thin"/>
					<?php echo $dokumen->nama_mhs ?>
				</div>
				<div class="form-group">
					<label>Judul Disertasi</label>
					<hr class="divider-line-thin"/>
					<?php echo $dokumen->deskripsi ?>
				</div>
				<div class="form-group">
					<label>Link Dokumen</label>
					<hr class="divider-line-thin"/>
					<a class="btn btn-xs bg-red-active" href="<?php echo $dokumen->link_cetak ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Lihat</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Tim Penilai</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<table class="table table-condensed ">
					<thead>
					<tr class="">
						<th>Nama</th>
						<th class="text-center" style="width: 25%">Hasil</th>
					</tr>
					</thead>
					<tbody>
					<?php
						foreach ($dosens as $dosen):
							?>
							<tr class="">
								<td>
									<?php
										if ($this->session_data['username'] == $dosen['identitas']) {
											?>
											<b><?php echo $dosen['nama'] ?><br/></b>
											<?php
										} else {
											?>
											<?php echo $dosen['nama'] ?><br/>
											<?php
										}
									?>
									<i><?php echo $dosen['identitas'] ?></i><br/>
									<?php
										if ($dosen['jenis'] == '1') {
											$str_status_tim = 'Ketua';
										} else {
											$str_status_tim = 'Anggota';
										}
									?>
									<button class="btn btn-xs bg-blue-gradient" style="color:white"><?php echo $str_status_tim ?></button>
								</td>
								<td class="text-center">
									<?php
										if (!empty($dosen['hasil'])) {
											?>
											<b><?php echo $dosen['hasil'] ?></b>
											<?php
										} else {
											?>
											<span class="btn btn-xs btn-danger">Kosong</span>
											<?php
										}
									?>
								</td>
							</tr>
						<?php
						endforeach;
					?>
					</tbody>
				</table>
			</div>
		</div>
		<!-- /.box -->
	</div>
	<div class="col-sm-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Persetujuan Berita Acara</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<?php
				if (!empty($dokumen_persetujuan->waktu)) {

					?>
					<div class="box-body">

						<div class="form-group">
							<label>Nilai</label>
							<hr class="divider-line-thin"/>
							<?php echo $dokumen_persetujuan->nilai ?>
						</div>
						<div class="form-group">
							<label>Hasil</label>
							<hr class="divider-line-thin"/>
							<?php echo $dokumen_persetujuan->hasil ?><br/>
							<?php
								if (!empty($dokumen_persetujuan->waktu) && $dokumen_persetujuan->jenis == '1') {
									if ($dokumen->id_jenjang == JENJANG_S1) {
										if ($dokumen->jenis == DOKUMEN_JENIS_SKRIPSI_UJIAN_PROPOSAL_STR) {
											$id_hasil = $this->skripsi->get_id_status_ujian_by_text($dokumen_persetujuan->hasil, UJIAN_SKRIPSI_PROPOSAL);
										}
										if ($dokumen->jenis == DOKUMEN_JENIS_SKRIPSI_UJIAN_SKRIPSI_STR) {
											$id_hasil = $this->skripsi->get_id_status_ujian_by_text($dokumen_persetujuan->hasil, UJIAN_SKRIPSI_UJIAN);
										}
										if ($dokumen->jenis == DOKUMEN_JENIS_SKRIPSI_UJIAN_PROPOSAL_STR) {
											if ($id_hasil != HASIL_UJIAN_LANJUT) {
												?>
												<hr class="divider-line-thin"/>
												<a class="btn btn-xs bg-navy pull-left" target="_blank" href="<?= base_url() ?>dosen/sarjana/kadep/proposal/plot_ulang/<?= $dokumen->id_tugas_akhir ?>">
													<i class="fa fa-repeat"></i> Penjadwalan Ulang
												</a>
												<br/>
												<?php
											} else if ($id_hasil == HASIL_UJIAN_LANJUT) {
												$pembimbing = $this->skripsi->read_pembimbing_row($dokumen->id_tugas_akhir);
												if (empty($pembimbing)) {
													?>
													<hr class="divider-line-thin"/>
													<a class="btn btn-xs bg-green-active pull-left" target="_blank" href="<?= base_url() ?>dosen/sarjana/kadep/proposal/plot_pembimbing/<?= $dokumen->id_tugas_akhir ?>">
														<i class="fa fa-user-circle-o"></i> Usulkan Pembimbing
													</a>
													<br/>
													<?php
												}

											}
										}
										if ($dokumen->jenis == DOKUMEN_JENIS_SKRIPSI_UJIAN_SKRIPSI_STR) {
											if ($id_hasil != HASIL_UJIAN_LANJUT) {
												?>
												<hr class="divider-line-thin"/>
												<a class="btn btn-xs bg-navy pull-left" target="_blank" href="<?= base_url() ?>dosen/sarjana/kadep/skripsi/plot_ulang/<?= $dokumen->id_tugas_akhir ?>">
													<i class="fa fa-repeat"></i> Penjadwalan Ulang
												</a>
												<br/>
												<?php
											}
										}
									}

								}
							?>
						</div>
						<div class="form-group">
							<label>Keterangan Hasil</label>
							<hr class="divider-line-thin"/>
							<?php echo $dokumen_persetujuan->hasil_keterangan ?>
						</div>
						<div class="form-group">
							<label>Waktu Persetujuan</label>
							<hr class="divider-line-thin"/>
							<?php echo waktu_format_indonesia($dokumen_persetujuan->waktu) ?>
						</div>
						<?php
							if ($dokumen->jenis == DOKUMEN_JENIS_SKRIPSI_UJIAN_PROPOSAL_STR) {
								?>
								<a target="_blank" class="btn btn-xs btn-social btn-vk" href="<?= base_url() ?>dosen/sarjana/proposal/penguji_riwayat/revisi/<?= $dokumen->id_tugas_akhir ?>/<?= $dokumen->id_jadwal ?>">
									<i class="fa fa-edit"></i> Bimbingan Revisi
								</a>
								<?php
							}
						?>
					</div>
					<?php
				} else {
					?>
					<?php echo form_open('dosen/dokumen/berita_acara/persetujuan/save'); ?>
					<div class="box-body">
						<?php
							if ($dokumen_persetujuan->jenis == '1') {
								?>
								<div class="callout callout-info">Anda adalah penentu hasil akhir</div>
								<?php
							} else {
								?>
								<?php
							}
						?>

						<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
						<?php echo formtext('hidden', 'id_dokumen', $dokumen_persetujuan->id_dokumen, 'required') ?>
						<?php echo formtext('hidden', 'id_persetujuan', $dokumen_persetujuan->id_dokumen_persetujuan, 'required') ?>
						<?php echo formtext('hidden', 'jenis', $dokumen_persetujuan->jenis, 'required') ?>
						<?php
							if ($dokumen->id_jenjang == JENJANG_S1 && $dokumen->tipe == 'berita-acara' && $dokumen->jenis == 'skripsi') {
								?>
								<div class="form-group">
									<label>Nilai</label>
									<input type="number" id="nilai" name="nilai" required="true" class="form-control">
								</div>
								<?php
							} else {
								?>
								<div class="form-group">
									<label>Nilai</label>
									<input type="text" id="nilai" name="nilai" required="true" class="form-control">
								</div>
								<?php
							}
						?>
						<div class="form-group">
							<label>Hasil</label>
							<select name="hasil" id="hasil" class="form-control select2" style="width: 100%;" required data-placeholder="Pilih Hasil">
								<option></option>
								<?php
									foreach ($status_ujians as $status_ujian) {
										if ($status_ujian['value'] != '0') {
											?>
											<option value="<?php echo $status_ujian['text'] ?>"><?php echo $status_ujian['text'] ?></option>
											<?php
										}
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label>Keterangan (Catatan Perbaikan)</label>
							<textarea name="keterangan" class="form-control"></textarea>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<button type="submit" id="btn-submit-confirm-persetujuan" class="btn btn-sm btn-success">
							<i class="fa fa-check"></i> Setujui
						</button>
					</div>
					<?php echo form_close() ?>
					<?php
				}
			?>
		</div>
		<!-- /.box -->
	</div>
</div>
