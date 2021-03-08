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

			<!-- /.box-body -->
			<div class="box-body">

				<?php $this->view('backend/widgets/skripsi/tab_link_baa_proposal'); ?>
				<hr/>
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Info Proposal</th>
						<th>Tanggal Pengajuan</th>
						<th>Jadwal</th>
						<th>Dosen Penguji</th>
						<th>Cetak</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($proposal as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td><?php echo '<strong>' . $list['nama'] . '</strong><br>' . $list['nim'] ?></td>
								<td>
									<?php
										$judul = $this->proposal_diterima->read_judul($list['id_skripsi']);
										echo $judul->judul;
									?>
									<a href="<?php echo base_url() ?>assets/upload/proposal/<?php echo $list['berkas_proposal'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
									<hr class="divider-line-semi-bold">
									<b>Departemen</b> : <?php echo $list['departemen'] ?>
									<hr class="divider-line-thin">
									<b>Semester </b> : <?php echo $list['gelombang'] . ' (' . $list['semester'] . ')' ?>
								</td>
								<td><?php echo toindo($list['tgl_pengajuan']) ?></td>
								<td>
									<?php
										$ujian = $this->proposal_diterima->read_ujian($list['id_skripsi']);
										if ($ujian) {
											echo '<strong>Tanggal</strong> :<br>' . toindo($ujian->tanggal) . '<br>';
											echo '<strong>Ruang</strong>  :<br>' . $ujian->ruang . ' ' . $ujian->gedung . '<br>';
											echo '<strong>Jam</strong>     :<br>' . $ujian->jam;
										} else {
											echo '';
										}
									?>
								</td>
								<td>
									<?php
										$penguji = $this->proposal_diterima->read_penguji($list['id_skripsi']);
										$num = 1;
										foreach ($penguji as $show) {
											if ($show['status'] == '1') {
												?>
												<p style="color:red">
													<?php
														echo $num . ' ' . $show['nama'] . '<br>';
													?>
												</p>
												<?php
											} else {
												echo $num . ' ' . $show['nama'] . '<br>';
											}
											$num++;
										}
									?>
								</td>
								<td>
									<?php
										if ($ujian) {
											$ketua = $this->proposal_diterima->read_pengujiketua($list['id_skripsi']);
											if ($ketua) {
												?>
												<?php
												$attributes = array('target' => '_blank');
												echo form_open('dashboardb/proposal/proposal_diterima/cetak_surat_tugas', $attributes)
												?>
												<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
												<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
												<button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-print"></i> Surat Tugas</button>
												<?php echo form_close(); ?>
												<div class="divider5"></div>
												<?php
												$attributes = array('target' => '_blank');
												echo form_open('dashboardb/proposal/proposal_diterima/cetak_undangan', $attributes)
												?>
												<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
												<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
												<button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-print"></i> Undangan</button>
												<?php echo form_close(); ?>
												<div class="divider5"></div>
												<?php
												$attributes = array('target' => '_blank');
												echo form_open('baa/sarjanah/proposal/cetak_berita', $attributes)
												?>
												<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
												<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
												<button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-print"></i> Berita Acara</button>
												<?php echo form_close(); ?>
												<div class="divider5"></div>
												<?php
												$attributes = array('target' => '_blank');
												echo form_open('dashboardb/proposal/proposal_diterima/cetak_absensi', $attributes)
												?>
												<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
												<?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
												<button type="submit" class="btn btn-xs btn-primary"><i class="fa fa-print"></i> Berita Acara Konsumsi</button>
												<?php echo form_close(); ?>
												<?php
											} else {
												echo 'belum set ketua';
											}
										} else {
											echo 'belum setting ujian';
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
		</div>
	</div>
	<!-- /.box -->
</div>
<!-- /.col -->
</div>
