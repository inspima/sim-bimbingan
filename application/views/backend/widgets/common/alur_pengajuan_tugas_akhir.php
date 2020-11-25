<?php
// Jenjang Doktoral
if ($jenjang == 3) {
    ?>
    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-navy">
            <i class="fa fa-circle-o"></i> MULAI
        </span>
    </li>

    <!-- /.timeline-label -->
    <li class="time-label">
        <span class="bg-teal">
            UJIAN KUALIFIKASI
        </span>
    </li>
    <?php
    $index = 0;
    $tahapans = $this->disertasi->read_status_tahapan(TAHAPAN_DISERTASI_KUALIFIKASI);
    foreach ($tahapans as $tahapan):
        if ($index > 0):
            ?>
            <li>
                <i class="fa fa-arrow-down"></i>

                <div class="timeline-item">

                    <h3 class="timeline-header"><a href="#"><?= $tahapan['text'] ?></a></h3>

                    <div class="timeline-body">
                        <?= $tahapan['keterangan'] ?>
                    </div>
                </div>
            </li>
            <?php
        endif;
        $index++;
    endforeach;
    ?>

    <!-- /.timeline-label -->
    <li class="time-label">
        <span class="bg-teal-active">
            MKPKK
        </span>
    </li>
    <?php
    $index = 0;
    $tahapans = $this->disertasi->read_status_tahapan(TAHAPAN_DISERTASI_MPKK);
    foreach ($tahapans as $tahapan):
        if ($index > 0):
            ?>
            <li>
                <i class="fa fa-arrow-down"></i>

                <div class="timeline-item">

                    <h3 class="timeline-header"><a href="#"><?= $tahapan['text'] ?></a></h3>

                    <div class="timeline-body">
                        <?= $tahapan['keterangan'] ?>
                    </div>
                </div>
            </li>
            <?php
        endif;
        $index++;
    endforeach;
    ?>

    <!-- /.timeline-label -->
    <li class="time-label">
        <span class="bg-light-blue">
            UJIAN PROPOSAL
        </span>
    </li>
    <?php
    $index = 0;
    $tahapans = $this->disertasi->read_status_tahapan(TAHAPAN_DISERTASI_PROPOSAL);
    foreach ($tahapans as $tahapan):
        if ($index > 0):
            ?>
            <li>
                <i class="fa fa-arrow-down"></i>

                <div class="timeline-item">

                    <h3 class="timeline-header"><a href="#"><?= $tahapan['text'] ?></a></h3>

                    <div class="timeline-body">
                        <?= $tahapan['keterangan'] ?>
                    </div>
                </div>
            </li>
            <?php
        endif;
        $index++;
    endforeach;
    ?>

    <!-- /.timeline-label -->
    <li class="time-label">
        <span class="bg-light-blue-active">
            MKPD
        </span>
    </li>
    <?php
    $index = 0;
    $tahapans = $this->disertasi->read_status_tahapan(TAHAPAN_DISERTASI_MKPD);
    foreach ($tahapans as $tahapan):
        if ($index > 0):
            ?>
            <li>
                <i class="fa fa-arrow-down"></i>

                <div class="timeline-item">

                    <h3 class="timeline-header"><a href="#"><?= $tahapan['text'] ?></a></h3>

                    <div class="timeline-body">
                        <?= $tahapan['keterangan'] ?>
                    </div>
                </div>
            </li>
            <?php
        endif;
        $index++;
    endforeach;
    ?>

    <!-- /.timeline-label -->
    <li class="time-label">
        <span class="bg-blue">
            UJIAN KELAYAKAN
        </span>
    </li>
    <?php
    $index = 0;
    $tahapans = $this->disertasi->read_status_tahapan(TAHAPAN_DISERTASI_KELAYAKAN);
    foreach ($tahapans as $tahapan):
        if ($index > 0):
            ?>
            <li>
                <i class="fa fa-arrow-down"></i>

                <div class="timeline-item">

                    <h3 class="timeline-header"><a href="#"><?= $tahapan['text'] ?></a></h3>

                    <div class="timeline-body">
                        <?= $tahapan['keterangan'] ?>
                    </div>
                </div>
            </li>
            <?php
        endif;
        $index++;
    endforeach;
    ?>

    <!-- /.timeline-label -->
    <li class="time-label">
        <span class="bg-blue-active">
            UJIAN TERTUTUP
        </span>
    </li>
    <?php
    $index = 0;
    $tahapans = $this->disertasi->read_status_tahapan(TAHAPAN_DISERTASI_TERTUTUP);
    foreach ($tahapans as $tahapan):
        if ($index > 0):
            ?>
            <li>
                <i class="fa fa-arrow-down"></i>

                <div class="timeline-item">

                    <h3 class="timeline-header"><a href="#"><?= $tahapan['text'] ?></a></h3>

                    <div class="timeline-body">
                        <?= $tahapan['keterangan'] ?>
                    </div>
                </div>
            </li>
            <?php
        endif;
        $index++;
    endforeach;
    ?>

    <!-- /.timeline-label -->
    <li class="time-label">
        <span class="bg-green">
            UJIAN TERBUKA
        </span>
    </li>
    <?php
    $index = 0;
    $tahapans = $this->disertasi->read_status_tahapan(TAHAPAN_DISERTASI_TERBUKA);
    foreach ($tahapans as $tahapan):
        if ($index > 0):
            ?>
            <li>
                <i class="fa fa-arrow-down"></i>

                <div class="timeline-item">

                    <h3 class="timeline-header"><a href="#"><?= $tahapan['text'] ?></a></h3>

                    <div class="timeline-body">
                        <?= $tahapan['keterangan'] ?>
                    </div>
                </div>
            </li>
            <?php
        endif;
        $index++;
    endforeach;
    ?>


    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-red-active">
            <i class="fa fa-check"></i> SELESAI
        </span>
    </li>
    <!-- /.timeline-label -->
    <?php
}
