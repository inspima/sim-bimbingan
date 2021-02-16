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

	<!-- /.box-header -->
	<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Nim</th>
				<th>Prodi</th>
				<th>SKS</th>
				<th>Alamat</th>
				<th>Email</th>
				<th>Berkas</th>
				<th class="text-center">Opsi</th>
			</tr>
			</thead>
			<tbody>
			<?php
				$no = 1;
				foreach ($mahasiswas as $mahasiswa) {
					?>
					<tr>
						<td><?= $no ?></td>
						<td><?php echo $mahasiswa['nama'] ?></td>
						<td><?php echo $mahasiswa['nim'] ?></td>
						<td><?php echo $mahasiswa['jenjang'] ?><?php echo $mahasiswa['nm_prodi'] ?></td>
						<td><?php echo $mahasiswa['sks'] ?></td>
						<td><?php echo $mahasiswa['alamat'] ?></td>
						<td><?php echo $mahasiswa['email'] ?></td>
						<td>
							<?php
								if (!empty($mahasiswa['berkas_verifikasi'])) {
									?>
									<a class="btn btn-xs bg-red-active" href="<?php echo base_url() ?>assets/upload/mahasiswa/verifikasi/<?php echo $mahasiswa['berkas_verifikasi'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Berkas</a>
									<?php
								} else {
									?>
									<label class="text-danger text-sm">Berkas belum di upload</label>
									<?php
								}
							?>

						</td>
						<td class="text-center">
							<?php echo form_open('baa/utility/registrasi/verifikasi') ?>
							<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
							<?php echo formtext('hidden', 'id_user', $mahasiswa['id_user'], 'required') ?>
							<?php echo formtext('hidden', 'nama', $mahasiswa['nama'], 'required') ?>
							<?php echo formtext('hidden', 'nim', $mahasiswa['nim'], 'required') ?>
							<?php echo formtext('hidden', 'email', $mahasiswa['email'], 'required') ?>
							<button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses Setujui</button>
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
