<?php
if (!empty($jadwal)) {
    ?>  
    <div class="form-group">
        <label>Tanggal</label>
        <hr class="divider-line-thin"/>
        <p>
            <i class="fa fa-calendar"></i>&nbsp;&nbsp;
            <?php echo hari($jadwal->tanggal) ?>, <?php echo woday_toindo($jadwal->tanggal) ?>
        </p>

    </div>

    <div class="form-group">
        <label>Ruang</label>
        <hr class="divider-line-thin"/>
        <p>
            <i class="fa fa-building-o"></i>&nbsp;&nbsp;
            Ruang <?= $jadwal->ruang . ' Gedung ' . $jadwal->gedung ?>
        </p>
    </div>

    <div class="form-group">
        <label>Jam</label>
        <hr class="divider-line-thin"/>
        <p>
            <i class="fa fa-clock-o"></i>&nbsp;&nbsp;
            <?= substr($jadwal->jam, 0, 5); ?> - Selesai
        </p>
    </div>

    <div class="form-group">
        <label>Link Zoom</label>
        <hr class="divider-line-thin"/>
        <p>
            <i class="fa fa-globe"></i>&nbsp;&nbsp;
            <?= '<a href="'.$jadwal->link_zoom.'" target="_blank">'.$jadwal->link_zoom.'</a>'; ?>
        </p>
    </div>
    <?php
} else {
    ?>
    <div class="form-group">
        <p>Jadwal ujian belum ada</p>
    </div>
    <?php
}
?>
<?php
if (!empty($jadwal)) {
    if ($jadwal->status_apv_kaprodi == '1') {
        ?>
        <p align="center"><b><i class="fa fa-check text-green"></i> Sudah Diverifikasi Kaprodi</b></p>
        <!--
        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Ubah Ruang</button>
        -->
        <?php
    }
    else {
    ?>
        <p align="center"><b><i class="fa fa-check text-yellow"></i> Menunggu Verifikasi Kaprodi</b></p>
    <?php
    }
}
?>