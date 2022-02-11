<?php
	$ujian = $this->disertasi->read_jadwal($id_disertasi, $jenis);
	if ($ujian) {
		echo '<strong>Tanggal</strong> :<br>' . toindo($ujian->tanggal) . '<br>';
		echo '<strong>Ruang</strong>  :<br>' . $ujian->ruang . ' ' . $ujian->gedung . '<br>';
		echo '<strong>Jam</strong>     :<br>' . $ujian->jam;
		if ($ujian->ruang == 'ON' && !empty($ujian->link_meeting)) {
			?>
			<hr class="divider-line-thin"/>
			<label>Ujian Online</label>
			<hr class="divider-line-thin"/>
			<p>
				<a href="<?= $ujian->link_meeting ?>"><b><i class="fa fa-link"></i> Klik Link</b></a><br/>
				<span class="text-muted">atau copy text dibawah </span><br/>
				<code style="color: black"><?= $ujian->link_meeting ?></code>
			</p>
			<?php
		}
	} else {
		?>
		<span class="label bg-red">Kosong</span>
		<?php

	}
?>
