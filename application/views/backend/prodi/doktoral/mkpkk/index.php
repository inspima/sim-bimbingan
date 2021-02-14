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
<?php $this->view('backend/widgets/disertasi/tab_link_admin_prodi'); ?>
<div class="divider10"></div>
<?php $this->view('backend/widgets/disertasi/informasi_status', ['jenis' => TAHAPAN_DISERTASI_MPKK]); ?>
<div class="box">

	<!-- /.box-header -->
	<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
			<tr>
				<th>No</th>
				<th>Disertasi</th>
				<th class="text-center">Berkas</th>
				<th class="text-center">MKPKK</th>
				<th class="text-center">Opsi</th>
			</tr>
			</thead>
			<tbody>
			<?php
				$no = 1;
				foreach ($disertasi as $list) {
					?>
					<tr>
						<td><?= $no ?></td>
						<td>
							<?php echo '<strong>' . $list['nama'] . '</strong><br>' . $list['nim'] ?>
							<br/>
							<b>Judul</b> <br/>
							<?php
								echo $list['judul']
							?>
						</td>
						<td class="text-center">
							<a href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/mpkk/<?php echo $list['berkas_mpkk'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto">
							</a>
						</td>
						<td>
							<?php $this->view('backend/widgets/disertasi/column_mkpkk_prodi', ['disertasi' => $list, 'id_disertasi' => $list['id_disertasi']]); ?>
						</td>
						<td class="text-center">
							<?php $this->view('backend/widgets/disertasi/column_status', ['disertasi' => $list, 'jenis' => TAHAPAN_DISERTASI_MPKK]); ?>

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
