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
				<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><span class="label label-primary" style="margin-right: 5px;font-size: 13px"><?=count($proposals)?></span> Proposal </a></li>
				<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><span class="label label-primary" style="margin-right: 5px;font-size: 13px"><?=count($ujians)?></span> Ujian Skripsi</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
					<table class="datatable-report table table-bordered table-striped">
						<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Judul</th>
							<th class="text-center">Status</th>
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
										<?= $list['nama'] ?><br><strong><?= $list['nim'] ?></strong>

									</td>
									<td>
										<?= $list['judul'] ?>
										<br/>

										<hr class="divider-line-thin"/>
										<b class="text-primary">Departemen</b><br/>
										<?php echo $list['departemen'] ?>
										<hr class="divider-line-thin"/>
										<b class="text-primary">Gelombang</b><br/>
										<?= $list['gelombang'] . ' (' . $list['semester'] . ')' ?>
									</td>
									<td>
										<p class="text-center">
											<?php $this->view('backend/widgets/skripsi/column_status', [
													'skripsi' => $list,
													'jenis' => TAHAPAN_SKRIPSI_PROPOSAL
											]);
											?>
											<br/>
										</p>
									</td>
								</tr>
								<?php
								$no++;
							}
						?>
						</tfoot>
					</table>
				</div>

				<div class="tab-pane" id="tab_2">

					<table class="datatable-report table table-bordered table-striped">
						<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Judul</th>
							<th class="text-center">Status & Ujian</th>
						</tr>
						</thead>
						<tbody>
						<?php
							$no = 1;
							foreach ($ujians as $list) {
								?>
								<tr>
									<td><?= $no ?></td>
									<td>
										<?php $this->view('backend/widgets/skripsi/column_mahasiswa', [
												'skripsi' => $list,
												'jenis' => TAHAPAN_SKRIPSI_UJIAN
										]);
										?>
									</td>
									<td>
										<?php $this->view('backend/widgets/skripsi/column_pengajuan', [
												'skripsi' => $list,
												'jenis' => TAHAPAN_SKRIPSI_UJIAN
										]);
										?>
									</td>
									<td>
										<p class="text-center">
											<?php $this->view('backend/widgets/skripsi/column_status', [
													'skripsi' => $list,
													'jenis' => TAHAPAN_SKRIPSI_UJIAN
											]);
											?>
											<br/>
										</p>
									</td>
								</tr>
								<?php
								$no++;
							}
						?>
						</tfoot>
					</table>
				</div>


			</div>

		</div>
	</div>
</div>
