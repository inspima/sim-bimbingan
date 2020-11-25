<?php
if ($disertasi['status_kualifikasi'] == 1) {
    ?>
    <p style="color:red;font-weight: bold">
        <?php
        echo $disertasi['nama_penasehat'] . '<br><i style="color:black">' . $disertasi['nip_penasehat'] . '</i><br>';
        ?>
    </p>
    <?php
} else if ($disertasi['status_kualifikasi'] > 1) {
    ?>
    <p style="color:green;font-weight: bold">
        <?php
        echo $disertasi['nama_penasehat'] . '<br><i style="color:black">' . $disertasi['nip_penasehat'] . '</i><br>';
        ?>
    </p>
    <?php
}
?>
<?php
if ($this->session_data['username'] == $disertasi['nip_penasehat']) {
    if ($disertasi['status_kualifikasi'] == 1) {
        ?>
        <div class="divider3"></div>
        <?php echo form_open('dosen/disertasi/permintaan/penasehat/setujui') ?>
        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
        <button class="btn btn-xs btn-success"><i class="fa fa-check"></i> Proses  Setujui</button><br/>
        <?php echo formtext('hidden', 'id_disertasi', $disertasi['id_disertasi'], 'required') ?>
        <?php
    }
}