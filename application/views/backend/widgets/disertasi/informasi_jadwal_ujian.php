<?php
	if (!empty($jadwal)) {
		?>
		<div class="form-group">
			<label>Tanggal</label>
			<hr class="divider-line-thin"/>
			<p>
				<i class="fa fa-calendar"></i>&nbsp;&nbsp;
				<?php echo hari($jadwal->tanggal) ?>, <?php echo woday_toindo($jadwal->tanggal) ?>
			</p>

		</div>

		<div class="form-group">
			<label>Tempat</label>
			<hr class="divider-line-thin"/>
			<p>
				<i class="glyphicon glyphicon-blackboard"></i> <?= $jadwal->ruang ?>
			<div class="divider10"></div>
			<i class="fa fa-building-o"></i> <?= $jadwal->gedung ?>
			</p>
		</div>

		<div class="form-group">
			<label>Jam</label>
			<hr class="divider-line-thin"/>
			<p>
				<i class="fa fa-clock-o"></i>&nbsp;&nbsp;
				<?= substr($jadwal->jam, 0, 5); ?> - Selesai
			</p>
		</div>
		<?php
		if ($jadwal->ruang == 'ON'&&!empty($jadwal->link_meeting)) {
			?>
			<div class="form-group">
				<label>Link Ujian Online</label>
				<hr class="divider-line-thin"/>
				<p>
					<i class="fa fa-link"></i>&nbsp;&nbsp;
					<a href="<?=$jadwal->link_meeting?>">Klik disini</a><br/>
					<span class="text-muted">atau copy text dibawah </span><br/>
					<textarea class="form-control" style="resize: none" rows="2" readonly><?=$jadwal->link_meeting?></textarea>
				</p>
			</div>
			<?php
		}
		?>
		<?php
	} else {
		?>
		<div class="form-group">
			<p>Jadwal ujian belum ada</p>
		</div>
		<?php
	}
?>
