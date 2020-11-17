<?php
$jadwal = $this->disertasi->read_jadwal($id_disertasi, 1);
if (!empty($jadwal)) {
    $penguji = $this->disertasi->read_penguji($jadwal->id_ujian);
    $num = 1;
    foreach ($penguji as $show) {
        if ($show['status'] == '1') {
            ?>
            <p style="color:red">
                <?php
                echo $num . ' ' . $show['nama'] . '<br>';
                ?>
            </p>
            <?php
        } else {
            echo $num . ' ' . $show['nama'] . '<br>';
        }

        if ($this->session_data['username'] == $show['nip']) {
            if ($show['status'] == '1') {
                ?>
                <?php echo form_open('dosen/disertasi/kualifikasi/penguji/setujui') ?>
                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses  Setujui</button><br/>
                <?php echo formtext('hidden', 'id_penguji', $show['id_penguji'], 'required') ?>
                <?php echo formtext('hidden', 'id_disertasi', $id_disertasi, 'required') ?>
                <?php echo formtext('hidden', 'id_ujian', $jadwal->id_ujian, 'required') ?>
                <?php
            } else {
                ?>
                <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Disetujui</button><br/>
                <?php
            }
        }
        $num++;
    }
} else {
    ?>
    <span class="label bg-red">Penguji Kosong</span>
    <?php
}
?>