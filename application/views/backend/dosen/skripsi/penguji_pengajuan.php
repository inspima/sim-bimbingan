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
						<th>Status Tim</th>
						<th>Tanggal</th>
						<th>Jam</th>
						<th>Ruang</th>
						<th>Opsi</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($penguji as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td><?= $list['nama'] . '<br>(' . $list['nim'] . ')' ?></td>
								<td>
									<?php
										echo $list['judul']
									?>
								</td>
								<td>
									<?php
										if ($list['status_tim'] == '1') {
											echo 'Ketua';
										} else if ($list['status_ti