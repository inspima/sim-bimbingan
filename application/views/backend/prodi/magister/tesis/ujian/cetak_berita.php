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
                        <p style="font-size:20px;margin-bottom: 0px;">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI
                            <br>UNIVERSITAS AIRLANGGA
                            <br><b>FAKULTAS HUKUM</b><br>
                        </p>
                        <p style="font-size:13px;margin: 0px 0px 0px 0px;">
                            Kampus B, Jl. Dharmawangsa Dalam Selatan Surabaya 60286 Telp. (031) 5023151, 5023152 Fax. (031) 5020454<br>
                            Laman: http://fh.unair.ac.id - Email: humas@fh.unair.ac.id 
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
            Berdasarkan Surat Keputusan Dekan Fakultas Hukum Universitas  Nomor <?= $no_sk?> tanggal <?= woday_toindo($tgl_sk)?>  tentang Pembimbing dan Penguji Tesis Semester <?= ($semester ? explode(' ', $semester->semester)[0] : '') ?> Tahun Akademik <?= ($semester ? explode(' ', $semester->semester)[1] : ''); ?> Program Magister <?= ucwords(strtolower($tesis->nm_prodi));?>, maka pada hari <?php echo hari($jadwal->tanggal) ?>,  tanggal <?php echo woday_toindo($jadwal->tanggal) ?> pukul  <?php echo substr($jadwal->jam, 0, 5); ?> WIB di ruang Program Magister <?php echo $jadwal->ruang . ' Gedung ' . $jadwal->gedung ?> ( <?php echo $jadwal->link_zoom ? $jadwal->link_zoom : '';?> ) Fakultas Hukum Universitas Airlangga.
            <?php
            }
            else if($tesis->id_prodi == S2_KENOTARIATAN){
            ?>
            Berdasarkan Surat Keputusan Dekan Fakultas Hukum Universitas  Nomor <?= $no_sk?> tanggal <?= woday_toindo($tgl_sk)?>  tentang Pembimbing dan Penguji Tesis Semester <?= ($semester ? explode(' ', $semester->semester)[0] : '') ?> Tahun Akademik <?= ($semester ? explode(' ', $semester->semester)[1] : ''); ?> Program Magister <?= ucwords(strtolower($tesis->nm_prodi));?>, maka pada hari <?php echo hari($jadwal->tanggal) ?>,  tanggal <?php echo woday_toindo($jadwal->tanggal) ?> pukul  <?php echo substr($jadwal->jam, 0, 5); ?> WIB di ruang Program Magister <?php echo $jadwal->ruang . ' Gedung ' . $jadwal->gedung ?> ( <?php echo $jadwal->link_zoom ? $jadwal->link_zoom : '';?> ) Fakultas Hukum Universitas Airlangga.

            <br>

            Tim Penguji Tesis yang terdiri atas :
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
        <br>
        <p align="justify">
            <table border="0" style="width:100%;margin-top: 10px">
                <?php
                $status_lanjut = '';
                $keterangan = '';
                if($tesis->status_ujian_tesis != ''){
                    if($tesis->status_ujian_tesis == '0'){
                        $status_lanjut = '1. Lulus dengan nilai  (0 – 100) *) : ' . ($jadwal->nilai_ujian ? number_format($jadwal->nilai_ujian,1) : 0);
                        $keterangan = '';
                    }
                    if($tesis->status_ujian_tesis == '1'){
                         $status_lanjut = '1. Lulus dengan nilai  (0 – 100) *) : ' . ($jadwal->nilai_ujian ? number_format($jadwal->nilai_ujian,1) : 0);
                         $keterangan = '';
                    }
                    if($tesis->status_ujian_tesis == '3'){
                         $status_lanjut = '1. Lulus dengan nilai  (0 – 100) *) : ' . ($jadwal->nilai_ujian ? number_format($jadwal->nilai_ujian,1) : 0);
                         if($tesis->id_prodi == S2_ILMU_HUKUM){
                             $keterangan = '<br><br>2. Masih harus diuji kembali pada tanggal : '.$date_doc;
                         }
                         else if($tesis->id_prodi == S2_KENOTARIATAN){
                            $keterangan = '<br><br>2. Masih harus diuji kembali pada tanggal : '.$date_doc;
                         }
                    }
                }
                else {
                     $status_lanjut = 'Dapat / Tidak Dapat *)';
                     $keterangan = '';
                }
                ?>
                <?php
                if($tesis->id_prodi == S2_ILMU_HUKUM){
                ?>
                <tr>
                    <td>
                        <p>
                            Setelah Ujian dilaksanakan Tim Penguji Tesis memutuskan bahwa mahasiswa tersebut diatas dinyatakan :
                            <br><br>
                            <?= $status_lanjut?>
                            <?= $keterangan?>
                        </p>
                    </td>
                </tr>
                <?php
                }
                else if($tesis->id_prodi == S2_KENOTARIATAN){
                ?>
                <tr>
                    <td>
                        <p>
                            Setelah Ujian dilaksanakan Tim Penguji Tesis memutuskan bahwa mahasiswa tersebut diatas dinyatakan :
                            <br><br>
                            <?= $status_lanjut?> 
                            <?= $keterangan?>
                        </p>
                    </td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <td>
                        <p>
                            Tanda tangan Panitia Penguji :
                        </p>
                    </td>
                </tr>
            </table>
            <table border="0" cellspacing="0" cellpadding="5" style="width:100%"> 
                <?php
                $no = 0;
                $urut = 0;
                $ttd_waktu = '';
                foreach ($pengujis as $penguji):
                    $urut++;
                    if($dokumen_persetujuan[$urut-1]['identitas'] == $penguji['nip']){
                        $ttd_waktu = $dokumen_persetujuan[$urut-1]['waktu'];
                    }
                    $status_tim = '';
                    if($penguji['status_tim'] == '1'){
                        $no++;
                        $status_tim = 'Ketua';
                        ?>
                        <tr style="line-height: 2">
                            <td><?= $status_tim ?></td>
                            <td>:</td>
                            <td style = "width: 50%"><?= $no ?>. <?= $penguji['nama'] ?></td>
                            <?php if ($no % 2 == 0):
                                ?>
                                <td style = "width: 20%"></td>
                                <td style = "width: 20%;text-align: left;">
                                    <?php 
                                    if ($ttd_waktu != ''):
                                    //if (!empty($dokumen_persetujuan[$no - 1]['waktu'])):
                                        ?>
                                        <?php
                                        if (!empty($penguji['ttd'])) {
                                            ?>
                                            <img src="<?= str_replace(base_url(), "", $penguji['ttd']) ?>" width="70px"/>
                                            <?php
                                        } else {
                                            ?>
                                            <font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    else:
                                        ?>
                                         
                                    <?php
                                    endif;
                                    ?>
                                </td>
                                <?php
                            else:
                                ?>
                                <td style = "width: 20%;text-align: left;">
                                    <?php 
                                    if ($ttd_waktu != ''):
                                    //if (!empty($dokumen_persetujuan[$no - 1]['waktu'])):
                                        ?>
                                        <?php
                                        if (!empty($penguji['ttd'])) {
                                            ?>
                                            <img src="<?= str_replace(base_url(), "", $penguji['ttd']) ?>" width="70px"/>
                                            <?php
                                        } else {
                                            ?>
                                            <font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    else:
                                        ?>
                                         
                                    <?php
                                    endif;
                                    ?>
                                </td>
                                <td style = "width: 20%"></td>
                            <?php
                            endif;
                            ?>
                        </tr>
                    <?php
                    }
                endforeach;
                $urut = 0;
                $ttd_waktu = '';
                foreach ($pengujis as $penguji):
                    $urut++;
                    if($dokumen_persetujuan[$urut-1]['identitas'] == $penguji['nip']){
                        $ttd_waktu = $dokumen_persetujuan[$urut-1]['waktu'];
                    }
                    if($penguji['nip'] == $tesis->nip_pembimbing_satu){
                        $no++;
                        $status_tim = 'Anggota';
                        ?>
                        <tr style="line-height: 2">
                            <td><?= $status_tim ?></td>
                            <td>:</td>
                            <td><?= $no ?>. <?= $penguji['nama'] ?></td>
                            <?php if ($no % 2 == 0):
                                ?>
                                <td style = "width: 20%"></td>
                                <td style = "width: 20%;text-align: left;">
                                    <?php 
                                    if ($ttd_waktu != ''):
                                    //if (!empty($dokumen_persetujuan[$no - 1]['waktu'])):
                                        ?>
                                        <?php
                                        if (!empty($penguji['ttd'])) {
                                            ?>
                                            <img src="<?= str_replace(base_url(), "", $penguji['ttd']) ?>" width="70px"/>
                                            <?php
                                        } else {
                                            ?>
                                            <font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    else:
                                        ?>
                                         
                                        <?= $no ?>.
                                    <?php
                                    endif;
                                    ?>
                                </td>
                                <?php
                            else:
                                ?>
                                <td style = "width: 20%;text-align: left;">
                                    <?php 
                                    if ($ttd_waktu != ''):
                                    //if (!empty($dokumen_persetujuan[$no - 1]['waktu'])):
                                        ?>
                                        <?php
                                        if (!empty($penguji['ttd'])) {
                                            ?>
                                            <img src="<?= str_replace(base_url(), "", $penguji['ttd']) ?>" width="70px"/>
                                            <?php
                                        } else {
                                            ?>
                                            <font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    else:
                                        ?>
                                         
                                    <?php
                                    endif;
                                    ?>
                                </td>
                                <td style = "width: 20%"></td>
                            <?php
                            endif;
                            ?>
                        </tr>
                    <?php
                    }
                endforeach;
                $urut = 0;
                $ttd_waktu = '';
                foreach ($pengujis as $penguji):
                    $urut++;
                    if($dokumen_persetujuan[$urut-1]['identitas'] == $penguji['nip']){
                        $ttd_waktu = $dokumen_persetujuan[$urut-1]['waktu'];
                    }
                    if($penguji['nip'] == $tesis->nip_pembimbing_dua){
                        $no++;
                        ?>
                        <tr style="line-height: 2">
                            <td></td>
                            <td></td>
                            <td><?= $no ?>. <?= $penguji['nama'] ?></td>
                            <?php if ($no % 2 == 0):
                                ?>
                                <td style = "width: 20%"></td>
                                <td style = "width: 20%;text-align: left;">
                                    <?php 
                                    if ($ttd_waktu != ''):
                                    //if (!empty($dokumen_persetujuan[$no - 1]['waktu'])):
                                        ?>
                                        <?php
                                        if (!empty($penguji['ttd'])) {
                                            ?>
                                            <img src="<?= str_replace(base_url(), "", $penguji['ttd']) ?>" width="70px"/>
                                            <?php
                                        } else {
                                            ?>
                                            <font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    else:
                                        ?>
                                         
                                    <?php
                                    endif;
                                    ?>
                                </td>
                                <?php
                            else:
                                ?>
                                <td style = "width: 20%;text-align: left;">
                                    <?php 
                                    if ($ttd_waktu != ''):
                                    //if (!empty($dokumen_persetujuan[$no - 1]['waktu'])):
                                        ?>
                                        <?php
                                        if (!empty($penguji['ttd'])) {
                                            ?>
                                            <img src="<?= str_replace(base_url(), "", $penguji['ttd']) ?>" width="70px"/>
                                            <?php
                                        } else {
                                            ?>
                                            <font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    else:
                                        ?>
                                         
                                    <?php
                                    endif;
                                    ?>
                                </td>
                                <td style = "width: 20%"></td>
                            <?php
                            endif;
                            ?>
                        </tr>
                    <?php
                    }
                endforeach;
                $urut = 0;
                $ttd_waktu = '';
                foreach ($pengujis as $penguji):
                    $urut++;
                    if($dokumen_persetujuan[$urut-1]['identitas'] == $penguji['nip']){
                        $ttd_waktu = $dokumen_persetujuan[$urut-1]['waktu'];
                    }
                    if($penguji['status_tim'] == '2' && $penguji['nip'] != $tesis->nip_pembimbing_satu && $penguji['nip'] != $tesis->nip_pembimbing_dua){
                        $no++;
                        ?>
                        <tr style="line-height: 2">
                            <td></td>
                            <td></td>
                            <td><?= $no ?>. <?= $penguji['nama'] ?></td>
                            <?php if ($no % 2 == 0):
                                ?>
                                <td style = "width: 20%"></td>
                                <td style = "width: 20%;text-align: left;">
                                    <?php 
                                    if ($ttd_waktu != ''):
                                    //if (!empty($dokumen_persetujuan[$no - 1]['waktu'])):
                                        ?>
                                        <?php
                                        if (!empty($penguji['ttd'])) {
                                            ?>
                                            <img src="<?= str_replace(base_url(), "", $penguji['ttd']) ?>" width="70px"/>
                                            <?php
                                        } else {
                                            ?>
                                            <font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    else:
                                        ?>
                                         
                                    <?php
                                    endif;
                                    ?>
                                </td>
                                <?php
                            else:
                                ?>
                                <td style = "width: 20%;text-align: left;">
                                    <?php 
                                    if ($ttd_waktu != ''):
                                    //if (!empty($dokumen_persetujuan[$no - 1]['waktu'])):
                                        ?>
                                        <?php
                                        if (!empty($penguji['ttd'])) {
                                            ?>
                                            <img src="<?= str_replace(base_url(), "", $penguji['ttd']) ?>" width="70px"/>
                                            <?php
                                        } else {
                                            ?>
                                            <font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    else:
                                        ?>
                                         
                                    <?php
                                    endif;
                                    ?>
                                </td>
                                <td style = "width: 20%"></td>
                            <?php
                            endif;
                            ?>
                        </tr>
                    <?php
                    }
                endforeach;
                ?>
            </table>
            <br><br>
            Catatan :
            <br>
            *) Mohon untuk tidak memberikan nilai dalam huruf

        </p>
    </body>
</html>