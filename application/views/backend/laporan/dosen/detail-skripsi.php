<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header bg-primary ">
				<h3 class="box-title" style="color: white">Informasi Dosen</h3>
				<div class="pull-right">
				</div>
			</div>
			<div class="box-body">
				<table class="table table-condensed">
					<tr>
						<td style="width: 15%">Nama</td>
						<td><b><?=$pegawai->nama ?></b></td>
					</tr>
					<tr>
						<td>NIP</td>
						<td><b><?=$pegawai->nip ?></b></td>
					</tr>
					<tr>
						<td>Sebagai</td>
						<td><b><?=$sebagai ?></b></td>
					</tr>
				</table>
			</div>

		</div>
		<!-- /.box -->
	</div>
	<!-- /.col -->
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="box">
			<div class="box-body">

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
						foreach ($laporans as $list) {
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

									<?php $this->view('backend/widgets/common/tahapan_tugas_akhir', ['mahasiswa' => $list]); ?><br/><br/>
									<?php $this->view('backend/widgets/common/status_tugas_akhir', ['mahasiswa' => $list]); ?>
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
