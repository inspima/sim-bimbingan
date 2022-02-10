<?php
	$jadwal = $this->disertasi->read_jadwal($id_disertasi, $jenis);
	$disertasi = $this->disertasi->detail($id_disertasi);
	if (!empty($jadwal)) {
		$pengujis = $this->disertasi->read_penguji($jadwal->id_ujian);
		$num = 1;
		if (count($pengujis) > 0) {
			?>
			<button class="btn btn-xs bg-blue-active" onclick="$('#list-penguji-<?= $id_disertasi ?>').toggle()"><i class="fa fa-eye"></i> Tampilkan Penguji</button>
			<hr class="divider-line-semi-bold"/>
			<div id="list-penguji-<?= $id_disertasi ?>" style="display: none">
				<?php
					echo '';
					foreach ($pengujis as $penguji) {
						if ($penguji['status'] == '1') {
							echo($penguji['status_tim'] == '1' ? 'Ketua' : 'Anggota');
							?>
							<p style="color:red;font-weight: bold">
								<?php
									echo $num . ' ' . $penguji['nama'] . '<br><i style="color:black">' . $penguji['nip'] . '</i><br>';
								?>
							</p>
							<?php
						} else {
							echo($penguji['status_tim'] == '1' ? 'Ketua' : 'Anggota');
							?>
							<p style="color:green;font-weight: bold">
								<?php
									echo $num . ' ' . $penguji['nama'] . '<br><i style="color:black">' . $penguji['nip'] . '</i><br>';
								?>
							</p>
							<?php
						}

						if ($this->session_data['username'] == $penguji['nip']) {

						}
						$num++;
					}
				?>
			</div>
			<?php
			$penguji_row = $this->disertasi->read_penguji_row($jadwal->id_ujian, $this->session_data['username']);
			if (!empty($penguji_row)) {
				$this->view('backend/widgets/disertasi/form_persetujuan_penguji', [
						'id_disertasi'=>$id_disertasi,
						'disertasi' => $disertasi,
						'jadwal' => $jadwal,
						'penguji' => $penguji_row,
				]);
			}
			?>
			<?php
		}

	} else {
		?>
		<span class="label bg-red">Kosong</span>
		<?php
	}
?>
