<?php

$jadwal = $this->tesis->read_jadwal($id_tesis, $jenis);

if (!empty($jadwal)) {

    $pengujis = $this->tesis->read_penguji($jadwal->id_ujian);

    $num = 1;

    foreach ($pengujis as $penguji) {

        if ($penguji['status'] == '1') {

            echo ($penguji['status_tim'] == '1' ? 'Ketua' : 'Anggota');

            ?>

            <p style="color:red;font-weight: bold">

                <?php

                echo $num . ' ' . $penguji['nama'] . '<br><i style="color:black">' . $penguji['nip'] . '</i><br>';

                ?>

            </p>

            <?php

        } else {

            echo ($penguji['status_tim'] == '1' ? 'Ketua' : 'Anggota');

            ?>

            <p style="color:green;font-weight: bold">

                <?php

                echo $num . ' ' . $penguji['nama'] . '<br><i style="color:black">' . $penguji['nip'] . '</i><br>';

                ?>

            </p>

            <?php

        }



        if ($this->session_data['username'] == $penguji['nip']) {

            if ($penguji['status'] == '1') {

                ?>

                <?php echo form_open('dosen/tesis/permintaan/penguji/setujui') ?>

                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>

                <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses  Setujui</button><br/>

                <?php echo formtext('hidden', 'id_penguji', $penguji['id_penguji'], 'required') ?>

                <?php echo formtext('hidden', 'id_tesis', $id_tesis, 'required') ?>

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