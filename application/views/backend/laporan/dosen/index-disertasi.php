<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<!-- /.box-header -->
			<div class="box-body table-responsive">
				<table class="datatable-report table table-bordered">
					<thead>
					<tr>
						<th rowspan="2" class="text-center" style="vertical-align: middle">Dosen</th>
						<th rowspan="2" class="text-center">Penasehat</th>
						<th colspan="3" class="text-center">Promotor</th>
						<th colspan="3" class="text-center">Penguji</th>
					</tr>
					<tr>
						<th class="text-center">Utama</th>
						<th class="text-center">Anggota</th>
						<th class="text-center">Total</th>
						<th class="text-center">Utama</th>
						<th class="text-center">Anggota</th>
						<th class="text-center">Total</th>
					</tr>
					</thead>
					<tbody>
					<?php
						foreach ($laporans as $laporan) {
							?>
							<tr>
								<td>
									<?= $laporan['nama'] ?>
									<br/>
									<b><?= $laporan['nip'] ?></b>
								</td>
								<td class="text-center">
									<?php
										if ($laporan['penasehat'] > 0) {
											?>
											<a href="<?=base_url()?>laporan/dosen/disertasi/detail/<?=$laporan['nip']?>?tipe=penasehat" class="btn btn-xs btn-primary"><b><?= $laporan['penasehat'] ?></b></a>
											<?php
										} else {
											?>
											<b class="label label-default"><?= $laporan['penasehat'] ?></b>
											<?php
										}
									?>
								</td>
								<td class="text-center">
									<?php
										if ($laporan['promotor'] > 0) {
											?>
											<a href="<?=base_url()?>laporan/dosen/disertasi/detail/<?=$laporan['nip']?>?tipe=promotor" class="btn btn-xs btn-primary"><b><?= $laporan['promotor'] ?></b></a>
											<?php
										} else {
											?>
											<b class="label label-default"><?= $laporan['promotor'] ?></b>
											<?php
										}
									?>
								</td>

								<td class="text-center">
									<?php
										if ($laporan['co_promotor'] > 0) {
											?>
											<a href="<?=base_url()?>laporan/dosen/disertasi/detail/<?=$laporan['nip']?>?tipe=co_promotor" class="btn btn-xs btn-primary"><b><?= $laporan['co_promotor'] ?></b></a>
											<?php
										} else {
											?>
											<b class="label label-default"><?= $laporan['co_promotor'] ?></b>
											<?php
										}
									?>
								</td>
								<td class="text-center">
									<b class="label label-success " style="padding: 2px 4px;font-size: 13px"><?= $laporan['promotor']+$laporan['co_promotor'] ?></b>
								</td>

								<td class="text-center">
									<?php
										if ($laporan['penguji_utama'] > 0) {
											?>
											<a href="<?=base_url()?>laporan/dosen/disertasi/detail/<?=$laporan['nip']?>?tipe=penguji_utama" class="btn btn-xs btn-primary"><b><?= $laporan['penguji_utama'] ?></b></a>
											<?php
										} else {
											?>
											<b class="label label-default"><?= $laporan['penguji_utama'] ?></b>
											<?php
										}
									?>
								</td>

								<td class="text-center">
									<?php
										if ($laporan['penguji_anggota'] > 0) {
											?>
											<a href="<?=base_url()?>laporan/dosen/disertasi/detail/<?=$laporan['nip']?>?tipe=penguji_anggota" class="btn btn-xs btn-primary"><b><?= $laporan['penguji_anggota'] ?></b></a>
											<?php
										} else {
											?>
											<b class="label label-default"><?= $laporan['penguji_anggota'] ?></b>
											<?php
										}
									?>
								</td>
								<td class="text-center">
									<b class="label label-success " style="padding: 2px 4px;font-size: 13px"><?= $laporan['penguji_utama']+$laporan['penguji_anggota'] ?></b>
								</td>
							</tr>
							<?php
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
