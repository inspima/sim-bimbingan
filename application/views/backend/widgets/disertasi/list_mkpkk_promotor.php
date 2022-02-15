<?php
	$disertasi_mkpkks = $this->disertasi->read_disertasi_mkpkk($disertasi->id_disertasi);
	if (!empty($disertasi_mkpkks)) {
		?>

		<table class="table table-bordered ">
			<tr class="bg-gray">
				<th>Mata Kuliah</th>
				<th class="text-center">Nilai
					<br/>
					<span class="text-muted">Rata-rata</span>
				</th>
			</tr>
			<?php
				foreach ($disertasi_mkpkks as $index => $mkpkk) {
					?>
					<tr>
						<td>
							<strong style="font-size: 1.2em" class="text-orange"><?= $index + 1 ?>. <?php echo $mkpkk['mkpkk'] ?></strong><br/>
							<hr class="divider-line-semi-bold"/>
							<b class="text-info">Dosen Pengampu</b><br/>
							<?php
								$mkpkk_pengampus = $this->disertasi->read_disertasi_mkpkk_pengampu($mkpkk['id_mkpkk'],$disertasi->id_disertasi);
								foreach ($mkpkk_pengampus as $index_pengampu => $pengampu):
									?>
									<?= $index_pengampu + 1 ?>. <b><?php echo $pengampu['nama'] ?></b>
									<?php
									if ($pengampu['nilai_angka'] != 0) {
										?>
										<strong class="text-success"> - Sudah</strong><br/>
										<?php
									} else {
										?>
										<strong class="text-danger">Belum</strong><br/>
										<?php
									}
									?>
									<i><?php echo $pengampu['nip'] ?></i>
									<br/>
								<?php
								endforeach;
							?>
						</td>
						<td class="text-center">
							<strong style="font-size: 1.2em"><?php echo number_format($mkpkk['nilai_angka'],2) ?><br/></strong>
							<?php
								if($mkpkk['nilai_publish']=='0'){
									?>
									<span class="btn btn-xs btn-danger">Belum Publish</span>
									<?php
								}else{
									?>
									<span class="btn btn-xs btn-success">Sudah Publish</span>
									<?php
								}
							?>
						</td>
					</tr>
					<?php
				}
			?>
		</table>

		<?php
	} else {
		?>
		<div class="form-group">
			<p>Data belum ada</p>
		</div>
		<?php
	}
?>
