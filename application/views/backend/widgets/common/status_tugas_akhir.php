<?php
// S1
if (!in_array($mahasiswa['role'], [ROLE_MAHASISWA_S2, ROLE_MAHASISWA_S3])) {
    $tugas_akhir = $this->tugas_akhir->detail_skripsi($mahasiswa['nim']);
    if (!empty($tugas_akhir)) {
        $status = '';
        if ($tugas_akhir->status_proposal > 0) {
            $status = 'Proses Proposal';
        }
        if ($tugas_akhir->status_skripsi > 0) {
            $status = 'Proses Skripsi';
        }
        ?>
        <button class="btn btn-xs btn-primary"><?= $status ?></button>
        <?php
    } else {
        ?>
        <button class="btn btn-xs btn-danger">Belum ada Pengajuan</button>
        <?php
    }
} else if ($mahasiswa['role'] == ROLE_MAHASISWA_S2) {
    $tugas_akhir = $this->tugas_akhir->detail_tesis($mahasiswa['nim']);
    if (!empty($tugas_akhir)) {
        $status = '';
        if ($tugas_akhir->status_proposal > 0) {
            $status = 'Proses Proposal';
        }
        ?>
        <button class="btn btn-xs btn-primary"><?= $status ?></button>
        <?php
    } else {
        ?>
        <button class="btn btn-xs btn-danger">Belum ada Pengajuan</button>
        <?php
    }
} else if ($mahasiswa['role'] == ROLE_MAHASISWA_S3) {
    $tugas_akhir = $this->tugas_akhir->detail_disertasi($mahasiswa['nim']);
    if (!empty($tugas_akhir)) {
        $status = '';
        if ($tugas_akhir->status_kualifikasi > 0) {
            $status = 'Proses Ujian Kualifikasi';
        }
        if ($tugas_akhir->status_mpkk > 0) {
            $status = 'Proses MKPKK';
        }
        if ($tugas_akhir->status_proposal > 0) {
            $status = 'Proses Ujian Proposal';
        }
        if ($tugas_akhir->status_mkpd > 0) {
            $status = 'Proses MKPD';
        }
        if ($tugas_akhir->status_kelayakan > 0) {
            $status = 'Proses Ujian Kelayakan';
        }
        if ($tugas_akhir->status_tertutup > 0) {
            $status = 'Proses Ujian Tertutup';
        }
        if ($tugas_akhir->status_terbuka > 0) {
            $status = 'Proses Ujian Terbuka';
        }
        ?>
        <button class="btn btn-xs btn-primary"><?= $status ?></button>
        <?php
    } else {
        ?>
        <button class="btn btn-xs btn-danger">Belum ada Pengajuan</button>
        <?php
    }
}

