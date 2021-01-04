<?php
	$disertasi_mkpds = $this->disertasi->read_disertasi_mkpd($id_disertasi);
	if (!empty($disertasi_mkpds)) {
		?>
		<ol>
			<?php
				foreach ($disertasi_mkpds as $index => $mkpd) {
					?>
					<li><?php echo $mkpd['mkpd'] ?></li>
					<?php
				}
			?>
		</ol>
		<?php
	} else {
		?>
		<div class="form-group">
			<p>Data belum ada</p>
		</div>
		<?php
	}
?>
