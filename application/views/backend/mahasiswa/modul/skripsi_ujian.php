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
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Judul</th>
						<th>Pembimbing</th>
						<th>Gelombang / Semester</th>
						<th>Jadwal</th>
						<th>Penguji</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($skripsi as $list) {
							//$penguji = $this->skripsi->count_penguji_approve($list['id_ujian']);
							//if($penguji < 5)
							//{

							//}
							//else
							//if($penguji == 5)
							//{
							?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $list['nama'] . '<br>' . $list['nim'] ?></td>
								<td><?php
										$judul = $this->skripsi->read_judul($list['id_skripsi']);
										echo $judul->judul;
									?></td>
								<td><?php
										$pembimbing = $this->skripsi->read_pembimbing($list['id_skripsi']);
										echo $pembimbing->nama;
									?></td>
								<td><?= $list['gelombang'] . ' / ' . $list['semester'] ?></td>
								<td>
									<?php
										echo '<strong>Tanggal : </strong>' . toindo($list['tanggal']) . '<br>';
										echo '<strong>Jam     : </strong>' . $list['jam'] . '<br>';
										echo '<strong>Ruang   : </strong>' . $list['ruang'] . ' - ' . $list['gedung'] . '<br>';
									?>
								</td>
								<td>
									<?php
										$penguji = $this->skripsi->read_penguji($list['id_ujian']);

										foreach ($penguji as $show) {
											if($show['status']!='3'){
												if ($show['status_tim'] == '1') {
													$ka = 'ketua';
												} else if ($show['status_tim'] == '2') {
													$ka = 'anggota';
												}

												if ($show['usulan_dosbing'] == '0') {
													$up = '';
												} else if ($show['usulan_dosbing'] == '1') {
													$up = '- usulan pembimbing';
												} else if ($show['usulan_dosbing'] == '2') {
													$up = '- pembimbing';
												}

												if ($show['status'] == '1') {
													$clrs = 'red';
												} else if ($show['status'] == '2') {
													$clrs = 'black';
												}
												echo '<p style="color:' . $clrs . ';line-height: 14px;">' . '- ' . $show['nama'].'<br/><b>' .$show['nip']. '</b><br/> (' . $ka . $up . ')<br>';
												//echo '- '.$show['nama'].'<strong>('.$ka.$up.')</strong><br>';
											}

										}
									?>
								</td>

							</tr>
							<?php
							$no++;
							//}
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
