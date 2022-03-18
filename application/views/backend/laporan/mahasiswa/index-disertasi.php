<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title"><?= $subtitle ?></h3>
				<div class="pull-right">
				</div>
			</div>

		</div>
		<!-- /.box -->
	</div>
	<!-- /.col -->
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><span class="label label-primary" style="margin-right: 5px;font-size: 13px"><?=count($kualifikasis)?></span> Kualifikasi </a></li>
				<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><span class="label label-primary" style="margin-right: 5px;font-size: 13px"><?=count($promotors)?></span> Promotor</a></li>
				<li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><span class="label label-primary" style="margin-right: 5px;font-size: 13px"><?=count($mpkks)?></span> MKPKK</a></li>
				<li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false"><span class="label label-primary" style="margin-right: 5px;font-size: 13px"><?=count($proposals)?></span> Proposal</a></li>
				<li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false"><span class="label label-primary" style="margin-right: 5px;font-size: 13px"><?=count($mkpds)?></span> MKPD</a></li>
				<li class=""><a href="#tab_6" data-toggle="tab" aria-expanded="false"><span class="label label-primary" style="margin-right: 5px;font-size: 13px"><?=count($kelayakans)?></span> Kelayakan</a></li>
				<li class=""><a href="#tab_7" data-toggle="tab" aria-expanded="false"><span class="label label-primary" style="margin-right: 5px;font-size: 13px"><?=count($tertutups)?></span> Tertutup</a></li>
				<li class=""><a href="#tab_8" data-toggle="tab" aria-expanded="false"><span class="label label-primary" style="margin-right: 5px;font-size: 13px"><?=count($terbukas)?></span> Terbuka</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
					<table class="datatable-report table table-bordered table-striped">
						<thead>
						<tr>
							<th>No</th>
							<th>Disertasi</th>
							<th>Tgl.Pengajuan</th>
							<th class="text-center">Opsi</th>
						</tr>
						</thead>
						<tbody>
						<?php
							$no = 1;
							foreach ($kualifikasis as $list) {
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
									<td><?php echo toindo($list['tgl_pengajuan']) ?></td>
									<td class="text-center">
										<?php $this->view('backend/widgets/common/tahapan_tugas_akhir', ['mahasiswa' => $list]); ?><br/><br/>
										<?php $this->view('backend/widgets/common/status_tugas_akhir', ['mahasiswa' => $list]); ?>

									</td>
								</tr>
								<?php
								$no++;
							}
						?>
					</table>
				</div>

				<div class="tab-pane" id="tab_2">

					<table class="datatable-report table table-bordered table-striped">
						<thead>
						<tr>
							<th>No</th>
							<th>Disertasi</th>
							<th>Tgl.Pengajuan</th>
							<th class="text-center">Opsi</th>
						</tr>
						</thead>
						<tbody>
						<?php
							$no = 1;
							foreach ($promotors as $list) {
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
									<td><?php echo toindo($list['tgl_pengajuan']) ?></td>
									<td class="text-center">
										<?php $this->view('backend/widgets/common/tahapan_tugas_akhir', ['mahasiswa' => $list]); ?><br/><br/>
										<?php $this->view('backend/widgets/common/status_tugas_akhir', ['mahasiswa' => $list]); ?>

									</td>
								</tr>
								<?php
								$no++;
							}
						?>
					</table>
				</div>

				<div class="tab-pane" id="tab_3">

					<table class="datatable-report table table-bordered table-striped">
						<thead>
						<tr>
							<th>No</th>
							<th>Disertasi</th>
							<th>Tgl.Pengajuan</th>
							<th class="text-center">Opsi</th>
						</tr>
						</thead>
						<tbody>
						<?php
							$no = 1;
							foreach ($mpkks as $list) {
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
									<td><?php echo toindo($list['tgl_pengajuan']) ?></td>
									<td class="text-center">
										<?php $this->view('backend/widgets/common/tahapan_tugas_akhir', ['mahasiswa' => $list]); ?><br/><br/>
										<?php $this->view('backend/widgets/common/status_tugas_akhir', ['mahasiswa' => $list]); ?>

									</td>
								</tr>
								<?php
								$no++;
							}
						?>
					</table>
				</div>

				<div class="tab-pane" id="tab_4">

					<table class="datatable-report table table-bordered table-striped">
						<thead>
						<tr>
							<th>No</th>
							<th>Disertasi</th>
							<th>Tgl.Pengajuan</th>
							<th class="text-center">Opsi</th>
						</tr>
						</thead>
						<tbody>
						<?php
							$no = 1;
							foreach ($proposals as $list) {
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
									<td><?php echo toindo($list['tgl_pengajuan']) ?></td>
									<td class="text-center">
										<?php $this->view('backend/widgets/common/tahapan_tugas_akhir', ['mahasiswa' => $list]); ?><br/><br/>
										<?php $this->view('backend/widgets/common/status_tugas_akhir', ['mahasiswa' => $list]); ?>

									</td>
								</tr>
								<?php
								$no++;
							}
						?>
					</table>
				</div>

				<div class="tab-pane" id="tab_5">

					<table class="datatable-report table table-bordered table-striped">
						<thead>
						<tr>
							<th>No</th>
							<th>Disertasi</th>
							<th>Tgl.Pengajuan</th>
							<th class="text-center">Opsi</th>
						</tr>
						</thead>
						<tbody>
						<?php
							$no = 1;
							foreach ($mkpds as $list) {
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
									<td><?php echo toindo($list['tgl_pengajuan']) ?></td>
									<td class="text-center">
										<?php $this->view('backend/widgets/common/tahapan_tugas_akhir', ['mahasiswa' => $list]); ?><br/><br/>
										<?php $this->view('backend/widgets/common/status_tugas_akhir', ['mahasiswa' => $list]); ?>

									</td>
								</tr>
								<?php
								$no++;
							}
						?>
					</table>
				</div>

				<div class="tab-pane" id="tab_6">

					<table class="datatable-report table table-bordered table-striped">
						<thead>
						<tr>
							<th>No</th>
							<th>Disertasi</th>
							<th>Tgl.Pengajuan</th>
							<th class="text-center">Opsi</th>
						</tr>
						</thead>
						<tbody>
						<?php
							$no = 1;
							foreach ($kelayakans as $list) {
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
									<td><?php echo toindo($list['tgl_pengajuan']) ?></td>
									<td class="text-center">
										<?php $this->view('backend/widgets/common/tahapan_tugas_akhir', ['mahasiswa' => $list]); ?><br/><br/>
										<?php $this->view('backend/widgets/common/status_tugas_akhir', ['mahasiswa' => $list]); ?>

									</td>
								</tr>
								<?php
								$no++;
							}
						?>
					</table>
				</div>

				<div class="tab-pane" id="tab_7">

					<table class="datatable-report table table-bordered table-striped">
						<thead>
						<tr>
							<th>No</th>
							<th>Disertasi</th>
							<th>Tgl.Pengajuan</th>
							<th class="text-center">Opsi</th>
						</tr>
						</thead>
						<tbody>
						<?php
							$no = 1;
							foreach ($tertutups as $list) {
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
									<td><?php echo toindo($list['tgl_pengajuan']) ?></td>
									<td class="text-center">
										<?php $this->view('backend/widgets/common/tahapan_tugas_akhir', ['mahasiswa' => $list]); ?><br/><br/>
										<?php $this->view('backend/widgets/common/status_tugas_akhir', ['mahasiswa' => $list]); ?>

									</td>
								</tr>
								<?php
								$no++;
							}
						?>
					</table>
				</div>

				<div class="tab-pane" id="tab_8">

					<table class="datatable-report table table-bordered table-striped">
						<thead>
						<tr>
							<th>No</th>
							<th>Disertasi</th>
							<th>Tgl.Pengajuan</th>
							<th class="text-center">Opsi</th>
						</tr>
						</thead>
						<tbody>
						<?php
							$no = 1;
							foreach ($terbukas as $list) {
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
									<td><?php echo toindo($list['tgl_pengajuan']) ?></td>
									<td class="text-center">
										<?php $this->view('backend/widgets/common/tahapan_tugas_akhir', ['mahasiswa' => $list]); ?><br/><br/>
										<?php $this->view('backend/widgets/common/status_tugas_akhir', ['mahasiswa' => $list]); ?>

									</td>
								</tr>
								<?php
								$no++;
							}
						?>
					</table>
				</div>

			</div>

		</div>
	</div>
</div>
