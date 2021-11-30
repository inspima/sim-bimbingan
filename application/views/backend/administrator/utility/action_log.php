<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title"><?= $title ?></h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
					<tr>
						<th>No</th>
						<th>Aktor</th>
						<th>Keterangan</th>
						<th>Waktu</th>
						<th>IP & Perangkat</th>
					</tr>
					</thead>
					<tbody>
					<?php
						$no = 1;
						foreach ($logs as $list) {
							?>
							<tr>
								<td><?= $no ?></td>
								<td>
									NIP/NIK : <br/><b><?= $list['actor'] ?></b><br/>
									NAMA : <br/><b><?= $list['nama'] ?></b>
								</td>
								<td>
									<?= $list['description'] ?>
								</td>
								<td>
									<b><?= waktu_format_indonesia(date('Y-m-d H:i:s', strtotime($list['time']))) ?></b>
								</td>
								<td>
									IP : <span class="text-danger"><?= $list['ip_address'] ?></span><br/>
									<span class="text-muted"><?= $list['device'] ?></span>
								</td>
							</tr>
							<?php
							$no++;
						}
					?>
					</tbody>
				</table>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
	<!-- /.col -->
</div>
