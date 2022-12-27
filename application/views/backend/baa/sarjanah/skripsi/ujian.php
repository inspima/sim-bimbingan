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
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title"><?= $subtitle ?></h3>
				<div class="pull-right">
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<?php $this->view('backend/widgets/skripsi/tab_link_baa_skripsi'); ?>
				<hr/>
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Skripsi</th>
						<th>Jadwal</th>
						<th>Penguji</th>
						<th>Opsi</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($skripsi as $list) {
							$ujian = $this->skripsi->read_jadwal($list['id_skripsi'],UJIAN_SKRIPSI_UJIAN);
							?>
							<tr>
								<td><?= $no ?></td>
								<td>
									<?= $list['nama'] . '<br>' . $list['nim'] ?>
									<br/><b>Judul</b><br/>
									<?php
										$judul = $this->skripsi_ujian->read_judul($list['id_skripsi']);
										echo $judul->judul;
									?>
									<br/><b>Berkas</b><br/>
									<a href="<?php echo base_url() ?>assets/upload/turnitin/<?php echo $list['turnitin'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
									<p><b>Departemen </b><br/> <?php echo $list['departemen'] ?></p>
									<p><b>Gelombang </b><br/> <?= $list['gelombang'] . ' / ' . $list['semester'] ?></p>
									<p><b>Pembimbing </b><br/>
										<?php
											$pembimbing = $this->skripsi_ujian->read_pembimbing($list['id_skripsi']);
											echo $pembimbing->nama;
										?>
									</p>
								</td>
								<td>
									<?php
										echo '<strong>Tanggal : </strong>' . toindo($list['tanggal']) . '<br>';
										echo '<strong>Jam     : </strong>' . $list['jam'] . '<br>';
										echo '<strong>Ruang   : </strong>' . $list['ruang'] . ' - ' . $list['gedung'] . '<br>';
									?>
								</td>
								<td>
									<ul style="padding-left: 15px">
										<?php
											$penguji = $this->skripsi->read_penguji($list['id_ujian']);
											foreach ($penguji as $show) {
												if ($show['status_tim'] == '1') {
													$ka = 'ketua';
												} else if ($show['status_tim'] == '2') {
													$ka = 'anggota';
												}

												if ($show['usulan_dosbing'] == '0') {
													$up = '';
												} else if ($show['usulan_dosbing'] == '1') {
													$up = '- usulan pembimbing';
												} else if ($show['usulan_dosbing'] == '2') {
													$up = '- pembimbing';
												}
												if ($show['status'] == '3') {
													$apv = '<br/><b class="text-red">Ditolak</b>';
													$tdc = 'style="text-decoration:line-through"';
												} else {
													$apv = '';
													$tdc = '';
												}

												echo '<li><span '.$tdc.'>'  . $show['nama'] . '</span><strong>(' . $ka . $up . ')</strong>'.$apv;
											}
										?>

									</ul>
								</td>
								</td>
								<td>
									<?php
										$ketua = $this->skripsi_ujian->read_pengujiketua($list['id_ujian']);
										if ($ketua) {

										} else {
											echo 'belum set ketua penguji';
										}
									?>
									<!-- Surat Tugas -->
									<?php
										$data_dokumen_surat_tugas = [
												'tipe' => DOKUMEN_SURAT_TUGAS_SKRIPSI_PENGUJI_STR,
												'jenis' => DOKUMEN_JENIS_SKRIPSI_UJIAN_SKRIPSI_STR,
												'identitas' => $list['nim'],
										];
										$dokumen_surat_tugas = $this->dokumen->detail_by_data($data_dokumen_surat_tugas);
									?>
									<h4>Surat Tugas</h4>
									<?php
										$attributes = array('target' => '_blank', 'autocomplete' => 'off');
										echo form_open('baa/sarjanah/skripsi/cetak_surat_tugas', $attributes)
									?>
									<input type="text" name="no_sk" style="margin-bottom: 10px" class="form-control" placeholder="NO SK" value="<?= !empty($dokumen_surat_tugas) ? $dokumen_surat_tugas->no_doc : '' ?>" required/>
									<input type="text" name="tgl_sk" style="margin-bottom: 10px" class="datepicker form-control" placeholder="TGL SK" value="<?= !empty($dokumen_surat_tugas) ? date('d-m-Y', strtotime($dokumen_surat_tugas->date_doc)) : '' ?>" required/>
									<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
									<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
									<?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
									<button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-print"></i> Surat Tugas</button>
									<?php echo form_close(); ?>
									<hr class="divider-line-semi-bold"/>
									<!-- Berita Acara -->
									<?php
										$attributes = array('target' => '_blank');
										echo form_open('baa/sarjanah/skripsi/cetak_berita', $attributes)
									?>
									<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
									<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
									<button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-print"></i> Berita Acara</button>
									<?php echo form_close(); ?>
									<hr class="divider-line-semi-bold"/>
									<!-- Pemberitahuan -->
									<?php
										$data_dokumen_surat_tugas = [
												'tipe' => DOKUMEN_SURAT_PEMBERITAHUAN_SKRIPSI_STR,
												'jenis' => DOKUMEN_JENIS_SKRIPSI_UJIAN_SKRIPSI_STR,
												'identitas' => $list['nim'],
										];
										$dokumen_pemberitahuan = $this->dokumen->detail_by_data($data_dokumen_surat_tugas);
									?>
									<h4>Surat Pemberitahuan</h4>
									<?php
										$attributes = array('target' => '_blank', 'autocomplete' => 'off');
										echo form_open('dashboardb/skripsi/skripsi_ujian/cetak_pemberitahuan', $attributes)
									?>
									<input type="text" name="no_sk" style="margin-bottom: 10px" class="form-control" placeholder="NO SK" value="<?= !empty($dokumen_pemberitahuan) ? $dokumen_pemberitahuan->no_doc : '' ?>" required/>
									<input type="text" name="tgl_sk" style="margin-bottom: 10px" class="datepicker form-control" placeholder="TGL SK" value="<?= !empty($dokumen_pemberitahuan) ? date('d-m-Y', strtotime($dokumen_pemberitahuan->date_doc)) : '' ?>" required/>
									<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
									<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
									<?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
									<button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-print"></i> Cetak Pemberitahuan</button>
									<?php echo form_close(); ?>
									<hr class="divider-line-semi-bold"/>
									<!-- Penilaian -->
									<?php $attributes = array('target' => '_blank'); ?>
									<?php echo form_open('dashboardb/skripsi/skripsi_ujian/cetak_penilaian', $attributes) ?>
									<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
									<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
									<?php echo formtext('hidden', 'id_ujian', $list['id_ujian'], 'required') ?>
									<button type="submit" class="btn btn-xs btn-primary">Cetak Penilaian</button>
									<?php echo form_close() ?>
									<hr class="divider-line-semi-bold"/>
									<!-- Rekapitulasi -->
									<?php $attributes = array('target' => '_blank'); ?>
									<?php echo form_open('dashboardb/skripsi/skripsi_ujian/cetak_rekapitulasi', $attributes) ?>
									<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
									<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
									<?php echo formtext('hidden', 'id_ujian', $list['id_ujian'], 'required') ?>
									<button type="submit" class="btn btn-xs btn-primary">Cetak Rekapitulasi</button>
									<?php echo form_close() ?>
									<hr class="divider-line-semi-bold"/>
									<!-- Perbaikan -->
									<?php $attributes = array('target' => '_blank'); ?>
									<?php echo form_open('dashboardb/skripsi/skripsi_ujian/cetak_perbaikan', $attributes) ?>
									<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
									<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
									<?php echo formtext('hidden', 'id_ujian', $list['id_ujian'], 'required') ?>
									<button type="submit" class="btn btn-xs btn-primary">Cetak Perbaikan</button>
									<?php echo form_close() ?>
									<hr class="divider-line-semi-bold"/>
									<!-- konsumsi -->
									<?php $attributes = array('target' => '_blank'); ?>
									<?php echo form_open('dashboardb/skripsi/skripsi_ujian/cetak_absensi', $attributes) ?>
									<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
									<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
									<?php echo formtext('hidden', 'id_ujian', $list['id_ujian'], 'required') ?>
									<button type="submit" class="btn btn-xs btn-primary">Cetak Konsumsi</button>
									<?php echo form_close() ?>
								</td>

							</tr>
							<?php
							$no++;
						}
					?>

					</tfoot>
				</table>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
	<!-- /.col -->
</div>
