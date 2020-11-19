<?php

if ($jenis == '1'): // KUALIFIKASI
    if ($disertasi['status_kualifikasi'] == '1') {
        ?>
        <span class = "btn btn-xs bg-blue"><i class = "fa fa-check"></i> Pengajuan</span>
        <?php

    } else if ($disertasi['status_kualifikasi'] == '2') {
        ?>
        <span class="btn btn-xs bg-green-active"><i class="fa fa-check"></i> Diterima SPS</span>
        <?php

    } else if ($disertasi['status_kualifikasi'] == '3') {
        ?>
        <span class="btn btn-xs bg-green-active"><i class="fa fa-check"></i> Diterima KPS</span>
        <?php

    } else if ($disertasi['status_kualifikasi'] == '4') {
        ?>
        <span class="btn btn-xs bg-navy"><i class="fa fa-check"></i> Dijadwalkan</span>
        <?php

    } else if ($disertasi['status_kualifikasi'] == '5') {
        ?>
        <span class="btn btn-xs bg-purple"><i class="fa fa-check"></i> Ujian</span>
        <?php

    } else {
        ?>
        <span class="btn btn-xs bg-red"><i class="fa fa-check"></i> Selesai</span>
        <?php

    }
elseif ($jenis == '2') :// PROPOSAL
    if ($disertasi['status_proposal'] == '1') {
        ?>
        <span class = "btn btn-xs bg-blue"><i class = "fa fa-check"></i> Pengajuan</span>
        <?php

    } else if ($disertasi['status_proposal'] == '2') {
        ?>
        <span class="btn btn-xs bg-green-active"><i class="fa fa-check"></i> Diterima SPS</span>
        <?php

    } else if ($disertasi['status_proposal'] == '3') {
        ?>
        <span class="btn btn-xs bg-green-active"><i class="fa fa-check"></i> Diterima KPS</span>
        <?php

    } else if ($disertasi['status_proposal'] == '4') {
        ?>
        <span class="btn btn-xs bg-navy"><i class="fa fa-check"></i> Dijadwalkan</span>
        <?php

    } else if ($disertasi['status_proposal'] == '5') {
        ?>
        <span class="btn btn-xs bg-purple"><i class="fa fa-check"></i> Ujian</span>
        <?php

    } else {
        ?>
        <span class="btn btn-xs bg-red"><i class="fa fa-check"></i> Selesai</span>
        <?php

    }
elseif ($jenis == '3') :// KELAYAKAN
elseif ($jenis == '4') :// UJIAN TERTUTUP
elseif ($jenis == '5') :// UJIAN TERBUKA
endif;