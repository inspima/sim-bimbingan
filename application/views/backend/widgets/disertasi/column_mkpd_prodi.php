<?php
	$disertasi_mkpds = $this->disertasi->read_disertasi_mkpd($id_disertasi);
	if (!empty($disertasi_mkpds)) {
		?>
		<ol>
			<?php
				foreach ($disertasi_mkpds as $index => $mkpd) {
					?>
					<li>
						<?php echo $mkpd['mkpd'] ?><br/>
						<?php
							if ($mkpd['nilai_publish'] != '0') {
								?>
								Nilai : <strong style="font-size: larger"><?php echo $mkpd['nilai_angka'] ?></strong><br/>
								<?php echo form_open('prodi/doktoral/disertasi/mkpd/cetak', ['target' => '_blank']) ?>
								<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
								<?php echo formtext('hidden', 'id_disertasi', $mkpd['id_disertasi'], 'required') ?>
								<?php echo formtext('hidden', 'id_disertasi_mkpd', $mkpd['id_disertasi_mkpd'], 'required') ?>
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
		<?php echo form_open('prodi/doktoral/disertasi/mkpd/cetak-sk', $attributes) ?>
		<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
		<?php echo formtext('hidden', 'id_disertasi', $disertasi['id_disertasi'], 'required') ?>
		<input type="text" name="no_sk" class="form-control" required placeholder="NOMOR SK">
		<br/><br/>
		<button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> SK Pengajar MKPD</button>
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
