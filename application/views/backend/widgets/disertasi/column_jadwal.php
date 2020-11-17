<?php
$ujian = $this->disertasi->read_ujian($id_disertasi);
if ($ujian) {
    echo '<strong>Tanggal</strong> :<br>' . toindo($ujian->tanggal) . '<br>';
    echo '<strong>Ruang</strong>  :<br>' . $ujian->ruang . ' ' . $ujian->gedung . '<br>';
    echo '<strong>Jam</strong>     :<br>' . $ujian->jam;
} else {
    echo '';
}
?>