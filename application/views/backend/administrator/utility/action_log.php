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
									<?= $list['actor'] ?>
								</td>
								<td>
									<?= $list['description'] ?>
								</td>
								<td>
									<?= waktu_format_indonesia(date('Y-m-d H:i:s', strtotime($list['time']))) ?>
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
