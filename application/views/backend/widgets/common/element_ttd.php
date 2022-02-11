<?php
	if (!empty($ttd)) {
		?>
		<br/>
		<img style="margin: 5px;" src="<?= str_replace(base_url(), "", $ttd) ?>" width="120px"/>
		<br/>
		<?php
	} else {
		?>
		<font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
		<?php
	}
