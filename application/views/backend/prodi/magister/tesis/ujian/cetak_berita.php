<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style type="text/css">
            body {
                margin: -30px 0px 0 0px;
                font-family: "Times New Roman", Times, serif;
                font-size: 14px;
            }
            .line {
                background-image: url("assets/backend/cetak/line.png");
                background-repeat: repeat-x;
            }
        </style>
    </head>
    <body>
        <table align="center" width="100%" border="0">
            <tbody>
                <tr>
                    <td width="10%"><img src="assets/backend/cetak/logo_unair.png" width="100px"></td>
                    <td width="90%" align="center">
                        <p style="font-size:20px;margin-bottom: 0px;">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN
                            <br>UNIVERSITAS AIRLANGGA
                            <br><b>FAKULTAS HUKUM</b><br>
                        </p>
                        <p style="font-size:13px;margin: 0px 0px 0px 0px;">
                            Kampus B, Jl. Dharmawangsa Dalam Selatan Surabaya 60286 Telp. (031) 5023151, 5023152 Fax. (031) 5020454<br>
                            Website: http://fh.unair.ac.id - Email: humas@fh.unair.ac.id 
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="line">&nbsp;
                    </td>
                </tr>
            </tbody>
        </table>
        <p align="center">
            <u><h2>BERITA ACARA UJIAN TESIS</h2></u>
        </p>
        <p align="justify">
            <?php
            if($tesis->id_prodi == S2_ILMU_HUKUM){
            ?>
            Berdasarkan Surat Keputusan Dekan Fakultas Hukum Universitas tanggal, <?php echo woday_toindo($jadwal->tanggal) ?> Nomor  337/UN3.1.3/KD/2020 tentang Pembimbing dan Penguji Tesis Semester Gasal Tahun Akademik 2020/2021 Program Magister Ilmu Hukum, maka pada hari Selasa, tanggal 19 Januari 2021 pukul  08.00 -09.00 WIB, melalui Video Conference (Google Meeting) pada laman https://meet.google.com/tas-smtp-ent, telah dilaksanakan Ujian Tesis dengan Tim Penguji Tesis yang terdiri atas :
            <?php
            }
            else if($tesis->id_prodi == S2_KENOTARIATAN){
            ?>
            Pada hari ini <?php echo hari($jadwal->tanggal) ?>, <?php echo woday_toindo($jadwal->tanggal) ?>  mulai pukul  <?= substr($jadwal->jam, 0, 5); ?> WIB sampai selesai di ruang Program Magister <?= $jadwal->ruang . ' Gedung ' . $jadwal->gedung ?> ( <?= $jadwal->link_zoom ? $jadwal->link_zoom : '';?> ) Fakultas Hukum Universitas Airlangga diselenggarakan Ujian Proposal Tesis :

            Berdasarkan Surat Keputusan Dekan Fakultas Hukum Universitas tanggal Nomor  19/UN3.1.3/KD/2020 tanggal <?php echo woday_toindo($jadwal->tanggal) ?>  tentang Pembimbing dan Penguji Tesis Semester Genap Tahun Akademik 2019/2020 Program Magister Kenotariatan, maka pada hari Kamis,  tanggal 19 Maret 2020  pukul  09.00 WIB di ruang Program Magister (R. 108) Gedung B Fakultas Hukum Universitas Airlangga.
            <?php
            }
            ?>
        </p>
        <table border="0" style="width:100%"> 
            <?php
            $no = 0;
            foreach ($pengujis as $penguji):
                $status_tim = '';
                if($penguji['status_tim'] == '1'){
                    $no++;
                    $status_tim = 'Ketua';
                    ?>
                    <tr style="line-height: 2">
                        <td rowspan="5" valign="top">Ketua</td>
                        <td rowspan="5" valign="top">:</td>
                        <td><?= $no ?>.</td>
                        <td><?= $penguji['nama'] ?></td>
                        <td><?= $status_tim ?></td>
                    </tr>
                <?php
                }
            endforeach;
            foreach ($pengujis as $penguji):
                if($penguji['nip'] == $tesis->nip_pembimbing_satu){
                    $no++;
                    $status_tim = 'Pembimbing Utama / Anggota';
                    ?>
                    <tr style="line-height: 2">
                        <td><?= $no ?>.</td>
                        <td><?= $penguji['nama'] ?></td>
                        <td><?= $status_tim ?></td>
                    </tr>
                <?php
                }
            endforeach;
            foreach ($pengujis as $penguji):
                if($penguji['nip'] == $tesis->nip_pembimbing_dua){
                    $no++;
                    $status_tim = 'Pembimbing Kedua / Anggota';
                    ?>
                    <tr style="line-height: 2">
                        <td><?= $no ?>.</td>
                        <td><?= $penguji['nama'] ?></td>
                        <td><?= $status_tim ?></td>
                    </tr>
                <?php
                }
            endforeach;
            foreach ($pengujis as $penguji):
                if($penguji['status_tim'] == '2' && $penguji['nip'] != $tesis->nip_pembimbing_satu && $penguji['nip'] != $tesis->nip_pembimbing_dua){
                    $no++;
                    $status_tim = 'Anggota';
                    ?>
                    <tr style="line-height: 2">
                        <td><?= $no ?>.</td>
                        <td><?= $penguji['nama'] ?></td>
                        <td><?= $status_tim ?></td>
                    </tr>
                <?php
                }
            endforeach;
            ?>
        </table> 
        <br><br>
        <table border="0" style="width:100%">
            <tr>
                <td>Nama Mahasiswa</td>
                <td>:</td>
                <td><?php echo $tesis->nama ?></td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>:</td>
                <td><?php echo $tesis->nim ?></td>
            </tr>
            <tr>
                <td>Judul</td>
                <td>:</td>
                <td><?php echo $tesis->judul ?></td>
            </tr>
        </table>
        <br><br>
        <table border="1" cellspacing="0" cellpadding="5" style="width:100%"> 
            <tr>
                <td align="center"><b>KRITERIA PENILAIAN</b></td>
                <td align="center"><b>TIM PENGUJI TESIS</b></td>
                <td align="center"><b>SKOR</b></td>
                <td align="center"><b>SKOR TERBOBOT</b></td>
            </tr>
            <tr>
                <td rowspan="6" align="center">
                    Format Penulisan = 20 %
                    Substansi = 30 %
                    Argumentasi = 50 %
                    Skor Total = 100 %
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><b>NILAI TESIS</b></td>
                <td></td>
            </tr>
        </table>
    </body>
</html>