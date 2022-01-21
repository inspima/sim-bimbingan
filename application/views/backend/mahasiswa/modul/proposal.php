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
<?php $this->view('backend/widgets/skripsi/informasi_status', ['jenis' => TAHAPAN_SKRIPSI_PROPOSAL]); ?>
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title"><?= $subtitle ?></h3>
				<div class="pull-right">
					<a class="btn btn-primary" href="<?= base_url() ?>dashboardm/modul/proposal/add">
						<i class="fa fa-plus"></i> Pengajuan Proposal
					</a>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Judul</th>
						<th>Departemen</th>
						<th>Pekan & Gelombang</th>
						<th>Tgl. Pengajuan</th>
						<th>Status</th>
						<th>Opsi</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($proposal as $list) {
							$judul = $this->proposal->read_judul($list['id_skripsi']);

							?>
							<tr>
								<td><?= $no ?></td>
								<td>
									<?php
										echo $judul->judul;
									?>
									<?php
										if ($judul->persetujuan == 2) {
											?>
											<div class="text-danger">
												Judul anda ditolak, Komentar : <b><?= $judul->persetujuan_keterangan ?></b><br/>
												Silahkan ganti melalui fitur edit
											</div>
											<?
										}
									?>
									<hr class="divider-line-semi-bold"/>
									<b>Berkas</b> <br/>
									<a href="<?php echo base_url() ?>assets/upload/proposal/<?php echo $list['berkas_proposal'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
								</td>
								<td><?= $list['departemen'] ?></td>
								<td>
									<?= !empty($list['nama_pekan']) ? $list['nama_pekan'] . '<hr/>' : '' ?>

									<?= $list['semester'] . ' (' . $list['gelombang'] . ')' ?>
								</td>
								<td><?= woday_toindo($list['tgl_pengajuan']) ?></td>
								<td>
									<?php $this->view('backend/widgets/skripsi/column_status', ['skripsi' => $list, 'jenis' => TAHAPAN_SKRIPSI_PROPOSAL]); ?>
								</td>
								<td class="text-center">
									<?php
										if ($list['status_proposal'] == STATUS_SKRIPSI_PROPOSAL_PENGAJUAN) {
											?>
											<a class="btn btn-xs btn-warning" href="<?= base_url() ?>dashboardm/modul/proposal/edit/<?= $list['id_skripsi'] ?>">
												<i class="fa fa-edit"></i> Edit
											</a><br/><br/>
											<?php
										}
									?>

									<a class="btn btn-xs btn-social btn-primary" href="<?= base_url() ?>dashboardm/modul/proposal/ujian/<?= $list['id_skripsi'] ?>">
										<i class="fa fa-calendar"></i> Detail Ujian
									</a>
<!--									--><?php
//										if ($list['status_proposal'] == STATUS_SKRIPSI_PROPOSAL_SELESAI) {
//											?>
<!--											<br/><br/>-->
<!--											<a class="btn btn-xs btn-social btn-vk" href="--><?//= base_url() ?><!--dashboardm/modul/proposal/revisi/--><?//= $list['id_skripsi'] ?><!--">-->
<!--												<i class="fa fa-edit"></i> Bimbingan Revisi-->
<!--											</a><br/>-->
<!--											--><?php
//										}
//									?>
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
