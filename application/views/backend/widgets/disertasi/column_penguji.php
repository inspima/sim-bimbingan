<?php
$jadwal = $this->disertasi->read_jadwal($id_disertasi, $jenis);
if (!empty($jadwal)) {
    $pengujis = $this->disertasi->read_penguji($jadwal->id_ujian);
    $num = 1;
    foreach ($pengujis as $penguji) {
        if ($penguji['status'] == '1') {
            echo ($penguji['status_tim'] == '1' ? 'Ketua' : 'Anggota');
            ?>
            <p style="color:red;font-weight: bold">
                <?php
                echo $num . ' ' . $penguji['nama'] . '<br>';
                ?>
            </p>
            <?php
        } else {
            echo ($penguji['status_tim'] == '1' ? 'Ketua' : 'Anggota');
            ?>
            <p style="color:green;font-weight: bold">
                <?php
                echo $num . ' ' . $penguji['nama'] . '<br>';
                ?>
            </p>
            <?php
        }

        if ($this->session_data['username'] == $penguji['nip']) {
            if ($penguji['status'] == '1') {
                ?>
                <?php echo form_open('dosen/disertasi/permintaan/penguji/setujui') ?>
                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses  Setujui</button><br/>
                <?php echo formtext('hidden', 'id_penguji', $penguji['id_penguji'], 'required') ?>
                <?php echo formtext('hidden', 'id_disertasi', $id_disertasi, 'required') ?>
                <?php echo formtext('hidden', 'id_ujian', $jadwal->id_ujian, 'required') ?>
                <?php
            }
        }
        $num++;
    }
} else {
    ?>
    <span class="label bg-red">Kosong</span>
    <?php
}
?>