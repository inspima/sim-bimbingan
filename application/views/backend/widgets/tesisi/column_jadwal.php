<?php
$ujian = $this->disertasi->read_jadwal($id_disertasi, $jenis);
if ($ujian) {
    echo '<strong>Tanggal</strong> :<br>' . toindo($ujian->tanggal) . '<br>';
    echo '<strong>Ruang</strong>  :<br>' . $ujian->ruang . ' ' . $ujian->gedung . '<br>';
    echo '<strong>Jam</strong>     :<br>' . $ujian->jam;
} else {
    ?>
    <span class="label bg-red">Kosong</span>
    <?php

}
?>