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
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Tabel Permintaan Validasi Jurnal</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
			<tr>
				<th>No</th>
				<th>Mahasiswa</th>
				<th style="width: 25%">Judul</th>
				<th>Berkas</th>
				<th class="text-center">Status Validasi</th>
				<th class="text-center">Aksi</th>
			</tr>
			</thead>
			<tbody>
			<?php
				$no = 1;
				foreach ($data

						 as $d) {
					?>
					<tr>
						<td><?= $no ?></td>
						<td>
							NIM : <b><?= $d['nim'] ?></b><br/>
							NAMA : <b><?= $d['nama'] ?></b><br/>
						</td>
						<td><?= $d['judul'] ?></td>
						<td>
							<a class="btn btn-xs bg-red-active" href="<?php echo base_url() ?>assets/upload/mahasiswa/jurnal/<?php echo $d['berkas_jurnal'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Berkas Jurnal</a>
						</td>
						<td class="text-center">
							<?php
								if ($d['status'] == '0') {
									?>
									<span class="label bg-orange">Belum</span>
									<?php
								} else if ($d['status'] == '1') {
									?>
									<span class="label bg-green">Sudah</span>
									<?php
								}
							?>
						</td>
						<td class="text-center">
							<?php
								if ($d['status'] == 0) {
									?>
									<?php echo form_open('up4i/doktoral/jurnal/validasi') ?>
									<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
									<?php echo formtext('hidden', 'id_jurnal', $d['id_jurnal'], 'required') ?>
									<?php echo formtext('hidden', 'id_disertasi', $d['id_tugas_akhir'], 'required') ?>
									<button type="submit" class="btn btn-xs bg-green-active"><i class="glyphicon glyphicon-check"></i> Proses Validasi</button>
									<?php echo form_close() ?>
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
