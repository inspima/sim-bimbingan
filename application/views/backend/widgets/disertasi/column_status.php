<?php
if ($jenis == '1'): // KUALIFIKASI
    $status = $this->disertasi->get_status_tahapan($disertasi['status_kualifikasi'], TAHAPAN_DISERTASI_KUALIFIKASI);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php
elseif ($jenis == '2') :// MPKK
    $status = $this->disertasi->get_status_tahapan($disertasi['status_mpkk'], TAHAPAN_DISERTASI_MPKK);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php
elseif ($jenis == '3') :// PROPOSAL
    $status = $this->disertasi->get_status_tahapan($disertasi['status_proposal'], TAHAPAN_DISERTASI_PROPOSAL);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php
elseif ($jenis == '4') :// MKPD

    $status = $this->disertasi->get_status_tahapan($disertasi['status_mkpd'], TAHAPAN_DISERTASI_MKPD);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php
elseif ($jenis == '5') :// KELAYAKAN
    $status = $this->disertasi->get_status_tahapan($disertasi['status_kelayakan'], TAHAPAN_DISERTASI_KELAYAKAN);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php
elseif ($jenis == '6') :// UJIAN TERTUTUP

    $status = $this->disertasi->get_status_tahapan($disertasi['status_tertutup'], TAHAPAN_DISERTASI_TERTUTUP);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php
elseif ($jenis == '7') :// UJIAN TERBUKA

    $status = $this->disertasi->get_status_tahapan($disertasi['status_terbuka'], TAHAPAN_DISERTASI_TERBUKA);
    ?>
    <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
    <?php

    
endif;