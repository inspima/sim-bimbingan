<p style="color:green;font-weight: bold">
	<?php
		if (!empty($disertasi['nama_penasehat'])) {
			?>
			<?php
			echo $disertasi['nama_penasehat'] . '<br><i style="color:black">' . $disertasi['nip_penasehat'] . '</i><br>';
			?>
			<?php
		} else {
			?>
			<a class="btn btn-danger btn-xs">Data Kosong</a>
			<?php
		}
	?>

</p>
