<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
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
        <!-- <table align="center" width="100%" border="0">
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
        </table> -->

        <?php $this->load->view('backend/widgets/common/header_document') ?>

        <p align="center">
            <u><h2>BERITA ACARA UJIAN PROPOSAL TESIS</h2></u>
        </p>
        <p align="justify">
            <?php
            if($tesis->id_prodi == S2_ILMU_HUKUM){
            ?>
            Pada hari <b><?php echo hari($jadwal->tanggal) ?>, <?php echo woday_toindo($jadwal->tanggal) ?></b> mulai pukul <b><?= substr($jadwal->jam, 0, 5); ?> - selesai</b> di Program Studi Magister <?= ucwords(strtolower($tesis->nm_prodi));?> Fakultas Hukum Universitas Airlangga diselenggarakan ujian proposal tesis atas nama :
            <?php
            }
            else if($tesis->id_prodi == S2_KENOTARIATAN){
            ?>
            Pada hari ini <?php echo hari($jadwal->tanggal) ?>, <?php echo woday_toindo($jadwal->tanggal) ?>  mulai pukul  <?= substr($jadwal->jam, 0, 5); ?> WIB sampai selesai di ruang Program Magister <?= $jadwal->ruang . ' Gedung ' . $jadwal->gedung ?> ( <?= $jadwal->link_zoom ? $jadwal->link_zoom : '';?> ) Fakultas Hukum Universitas Airlangga diselenggarakan Ujian Proposal Tesis :
            <?php
            }
            ?>
        </p>
        <table border="0" style="width:100%">
            <tr>
                <td>
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
                        <?php
                        if($tesis->id_prodi == S2_ILMU_HUKUM){
                        ?>
                        <tr>
                            <td>Minat</td>
                            <td>:</td>
                            <td><?php echo $tesis->nm_minat ?></td>
                        </tr>
                        <?php
                        }
                        else if($tesis->id_prodi == S2_KENOTARIATAN){
                        ?>
                        <tr>
                            <td>Program Studi</td>
                            <td>:</td>
                            <td>Magister <?php echo ucwords(strtolower($tesis->nm_prodi));?></td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td>Judul</td>
                            <td>:</td>
                            <td><?php echo $tesis->judul ?></td>
                        </tr>
                    </table> 
                </td>
            </tr>
            <tr>
                <td>
                    <table border="1" cellspacing="0" cellpadding="5" style="width:100%"> 
                        <tr>
                            <td>No.</td>
                            <td colspan="2">Penguji proposal tesis terdiri dari :</td>
                            <td colspan="2">Tanda tangan</td>
                        </tr>
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
                                    <td style="width: 4%"><?= $no ?>.</td>
                                    <td style="width: 30%"><?= $penguji['nama'] ?></td>
                                    <td style="width: 26%" align="center"><?= $status_tim ?></td>
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
                                                <?= $no ?>.
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
                                $status_tim = 'Pembimbing Utama / Anggota';
                                ?>
                                <tr style="line-height: 2">
                                    <td style="width: 4%"><?= $no ?>.</td>
                                    <td style="width: 30%"><?= $penguji['nama'] ?></td>
                                    <td style="width: 26%" align="center"><?= $status_tim ?></td>
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
                                $status_tim = 'Pembimbing Kedua / Anggota';
                                ?>
                                <tr style="line-height: 2">
                                    <td style="width: 4%"><?= $no ?>.</td>
                                    <td style="width: 30%"><?= $penguji['nama'] ?></td>
                                    <td style="width: 26%" align="center"><?= $status_tim ?></td>
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
                                $status_tim = 'Anggota';
                                ?>
                                <tr style="line-height: 2">
                                    <td style="width: 4%"><?= $no ?>.</td>
                                    <td style="width: 30%"><?= $penguji['nama'] ?></td>
                                    <td style="width: 26%" align="center"><?= $status_tim ?></td>
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
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" style="width:100%;margin-top: 10px">
                        <?php
                        $status_lanjut = '';
                        $keterangan = '';
                        if($tesis->status_ujian_proposal != ''){
                            if($tesis->status_ujian_proposal == '0'){
                                $status_lanjut = 'Dapat / Tidak Dapat *)';
                                $keterangan = '';
                            }
                            if($tesis->status_ujian_proposal == '1'){
                                 $status_lanjut = 'Dapat';
                                 $keterangan = '';
                            }
                            if($tesis->status_ujian_proposal == '3'){
                                 $status_lanjut = 'Tidak Dapat';
                                 if($tesis->id_prodi == S2_ILMU_HUKUM){
                                     $keterangan = '<br>Masih harus diuji kembali pada tanggal : '.$date_doc;
                                 }
                                 else if($tesis->id_prodi == S2_KENOTARIATAN){
                                    $keterangan = '<br>2. Masih harus diuji kembali pada tanggal : '.$date_doc;
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
                                    Memutuskan bahwa ujian proposal tesis bagi mahasiswa tersebut :
                                    <br><b><?= $status_lanjut?></b> dilanjutkan sebagai materi penelitiannya 
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
                                    Memutuskan bahwa ujian proposal tesis bagi peserta tersebut :
                                    <br>1. <?= $status_lanjut?> dilanjutkan sebagai materi penelitiannya 
                                    <?= $keterangan?>
                                </p>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" style="width:100%;margin-top: 30px">
                        <tr>
                            <td style="width: 60%">
                                <img src="<?= $qr_dokumen ?>" width="100px">
                            </td> 
                            <td style="width: 40%">
                                <p>
                                    Ketua Penguji Proposal Tesis
                                    <br/><br/><br/>
                                    <img src="<?= str_replace(base_url(), "", $this->tesis->read_penguji_id($ketua_penguji->id_penguji)[0]['ttd']) ?>" width="200px"/>
                                    <br/>
                                    <?= $this->tesis->read_penguji_id($ketua_penguji->id_penguji)[0]['nama']; ?><br/>
                                    NIP. <?= $this->tesis->read_penguji_id($ketua_penguji->id_penguji)[0]['nip']; ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table> 
        <?php
        if($tesis->id_prodi == S2_KENOTARIATAN){
        ?>
        <table>
            <tr>
                <td colspan="3">
                    <i>Catatan :</i>
                    <br>Penelitian dibimbing oleh 
                </td>
            </tr>
            <tr>
                <td>Pembimbing Ketua</td>
                <td>:</td>
                <td><?php echo $tesis->nama_pembimbing_satu; ?></td>
            </tr>
            <tr>
                <td>Pembimbing Kedua</td>
                <td>:</td>
                <td><?php echo $tesis->nama_pembimbing_dua; ?></td>
            </tr>
        </table>
        <?php
        }
        ?> 
    </body>
</html>