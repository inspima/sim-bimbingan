<?php
	$disertasi = $this->disertasi->detail($id_disertasi);
	$status_promotor = $this->disertasi->get_status_promotor($id_disertasi, $this->session_data['username']);
	if (!empty($status_promotor)) {
		$promotors = $this->disertasi->read_promotor_kopromotor($id_disertasi);
		$num = 1;
		foreach ($promotors as $promotor) {
			if ($promotor['status'] == '1') {
				echo($promotor['status_tim'] == '1' ? 'Promotor' : 'Ko-Promotor');
				?>
				<p style="color:red;font-weight: bold">
					<?php
						echo $num . ' ' . $promotor['nama'] . '<br><i style="color:black">' . $promotor['nip'] . '</i><br>';
					?>
				</p>
				<?php
			} else {
				echo($promotor['status_tim'] == '1' ? 'Promotor' : 'Ko-Promotor');
				?>
				<p style="color:green;font-weight: bold">
					<?php
						echo $num . ' ' . $promotor['nama'] . '<br><i style="color:black">' . $promotor['nip'] . '</i><br>';
					?>
				</p>
				<?php
			}
			?>
			<?php
			if ($this->session_data['username'] == $promotor['nip']) {
				if ($promotor['status'] == '1') {
					if ($disertasi->status_promotor >= STATUS_DISERTASI_PROMOTOR_SETUJUI_KPS) {
						?>
						<div class="divider3"></div>
						<?php echo form_open('dosen/disertasi/permintaan/promotor/setujui') ?>
						<?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
						<button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses Setujui</button><br/>
						<?php echo formtext('hidden', 'id_promotor', $promotor['id_promotor'], 'required') ?>
						<?php echo formtext('hidden', 'id_disertasi', $id_disertasi, 'required') ?>
						<?php
					}
				}
			}
			$num++;
			?>
			<div class="divider3"></div>
			<?php
		}
	} else {
		?>
		<span class="label bg-red">Belum ada pengajuan</span>
		<?php
	}
?>
