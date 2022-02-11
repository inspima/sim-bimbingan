<?php
	if (!empty($ttd)) {
		?>
		<img style="margin: 5px;" src="<?= str_replace(base_url(), "", $ttd) ?>" width="60px"/>
		<?php
	} else {
		?>
		<font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
		<?php
	}
