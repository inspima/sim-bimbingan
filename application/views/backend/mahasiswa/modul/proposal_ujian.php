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
	<!-- left column -->
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Informasi Proposal</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body">
				<div class="form-group">
					<label>Judul</label><br/>
					<?php
						$judul = $this->proposal->read_judul($proposal->id_skripsi);
						echo $judul->judul;
					?>
				</div>
				<div class="form-group">
					<label>Berkas Proposal</label>
					<p>
						<a href="<?php echo base_url() ?>assets/upload/proposal/<?php echo $proposal->berkas_proposal ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="50px" height="auto"></a>
					</p>
				</div>
				<div class="form-group">
					<label>Status Ujian Proposal</label>
					<p>
						<?php
							if ($proposal->status_ujian_proposal == '0') {
								echo 'Belum ujian';
							} else if ($proposal->status_ujian_proposal == '1') {
								echo 'Layak dan dapat dilanjutkan untuk penulisan skripsi';
							} else if ($proposal->status_ujian_proposal == '2') {
								echo 'Layak dengan catatan perbaikan dan dapat dilanjutkan untuk penulisan skripsi';
							} else if ($proposal->status_ujian_proposal == '3') {
								echo 'Tidak layak dan harus diuji kembali';
							}
						?>
					</p>
				</div>

			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>

	<!-- left column -->
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">1. Jadwal</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body">

				<div class="form-group">
					<label>Tanggal</label>
					<input type="text" name="tanggal" value="<?php echo toindo($ujian->tanggal); ?>" class="form-control pull-right" id="datepicker" readonly>

				</div>

				<div class="form-group">
					<label>Ruang</label>
					<input type="text" name="tanggal" value="<?php echo $ujian->ruang . ' - ' . $ujian->gedung; ?>" class="form-control" readonly>
				</div>

				<div class="form-group">
					<label>Jam</label>
					<input type="text" name="tanggal" value="<?php echo $ujian->jam; ?>" class="form-control" readonly>
				</div>
			</div>
		</div>
		<!-- /.box -->
	</div>

	<!-- left column -->
	<div class="col-md-6">
		<!-- general form elements -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">2. Penguji</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<div class="box-body">
				<div class="form-group">
					<table class="table table-bordered">
						<tr>
							<th>Nama</th>
							<th>Tim</th>
						</tr>
						<?php
							$penguji = $this->proposal->read_penguji($ujian->id_ujian);
							foreach ($penguji as $listpenguji) {
								?>
								<tr>
									<td><?php echo $listpenguji['nama'] ?><br/><?= $listpenguji['nip'] ?>
										<?php
											if ($listpenguji['status'] == '1') {
												echo ' (belum approve)';
											} else {
											}
										?>
									</td>
									<td>
										<?php
											if ($listpenguji['status_tim'] == '1') {
												?>
												<button type="submit" class="btn btn-xs btn-primary"> Ketua</button>
												<?php
											} else if ($listpenguji['status_tim'] == '2') {
												?>
												<button type="submit" class="btn btn-xs btn-primary"> Anggota</button>
												<?php
											}
										?>
									</td>
								</tr>
								<?php
							}
						?>
					</table>
				</div>
			</div>


		</div>
		<!-- /.box -->
	</div>


</div>
