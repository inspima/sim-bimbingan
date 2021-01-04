<?php
	$disertasi_mkpds = $this->disertasi->read_disertasi_mkpd($disertasi->id_disertasi);
	if (!empty($disertasi_mkpds)) {
		?>
		<div class="form-group">
			<table class="table table-bordered ">
				<tr class="bg-gray">
					<th>Mata Kuliah</th>
					<th>Pengampu</th>
					<th class="text-center">Nilai</th>
				</tr>
				<?php
					$sudah_publish_semua = $this->disertasi->cek_mkpd_sudah_publish($disertasi->id_disertasi);
					foreach ($disertasi_mkpds as $index => $mkpd) {
						$sudah_ada_pjmk = $this->disertasi->cek_mkpd_ada_pjmk($mkpd['id_disertasi_mkpd']);
						?>
						<tr>
							<td><?= $index + 1 ?>. (<b><?php echo $mkpd['kode'] ?></b>) <?php echo $mkpd['mkpd'] ?></td>
							<td>
								<?php
									$mkpd_pengampus = $this->disertasi->read_disertasi_mkpd_pengampu($mkpd['id_disertasi_mkpd']);
									foreach ($mkpd_pengampus as $index_pengampu => $pengampu):
										?>
										<?= $index_pengampu + 1 ?>. <b><?php echo $pengampu['nama'] ?></b>
										<?php
										if ($pengampu['pjmk'] == '1'):
											?>
											<span class="label label-primary">PJMA</span>
										<?php
										endif;
										?>
										<br/>
										<i><?php echo $pengampu['nip'] ?></i><br/>
										<?php
										if (!$sudah_ada_pjmk):
											?>
											<?php echo form_open('dosen/disertasi/permintaan/promotor/mkpd/set_pjmk') ?>
											<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
											<?php echo formtext('hidden', 'id_disertasi_mkpd_pengampu', $pengampu['id_disertasi_mkpd_pengampu'], 'required') ?>
											<button class="btn btn-xs btn-primary">
												<i class="fa fa-user-circle-o"></i> Set PJMA
											</button
											><br/>
											<?= form_close() ?>
										<?
										endif;
									endforeach;
								?>
							</td>
							<td class="text-center">
								<?php
									if ($sudah_publish_semua) {
										?>
										<strong style="font-size: 1.2em"><?php echo $mkpd['nilai_angka'] ?></strong>
										<?php
									} else {
										?>
										<div class="btn btn-xs btn-danger">Belum Di Publish</div>
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

		<?php
	} else {
		?>
		<div class="form-group">
			<p>Data belum ada</p>
		</div>
		<?php
	}
?>
