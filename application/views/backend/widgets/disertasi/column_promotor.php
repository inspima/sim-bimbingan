<?php
$disertasi = $this->disertasi->detail($id_disertasi);
if ($disertasi->status_proposal > 0) {
    $promotors = $this->disertasi->read_promotor_kopromotor($id_disertasi);
    $num = 1;
    foreach ($promotors as $promotor) {
        if ($promotor['status'] == '1') {
            ?>
            <p style="color:red">
                <?php
                echo $num . ' ' . $promotor['nama'] . '<br>';
                ?>
            </p>
            <?php
        } else {
            echo $num . ' ' . $promotor['nama'] . '<br>';
        }

        if ($this->session_data['username'] == $promotor['nip']) {
            if ($promotor['status'] == '1') {
                ?>
                <?php echo form_open('dosen/disertasi/permintaan/promotor/setujui') ?>
                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses  Setujui</button><br/>
                <?php echo formtext('hidden', 'id_promotor', $promotor['id_promotor'], 'required') ?>
                <?php echo formtext('hidden', 'id_disertasi', $id_disertasi, 'required') ?>
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
    <span class="label bg-red">Kosong</span>
    <?php
}
?>