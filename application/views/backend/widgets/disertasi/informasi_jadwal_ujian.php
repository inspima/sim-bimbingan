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
			<hr class="divider-line-thin"/>
			<label>Ujian Online</label>
			<hr class="divider-line-thin"/>
			<p>
				<a href="<?= $jadwal->link_meeting ?>"><b><i class="fa fa-link"></i> Klik Link</b></a><br/>
				<span class="text-muted">atau copy text dibawah </span><br/>
				<code style="color: black"><?= $jadwal->link_meeting ?></code>
			</p>
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
