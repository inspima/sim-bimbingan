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
    <?php
} else {
    ?>
    <div class="form-group">
        <p>Jadwal ujian belum ada</p>
    </div>
    <?php
}
?>