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
					$sudah_publish_semua=$this->disertasi->cek_mkpd_sudah_publish($disertasi->id_disertasi);
					foreach ($disertasi_mkpds as $index => $mkpd) {
						?>
						<tr>
							<td><?= $index + 1 ?>. (<b><?php echo $mkpd['kode'] ?></b>) <?php echo $mkpd['mkpd'] ?></td>
							<td>
								<?php
									$mkpd_pengampus = $this->disertasi->read_disertasi_mkpd_pengampu($mkpd['id_disertasi_mkpd']);
									foreach ($mkpd_pengampus as $index_pengampu => $pengampu):
										?>
										<?= $index_pengampu + 1 ?>. <b><?php echo $pengampu['nama'] ?></b> <br/><i><?php echo $pengampu['nip'] ?></i><br/>
									<?php
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
