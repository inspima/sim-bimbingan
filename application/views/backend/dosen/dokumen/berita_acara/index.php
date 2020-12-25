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
				<th>Nama Dokumen</th>
				<th>Deskripsi/Judul</th>
				<th class="text-center">Tanggal</th>
				<th class="text-center">Mahasiswa</th>
				<th class="text-center">Berkas</th>
				<th class="text-center">Opsi</th>
			</tr>
			</thead>
			<tbody>
			<?php
				$no = 1;
				foreach ($dokumens as $dokumen) {
					?>
					<tr>
						<td><?= $no ?></td>
						<td><?php echo $dokumen['nama'] ?></td>
						<td><?php echo $dokumen['deskripsi'] ?></td>
						<td class="text-center"><?php echo wday_toindo($dokumen['date']) ?></td>
						<td>
							Nim :<br/><b><?php echo $dokumen['identitas'] ?></b><br/>
							Nama :<br/><b><?php echo $dokumen['nama_mhs'] ?></b>
						</td>
						<td class="text-center">
							<a class="btn btn-xs bg-red-active" href="<?php echo $dokumen['link_cetak'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Lihat</a>
						</td>
						<td>
							<a class="btn btn-xs btn-primary" href="<?php echo base_url() ?>dosen/dokumen/berita_acara/persetujuan/<?php echo $dokumen['id_dokumen'] ?>"><i class="fa fa-check-circle"></i> Persetujuan</a>
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
