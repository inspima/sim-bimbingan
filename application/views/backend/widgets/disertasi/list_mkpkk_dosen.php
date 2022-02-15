<?php
	$disertasi_mkpkks = $this->disertasi->read_disertasi_mkpkk($disertasi->id_disertasi);
	if (!empty($disertasi_mkpkks)) {
		?>

		<table class="table table-bordered ">
			<tr class="bg-gray">
				<th>Mata Kuliah</th>
				<th class="text-center" style="width: 150px">
					Nilai<br/>
					<span class="text-muted">Rata-rata</span>
				</th>
			</tr>
			<?php
				foreach ($disertasi_mkpkks as $index => $mkpkk) {
					?>
					<tr>
						<td>
							<h4 style="font-weight: bold;font-size: 1.2em" class="text-orange"><?= $index + 1 ?>.<?php echo $mkpkk['mkpkk'] ?></h4>
							<hr class="divider-line-semi-bold"/>
							<b class="text-info">Dosen Pengampu</b><br/>
							<?php
								$mkpkk_pengampus = $this->disertasi->read_disertasi_mkpkk_pengampu($mkpkk['id_mkpkk'],$disertasi->id_disertasi);
								foreach ($mkpkk_pengampus as $index_pengampu => $pengampu):
									?>
									<?= $index_pengampu + 1 ?>.
									<?php $pengampu_pjmk =$this->disertasi->cek_mkpkk_pengampu_pjmk($mkpkk['id_mkpkk'],$pengampu['nip']);									?>
									<?php echo $pengampu_pjmk?'<b>(PJMK)</b>':'' ?>
									<?php
									if ($pengampu['nip'] == $this->session_data['username']) {
										?>
										<b><?php echo $pengampu['nama'] ?></b>
										<?php
									} else {
										?>
										<?php echo $pengampu['nama'] ?>
										<?php
									}
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
									<i><?php echo $pengampu['nip'] ?></i><br/>
									<?php


									if ($pengampu['nip'] == $this->session_data['username']) {
										?>
										<hr class="divider-line-semi-bold" style="width: 35%"/>
										<?php echo form_open('dosen/disertasi/penilaian/mkpkk/save') ?>
										<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
										<?php echo formtext('hidden', 'id_disertasi_mkpkk_pengampu', $pengampu['id_disertasi_mkpkk_pengampu'], 'required') ?>
										<span>Nilai Angka</span>
										<input type="text" name="nilai_angka" value="<?php echo $pengampu['nilai_angka'] ?>" size="2" max="100" maxlength="3">
										<button type="submit" class="btn btn-xs btn-success">
											<i class="fa fa-check"></i> Simpan
										</button>
										<?php echo form_close(); ?>
										<hr class="divider-line-semi-bold" style="width: 35%"/>
										<?php
									}
								endforeach;
							?>
						</td>
						<td class="text-center">
							<?php
								$pengampu_pjmk =$this->disertasi->cek_mkpkk_pengampu_pjmk($mkpkk['id_mkpkk'],$this->session_data['username']);
								if($pengampu_pjmk){
									if ($mkpkk['nilai_publish'] != '0') {
										?>
										<strong style="font-size: larger"><?php echo $mkpkk['nilai_angka'] ?></strong><br/>
										<br/>
										<?php echo form_open('dosen/disertasi/penilaian/mkpkk/cetak', ['target' => '_blank']) ?>
										<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
										<?php echo formtext('hidden', 'id_disertasi', $mkpkk['id_disertasi'], 'required') ?>
										<?php echo formtext('hidden', 'id_mkpkk', $mkpkk['id_mkpkk'], 'required') ?>
										<button type="submit" class="btn btn-xs btn-primary">
											<i class="fa fa-print"></i> Cetak
										</button>
										<?php echo form_close(); ?>
										<?php
									} else {
										?>
										<div class="btn btn-xs btn-danger">Belum Di Publish</div>
										<hr class="divider-line-semi-bold"/>
										<?php echo form_open('dosen/disertasi/penilaian/mkpkk/publish_nilai') ?>
										<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
										<?php echo formtext('hidden', 'id_disertasi', $mkpkk['id_disertasi'], 'required') ?>
										<?php echo formtext('hidden', 'id_mkpkk', $mkpkk['id_mkpkk'], 'required') ?>
										<span>Nilai Angka</span><br/>
										<strong style="font-size: larger"><?php echo $mkpkk['nilai_angka'] ?></strong><br/>
										<button type="submit" class="btn btn-xs btn-success">
											<i class="fa fa-check"></i> Publish
										</button>
										<?php echo form_close(); ?>
										<?php
									}
								}else{
									?>
									<strong style="font-size: 1.2em"><?php echo number_format($mkpkk['nilai_angka'],2) ?><br/></strong>
									<?php
									if($mkpkk['nilai_publish']=='0'){
										?>
										<span class="btn btn-xs btn-danger">Belum Publish</span>
										<?php
									}
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
