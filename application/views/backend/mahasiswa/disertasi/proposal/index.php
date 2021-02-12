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
<?php $this->view('backend/widgets/disertasi/informasi_status', ['jenis' => TAHAPAN_DISERTASI_PROPOSAL]); ?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Tabel <?= $subtitle ?></h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
			<tr>
				<th>No</th>
				<th style="width: 30%">Judul</th>
				<th class="text-center">Berkas</th>
				<th>Tanggal Pengajuan</th>
				<th class="text-center">Status</th>
				<th class="text-center">Info</th>
			</tr>
			</thead>
			<tbody>
			<?php
				$no = 1;
				foreach ($disertasi as $list) {
					?>
					<tr>
						<td><?= $no ?></td>
						<td><?php
								$judul = $this->disertasi->read_judul($list['id_disertasi']);
								echo $judul->judul;
							?>
						</td>
						<td class="text-center">
							<?php $attributes = array('target' => '_blank'); ?>
							<?php echo form_open('mahasiswa/disertasi/proposal/cetak-pengajuan', $attributes) ?>
							<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
							<?php echo formtext('hidden', 'id_disertasi', $list['id_disertasi'], 'required') ?>
							<button type="submit" class="btn btn-xs bg-red-active"><i class="fa fa-print"></i> Form Pengajuan</button>
							<?php echo form_close() ?>
							<?php echo generateNewLineHTML(2) ?>
							<a href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/proposal/<?php echo $list['berkas_proposal'] ?>" target="_blank" class="btn btn-xs bg-red-active">
								<i class="fa fa-print"></i> Berkas Syarat
							</a>
						</td>
						<td><?= woday_toindo($list['waktu_pengajuan_proposal']) ?></td>
						<td class="text-center">
							<?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => 1]); ?>

							<?php if ($list['status_proposal'] >= STATUS_DISERTASI_PROPOSAL_SELESAI) {
								?>
								<hr style="margin:5px"/>
								<b>Hasil Ujian</b><br/>
								<?php
								echo $this->disertasi->get_status_ujian($list['status_ujian_proposal'], UJIAN_DISERTASI_PROPOSAL);

								if ($list['status_mkpd'] == 0) {
									?>
									<hr style="margin:5px"/>
									<a href="<?= base_url() ?>mahasiswa/disertasi/mkpd/add/<?= $list['id_disertasi'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-mail-forward"></i> Ajukan MKPD</a>
									<?php
								}
							}
							?>

						</td>
						<td class="text-center">
							<?php if ($list['status_proposal'] > STATUS_DISERTASI_PROPOSAL_DIJADWALKAN) {
								?>
								<a href="<?= base_url() ?>mahasiswa/disertasi/proposal/info/<?= $list['id_disertasi'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-info-circle"></i> Detail</a>
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
