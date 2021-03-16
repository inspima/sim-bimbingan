<?php
	$penguji = $this->transaksi_proposal->read_penguji_semua($skripsi['id_ujian'], $jenis);
	foreach ($penguji as $listpenguji) {
		?>

		<?php
		if ($listpenguji['status'] == '1') {
			?>
			<b class="text-danger" ><?php echo $listpenguji['nama'] ?></b><br/><?= $listpenguji['nip'] ?><br/>
			<?php
		}else{
			?>
			<b class="text-success"><?php echo $listpenguji['nama'] ?></b><br/><?= $listpenguji['nip'] ?><br/>
			<?php
		}
		?>
		<?php
	}
?>
