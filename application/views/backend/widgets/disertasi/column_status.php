<?php
if ($jenis == TAHAPAN_DISERTASI_KUALIFIKASI): // KUALIFIKASI
    $status = $this->disertasi->get_status_tahapan($disertasi['status_kualifikasi'], TAHAPAN_DISERTASI_KUALIFIKASI);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php
elseif ($jenis == TAHAPAN_DISERTASI_PROMOTOR) :// PENGAJUAN PROMOTOR
    $status = $this->disertasi->get_status_tahapan($disertasi['status_promotor'], TAHAPAN_DISERTASI_PROMOTOR);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php
elseif ($jenis == TAHAPAN_DISERTASI_MPKK) :// MPKK
    $status = $this->disertasi->get_status_tahapan($disertasi['status_mpkk'], TAHAPAN_DISERTASI_MPKK);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php
elseif ($jenis == TAHAPAN_DISERTASI_PROPOSAL) :// PROPOSAL
    $status = $this->disertasi->get_status_tahapan($disertasi['status_proposal'], TAHAPAN_DISERTASI_PROPOSAL);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php
elseif ($jenis == TAHAPAN_DISERTASI_MKPD) :// MKPD

    $status = $this->disertasi->get_status_tahapan($disertasi['status_mkpd'], TAHAPAN_DISERTASI_MKPD);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php
elseif ($jenis == TAHAPAN_DISERTASI_KELAYAKAN) :// KELAYAKAN
    $status = $this->disertasi->get_status_tahapan($disertasi['status_kelayakan'], TAHAPAN_DISERTASI_KELAYAKAN);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php
elseif ($jenis == TAHAPAN_DISERTASI_TERTUTUP) :// UJIAN TERTUTUP

    $status = $this->disertasi->get_status_tahapan($disertasi['status_tertutup'], TAHAPAN_DISERTASI_TERTUTUP);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php
elseif ($jenis == TAHAPAN_DISERTASI_TERBUKA) :// UJIAN TERBUKA

    $status = $this->disertasi->get_status_tahapan($disertasi['status_terbuka'], TAHAPAN_DISERTASI_TERBUKA);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php


endif;