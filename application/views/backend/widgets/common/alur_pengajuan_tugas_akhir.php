<?php
// Jenjang Doktoral
if ($jenjang == 3) {
    $arr_process = [
        [
            'value' => TAHAPAN_DISERTASI_KUALIFIKASI,
            'title' => "UJIAN KUALIFIKASI",
            'field' => 'status_kualifikasi',
            'bg_color'=>'bg-teal',
        ],
        [
            'value' => TAHAPAN_DISERTASI_MPKK,
            'title' => "MKPKK",
            'field' => 'status_mpkk',
            'bg_color'=>'bg-teal-active',
        ],
        [
            'value' => TAHAPAN_DISERTASI_PROPOSAL,
            'title' => "UJIAN PROPOSAL",
            'field' => 'status_proposal',
            'bg_color'=>'bg-light-blue',
        ],
        [
            'value' => TAHAPAN_DISERTASI_MKPD,
            'title' => "MKPD",
            'field' => 'status_mkpd',
            'bg_color'=>'bg-light-blue-active',
        ],
        [
            'value' => TAHAPAN_DISERTASI_KELAYAKAN,
            'title' => "UJIAN KELAYAKAN",
            'field' => 'status_kelayakan',
            'bg_color'=>'bg-blue',
        ],
        [
            'value' => TAHAPAN_DISERTASI_TERTUTUP,
            'title' => "UJIAN TERTUTUP",
            'field' => 'status_tertutup',
            'bg_color'=>'bg-blue-active',
        ],
        [
            'value' => TAHAPAN_DISERTASI_TERBUKA,
            'title' => "UJIAN TERBUKA",
            'field' => 'status_terbuka',
            'bg_color'=>'bg-green',
        ],
    ];
    ?>

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-navy">
            <i class="fa fa-circle-o"></i> MULAI
        </span>
    </li>
    <?php
    foreach ($arr_process as $process):
        ?>
        <!-- /.timeline-label -->
        <li class="time-label">
            <span class="<?= $process['bg_color'] ?>">
                <?= $process['title'] ?>
            </span>
        </li>
        <?php
        $index = 0;
        $tahapans = $this->disertasi->read_status_tahapan($process['value']);
        foreach ($tahapans as $tahapan):
            if ($index > 0):
                ?>
                <li>
                    <?php
                    if ($tugas_akhir[$process['field']] >= $index):
                        ?>
                        <i class="fa fa-check bg-green"></i>
                        <?php
                    else:
                        ?>
                        <i class="fa fa-arrow-down"></i>
                    <?php
                    endif;
                    ?>


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
        <?php
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
if ($jenjang == 2) {
    $arr_process = [
        [
            'value' => TAHAPAN_TESIS_PROPOSAL,
            'title' => "UJIAN PROPOSAL",
            'field' => 'status_proposal',
            'bg_color'=>'bg-teal',
        ],
        [
            'value' => TAHAPAN_TESIS_UJIAN,
            'title' => "UJIAN TESIS",
            'field' => 'status_tesis',
            'bg_color'=>'bg-teal-active',
        ],
    ];
    ?>

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-navy">
            <i class="fa fa-circle-o"></i> MULAI
        </span>
    </li>
    <?php
    foreach ($arr_process as $process):
        ?>
        <!-- /.timeline-label -->
        <li class="time-label">
            <span class="<?= $process['bg_color'] ?>">
                <?= $process['title'] ?>
            </span>
        </li>
        <?php
        $index = 0;
        $tahapans = $this->tesis->read_status_tahapan($process['value']);
        foreach ($tahapans as $tahapan):
            if ($index > 0):
                ?>
                <li>
                    <?php
                    if ($tugas_akhir[$process['field']] >= $index):
                        ?>
                        <i class="fa fa-check bg-green"></i>
                        <?php
                    else:
                        ?>
                        <i class="fa fa-arrow-down"></i>
                    <?php
                    endif;
                    ?>


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
        <?php
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
