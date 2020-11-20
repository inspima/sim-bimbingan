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

elseif ($jenis == '2') :// MPKK

    if ($disertasi['status_mpkk'] == '0') {
        ?>
        <span class = "btn btn-xs btn-default">Belum</span>
        <?php

    } else if ($disertasi['status_mpkk'] == '1') {
        ?>
        <span class = "btn btn-xs bg-blue"><i class = "fa fa-check"></i> Pengajuan</span>
        <?php

    } else if ($disertasi['status_mpkk'] == '2') {
        ?>
        <span class="btn btn-xs bg-green-active"><i class="fa fa-check"></i> Diterima SPS</span>
        <?php

    } else if ($disertasi['status_mpkk'] == '3') {
        ?>
        <span class="btn btn-xs bg-green-active"><i class="fa fa-check"></i> Diterima KPS</span>
        <?php

    } else {
        ?>
        <span class="btn btn-xs bg-red"><i class="fa fa-check"></i> Selesai</span>
        <?php

    }

elseif ($jenis == '3') :// PROPOSAL
    
    if ($disertasi['status_proposal'] == '0') {
        ?>
        <span class = "btn btn-xs btn-default">Belum</span>
        <?php

    } else if ($disertasi['status_proposal'] == '1') {
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

elseif ($jenis == '4') :// MKPD

    if ($disertasi['status_mkpd'] == '0') {
        ?>
        <span class = "btn btn-xs btn-default">Belum</span>
        <?php

    } else if ($disertasi['status_mkpd'] == '1') {
        ?>
        <span class = "btn btn-xs bg-blue"><i class = "fa fa-check"></i> Pengajuan</span>
        <?php

    } else if ($disertasi['status_mkpd'] == '2') {
        ?>
        <span class="btn btn-xs bg-green-active"><i class="fa fa-check"></i> Diterima SPS</span>
        <?php

    } else if ($disertasi['status_mkpd'] == '3') {
        ?>
        <span class="btn btn-xs bg-green-active"><i class="fa fa-check"></i> Diterima KPS</span>
        <?php

    } else {
        ?>
        <span class="btn btn-xs bg-red"><i class="fa fa-check"></i> Selesai</span>
        <?php

    }

elseif ($jenis == '5') :// KELAYAKAN
    if ($disertasi['status_kelayakan'] == '0') {
        ?>
        <span class = "btn btn-xs btn-default">Belum</span>
        <?php

    } else {
        ?>
        <?php

    }

elseif ($jenis == '6') :// UJIAN TERTUTUP
    if ($disertasi['status_tertutup'] == '0') {
        ?>
        <span class = "btn btn-xs btn-default">Belum</span>
        <?php

    } else {
        ?>
        <?php

    }

elseif ($jenis == '7') :// UJIAN TERBUKA
    if ($disertasi['status_terbuka'] == '0') {
        ?>
        <span class = "btn btn-xs btn-default">Belum</span>
        <?php

    } else {
        ?>
        <?php

    }
    
endif;