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
						<th>NIM</th>
						<th>Nama</th>
						<th>Judul</th>
						<th>Berkas Proposal</th>
						<th>Departemen</th>
						<th>Tanggal Pengajuan</th>
						<th>Semester</th>
						<th>Opsi</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($proposal as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $list['nim'] ?></td>
								<td><?= $list['nama'] ?></td>
								<td><?= $list['judul']; ?></td>
								<td>
									<a href="<?php echo base_url() ?>assets/upload/proposal/<?php echo $list['berkas_proposal'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
								</td>
								<td><?php echo $list['departemen'] ?></td>
								<td><?php echo toindo($list['tgl_pengajuan']) ?></td>
								<td><?= $list['semester'] ?></td>
								<td>
									<a class="btn btn-xs btn-warning pull-left" href="<?= base_url() ?>dosen/sarjana/kadep/proposal/edit/<?= $list['id_skripsi'] ?>">
										<i class="fa fa-edit"></i> Proses
									</a>
									<a class="btn btn-xs btn-primary pull-left" href="<?= base_url() ?>dosen/sarjana/kadep/proposal/plot/<?= $list['id_skripsi'] ?>">
										<i class="fa fa-gear"></i> Setting Ujian
									</a>
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
