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
				<?php $this->view('backend/widgets/skripsi/tab_link_kadep_proposal'); ?>
				<hr/>
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Info Proposal</th>
						<th>Departemen</th>
						<th>Tanggal Pengajuan</th>
						<th>Semester</th>
						<th>-</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($proposal as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td>
									<b>Nim</b> : <?= $list['nim'] ?><br/>
									<b>Nama</b> : <?= $list['nama'] ?><br/>
									<b>Judul</b> : <?= $list['judul']; ?><br/>
									<b>Berkas</b> :
									<a href="<?php echo base_url() ?>assets/upload/proposal/<?php echo $list['berkas_proposal'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
								</td>
								<td><?php echo $list['departemen'] ?></td>
								<td><?php echo toindo($list['tgl_pengajuan']) ?></td>
								<td><?= $list['semester'] ?></td>
								<td>
									<?
										$ujian_ulang = $this->skripsi->read_ujian_ulang($list['id_skripsi'], UJIAN_SKRIPSI_PROPOSAL);
										if (!empty($ujian_ulang)) {
											?>
											<a class="btn btn-xs btn-primary pull-left" href="<?= base_url() ?>dosen/sarjana/kadep/proposal/plot/<?= $list['id_skripsi'] ?>?is_ulang=1">
												<i class="fa fa-gear"></i> Jadwal & Penguji
											</a>
											<?php
										} else {
											echo 'Jadwal Ujian Ulang belum ada';
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
