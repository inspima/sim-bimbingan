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
<div class="btn-group">
	<a class="<?= ($this->uri->segment(4) == '') ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>dosen/dokumen/berita_acara"><i class="fa fa-check-circle-o"></i> Permintaan</a>
	<a class="<?= ($this->uri->segment(4) == 'riwayat') ? 'btn btn-default' : 'btn bg-yellow'; ?>" href="<?php echo base_url() ?>dosen/dokumen/berita_acara/riwayat"><i class="fa fa-history"></i> Riwayat</a>
</div>
<!-- Split button -->
<div class="btn-group pull-right">
	<button type="button" class="btn bg-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<?php
			if ($this->input->get('jenjang') != '') {
				if($this->input->get('jenjang')==1){
					?>
					Sarjana
					<?php
				}else if($this->input->get('jenjang')==2){
					?>
					Magister
					<?php
				}else if($this->input->get('jenjang')==3){
					?>
					Doktor
					<?php
				}
			} else {
				?>
					Semua Jenjang
				<?php
			}
		?>
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu">
		<?php
			if ($this->input->get('jenjang') != '') {
				?>
				<li><a href="<?=current_url()?>">Semua Jenjang</a></li>
				<?php
			}
		?>
		<li><a href="<?=current_url()?>?jenjang=1">Sarjana</a></li>
		<li><a href="<?=current_url()?>?jenjang=2">Magister</a></li>
		<li><a href="<?=current_url()?>?jenjang=3">Doktor</a></li>
	</ul>
</div>
<div class="divider10"></div>
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
						<td class="text-center">
							<?php
								$setujui_semua = $this->dokumen->cek_dokumen_setujui_semua($dokumen['id_dokumen']);
								if ($setujui_semua) {
									?>
									<button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Selesai</button>
									<a class="btn btn-xs btn-primary" href="<?php echo base_url() ?>dosen/dokumen/berita_acara/persetujuan/<?php echo $dokumen['id_dokumen'] ?>"><i class="fa fa-info"></i> Detail</a>
									<?php
								} else {
									?>
									<a class="btn btn-xs btn-primary" href="<?php echo base_url() ?>dosen/dokumen/berita_acara/persetujuan/<?php echo $dokumen['id_dokumen'] ?>"><i class="fa fa-check-circle"></i> Persetujuan</a>
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
