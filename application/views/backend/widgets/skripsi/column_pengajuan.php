<?= $skripsi['judul'] ?>
<br/>
<?php
	if ($jenis == TAHAPAN_SKRIPSI_PROPOSAL) {
		?>
		<a class="btn btn-xs btn-danger" href="<?php echo base_url() ?>assets/upload/proposal/<?php echo $skripsi['berkas_proposal'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Berkas</a>
		<?php
	} else {
		?>
		<a class="btn btn-xs btn-danger" href="<?php echo base_url() ?>assets/upload/skripsi/<?php echo $skripsi['berkas_skripsi'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Berkas</a>
		<?php
	}
?>

<hr class="divider-line-thin"/>
<b class="text-primary">Departemen</b><br/>
<?php echo $skripsi['departemen'] ?>
<hr class="divider-line-thin"/>
<b class="text-primary">Gelombang</b><br/>
<?= $skripsi['gelombang'] . ' (' . $skripsi['semester'] . ')' ?>
