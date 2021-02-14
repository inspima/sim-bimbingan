<?php
	$disertasi_mkpkks = $this->disertasi->read_disertasi_mkpkk($id_disertasi);
	if (!empty($disertasi_mkpkks)) {
		?>
		<ol style="padding-left: 10px">
			<?php
				foreach ($disertasi_mkpkks as $index => $mkpkk) {
					?>
					<li>
						<?php echo $mkpkk['mkpkk'] ?><br/>
						<?php
							if ($mkpkk['nilai_publish'] != '0') {
								?>
								Nilai : <strong style="font-size: larger"><?php echo $mkpkk['nilai_angka'] ?></strong><br/>
								<?php echo form_open('prodi/doktoral/disertasi/mkpkk/cetak', ['target' => '_blank']) ?>
								<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
								<?php echo formtext('hidden', 'id_disertasi', $mkpkk['id_disertasi'], 'required') ?>
								<?php echo formtext('hidden', 'id_mkpkk', $mkpkk['id_mkpkk'], 'required') ?>
								<button type="submit" class="btn btn-xs btn-primary">
									<i class="fa fa-print"></i> Cetak
								</button>
								<?php echo form_close(); ?>
								<hr class="divider-line-thin">
								<?php
							}
						?>
					</li>
					<?php
				}
			?>
		</ol>
		<hr class="divider-line-semi-bold"/>
		<!-- CETAK SK -->
		<?php $attributes = array('target' => '_blank'); ?>
		<?php echo form_open('prodi/doktoral/disertasi/mkpkk/cetak-sk', $attributes) ?>
		<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
		<?php echo formtext('hidden', 'id_disertasi', $disertasi['id_disertasi'], 'required') ?>
		<input type="text" name="no_sk" class="form-control" required placeholder="NOMOR SK">
		<br/><br/>
		<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> SK Pengajar MKPKK</button>
		<?php echo form_close() ?>
		<?php
	} else {
		?>
		<div class="form-group">
			<p>Data belum ada</p>
		</div>
		<?php
	}
?>
