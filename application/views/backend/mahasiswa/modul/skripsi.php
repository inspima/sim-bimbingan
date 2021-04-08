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
<?php $this->view('backend/widgets/skripsi/informasi_status', ['jenis' => TAHAPAN_SKRIPSI_UJIAN]); ?>
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
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th style="width: 30%">Skripsi</th>
						<th>Departemen</th>
						<th>Pembimbing</th>
						<th>Status</th>
						<th>Opsi</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($skripsi as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td>
									<?php
										$judul = $this->skripsi->read_judul($list['id_skripsi']);
										echo $judul->judul;
									?>
									<hr class="divider-line-semi-bold"/>
									<b>Berkas</b><br/>
									<?php
										if ($list['turnitin']) {
											?>
											<a href="<?php echo base_url() ?>assets/upload/turnitin/<?php echo $list['turnitin'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
											<?php
										} else {
											echo 'Belum upload';
										}
									?>
									<hr class="divider-line-semi-bold"/>
									<b>TOEFL</b><br/>
									<?php echo $list['toefl'] ?>
									<?php
										if ($list['status_skripsi'] < STATUS_SKRIPSI_UJIAN_SELESAI) {
											?>
											<br/>
											<a class="btn btn-xs bg-orange" style="margin: 5px 0px" href="<?= base_url() ?>dashboardm/modul/skripsi/edit/<?= $list['id_skripsi'] ?>">
												<i class="fa fa-pencil-square"></i> Ubah Judul
											</a>
											<?php
										}
									?>
								</td>
								<td><?= $list['departemen'] ?></td>
								<td>
									<?php
										$pembimbing = $this->skripsi->read_pembimbing($list['id_skripsi']);
										if ($pembimbing) {
											echo $pembimbing->nama . '<br/>' . $pembimbing->nip;
										} else {
											echo 'Belum ada pembimbing';
										}
									?>
								</td>
								<td>
									<?php
										$this->view('backend/widgets/skripsi/column_status', ['skripsi' => $list, 'jenis' => TAHAPAN_SKRIPSI_UJIAN]);
									?>
								</td>
								<td>

									<!-- filter daftar -->
									<?php
										if ($list['status_skripsi'] < STATUS_SKRIPSI_UJIAN_PENGAJUAN) {
											?>
											<b style="text-decoration: underline"> Pengajuan</b><br/>
											<?php
											$jumlah_bimbingan = $this->skripsi->jumlah_bimbingan($list['id_skripsi']);

											//tanggal hari ini
											date_default_timezone_set('Asia/Jakarta');
											$now = date('Y-m-d');

											//tanggal awal bimbingan
											$awal_bimbingans = $this->skripsi->awal_bimbingan($list['id_skripsi']);
											if ($awal_bimbingans) {
												$awal_bimbingan = $awal_bimbingans->tanggal;
											} else {
												$awal_bimbingan = $now;
											}
											//tanggal 2 bulan kedepan
											$batas_true = date('Y-m-d', strtotime('+2 month', strtotime($awal_bimbingan)));

											if ($jumlah_bimbingan >= 8 && $now >= $batas_true && $list['toefl'] != '0' && $list['turnitin'] != '') {
												?>
												<?php echo form_open('dashboardm/modul/skripsi/daftar') ?>
												<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
												<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
												<button type="submit" class="btn btn-xs btn-success pull-left" style="margin: 10px 0px">
													<i class="fa fa-check"></i> Daftar
												</button><br/><br/>
												<?php echo form_close() ?>
												<?php
											}
											if ($list['toefl'] == '0') {
												?>
												<b class="text-danger" style="font-size: 0.8em">- Nilai TOEFL Belum dimasukkan</b><br/>
												<?php
											}
											if ($list['turnitin'] == '') {
												?>
												<b class="text-danger" style="font-size: 0.8em">- Berkas Turnitin belum di upload</b><br/>
												<?php
											}
											if ($jumlah_bimbingan < 8) {
												?>
												<b class="text-danger" style="font-size: 0.8em">- Total bimbingan minimal 8x dan sudah disetujui pembimbing</b>
												<br/>
												<?php

											}
											if ($now < $batas_true) {
												?>
												<b class="text-danger" style="font-size: 0.8em">- Jangka waktu bimbingan awal dan pengajuan minimal 2 bulan</b>
												<br/>
												<?php
											}
											?>
											<hr class="divider-line-semi-bold"/>

											<a class="btn btn-xs btn-primary pull-left" style="margin: 5px 0px" href="<?= base_url() ?>dashboardm/modul/skripsi/syarat/<?= $list['id_skripsi'] ?>">
												<i class="fa fa-folder-open-o"></i> Upload Persyaratan
											</a>
											<?php
										}

									?>
									<?php
										if ($pembimbing) {
											?>
											<a class="btn btn-xs btn-primary pull-left" href="<?= base_url() ?>dashboardm/modul/skripsi/bimbingan/<?= $list['id_skripsi'] ?>">
												<i class="fa fa-calendar"></i> Bimbingan
											</a><br/><br/>
											<?php
										} else {
											?>
											<a class="btn btn-xs btn-danger pull-left" href="#">
												<i class="fa fa-calendar"></i> Pembimbing belum ada
											</a><br/><br/>
											<?php
										}
									?>
									<?php
										$ujian = $this->skripsi->ujian($list['id_skripsi'], $list['nim']);
										if (!empty($ujian)) {
											?>
											<hr class="divider-line-semi-bold"/>
											<a class="btn btn-xs btn-primary pull-left" href="<?= base_url() ?>dashboardm/modul/skripsi/ujian/<?= $list['id_skripsi'] ?>">
												<i class="fa fa-calendar"></i> Ujian
											</a><br/><br/>
											<?php
										}
									?>
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
