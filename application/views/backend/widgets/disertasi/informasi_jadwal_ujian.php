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
        <label>Tempat</label>
        <hr class="divider-line-thin"/>
        <p>
			<i class="glyphicon glyphicon-blackboard"></i> <?= $jadwal->ruang ?>
			<div class="divider10"></div>
			<i class="fa fa-building-o"></i>  <?= $jadwal->gedung ?>
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
