<?php
// S1
if (!in_array($mahasiswa['role'], [ROLE_MAHASISWA_S2, ROLE_MAHASISWA_S3])) {
    
} else if ($mahasiswa['role'] == ROLE_MAHASISWA_S2) {
    
} else if ($mahasiswa['role'] == ROLE_MAHASISWA_S3) {
    $tugas_akhir = $this->tugas_akhir->detail_disertasi($mahasiswa['nim']);
    if (!empty($tugas_akhir)):
        $jenis = $tugas_akhir->jenis;
        if ($jenis == TAHAPAN_DISERTASI_KUALIFIKASI): // KUALIFIKASI
            $status = $this->disertasi->get_status_tahapan($tugas_akhir->status_kualifikasi, TAHAPAN_DISERTASI_KUALIFIKASI);
            ?>
            <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
            <?php
        elseif ($jenis == TAHAPAN_DISERTASI_MPKK) :// MPKK
            $status = $this->disertasi->get_status_tahapan($tugas_akhir->status_mpkk, TAHAPAN_DISERTASI_MPKK);
            ?>
            <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
            <?php
        elseif ($jenis == TAHAPAN_DISERTASI_PROPOSAL) :// PROPOSAL
            $status = $this->disertasi->get_status_tahapan($tugas_akhir->status_proposal, TAHAPAN_DISERTASI_PROPOSAL);
            ?>
            <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
            <?php
        elseif ($jenis == TAHAPAN_DISERTASI_MKPD) :// MKPD

            $status = $this->disertasi->get_status_tahapan($tugas_akhir->status_mkpd, TAHAPAN_DISERTASI_MKPD);
            ?>
            <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
            <?php
        elseif ($jenis == TAHAPAN_DISERTASI_KELAYAKAN) :// KELAYAKAN
            $status = $this->disertasi->get_status_tahapan($tugas_akhir->status_kelayakan, TAHAPAN_DISERTASI_KELAYAKAN);
            ?>
            <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
            <?php
        elseif ($jenis == TAHAPAN_DISERTASI_TERTUTUP) :// UJIAN TERTUTUP

            $status = $this->disertasi->get_status_tahapan($tugas_akhir->status_tertutup, TAHAPAN_DISERTASI_TERTUTUP);
            ?>
            <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
            <?php
        elseif ($jenis == TAHAPAN_DISERTASI_TERBUKA) :// UJIAN TERBUKA

            $status = $this->disertasi->get_status_tahapan($tugas_akhir->status_terbuka, TAHAPAN_DISERTASI_TERBUKA);
            ?>
            <span class = "btn btn-xs <?php echo $status['color'] ?>"><?php echo $status['text'] ?></span>
            <?php
        endif;
    else:
        ?>
        <span class = "btn btn-xs btn-danger">Kosong</span>
    <?php
    endif;
}

