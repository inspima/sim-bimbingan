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
            <u><h2>PRESENSI UJIAN PROPOSAL TESIS</h2></u>
        </p>
        <table border="0" style="width:100%">
            <tr>
                <td>
                    <table border="0" style="width:100%">
                        <?php
                        if($tesis->id_prodi == S2_ILMU_HUKUM){
                        ?>
                        <tr>
                            <td>Hari, Tanggal</td>
                            <td>:</td>
                            <td><?php echo hari($jadwal->tanggal) ?>, <?php echo woday_toindo($jadwal->tanggal) ?></td>
                        </tr>
                        <tr>
                            <td>Ruang</td>
                            <td>:</td>
                            <td><?= $jadwal->ruang . ' Gedung ' . $jadwal->gedung ?></td>
                        </tr>
                        <tr>
                            <td>Pukul</td>
                            <td>:</td>
                            <td><?= substr($jadwal->jam, 0, 5); ?> - Selesai</td>
                        </tr>
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
                        <?php
                        }
                        else if($tesis->id_prodi == S2_KENOTARIATAN){
                        ?>
                        <tr>
                            <td>Hari/ Tanggal</td>
                            <td>:</td>
                            <td><?php echo hari($jadwal->tanggal) ?>, <?php echo woday_toindo($jadwal->tanggal) ?></td>
                        </tr>
                        <tr>
                            <td>Pukul</td>
                            <td>:</td>
                            <td><?= substr($jadwal->jam, 0, 5); ?> - Selesai</td>
                        </tr>
                        <tr>
                            <td>Tempat</td>
                            <td>:</td>
                            <td><?= $jadwal->ruang . ' Gedung ' . $jadwal->gedung ?></td>
                        </tr>
                        <tr valign="top">
                            <td>Acara</td>
                            <td>:</td>
                            <td>Ujian Proposal Tesis Program Magister <?php echo ucwords(strtolower($tesis->nm_prodi));?> a.n. <?php echo $tesis->nama ?> / NIM. <?php echo $tesis->nim ?> </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="1" cellspacing="0" cellpadding="5" style="width:100%">  
                        <tr>
                            <td>
                                <?php
                                if($tesis->id_prodi == S2_ILMU_HUKUM){
                                    echo 'NO.';
                                }
                                else if($tesis->id_prodi == S2_KENOTARIATAN){
                                    echo '<b>No.</b>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if($tesis->id_prodi == S2_ILMU_HUKUM){
                                    echo 'DOSEN PENGUJI';
                                }
                                else if($tesis->id_prodi == S2_KENOTARIATAN){
                                    echo '<b>Nama Penguji</b>';
                                }
                                ?>
                            </td>
                            <td colspan="2">
                                <?php
                                if($tesis->id_prodi == S2_ILMU_HUKUM){
                                    echo 'TTD';
                                }
                                else if($tesis->id_prodi == S2_KENOTARIATAN){
                                    echo '<b>Tanda Tangan</b>';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        $no = 1;
                        foreach ($pengujis as $penguji):
                            ?>
                            <tr style="line-height: 2">
                                <td style="width: 3%"><b><?= $no ?></b>.</td>
                                <td style="width: 58%"><?= $penguji['nama'] ?></td>
                                <?php if ($no % 2 == 0):
                                    ?>
                                    <td style = "width: 20%"></td>
                                    <td style = "width: 20%;text-align: left;">
                                        <img src="<?= str_replace(base_url(), "", $penguji['ttd']) ?>" width="70px"/>
                                    </td>
                                    <?php
                                else:
                                    ?>
                                    <td style = "width: 20%;text-align: left;">
                                        <img src="<?= str_replace(base_url(), "", $penguji['ttd']) ?>" width="70px"/>
                                    </td>
                                    <td style = "width: 20%"></td>
                                <?php
                                endif;
                                ?>
                            </tr>
                            <?php
                            $no++;
                        endforeach;
                        ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" style="width:100%;margin-top: 30px">
                        <tr>
                            <td style="width: 50%">
                                <img src="<?= $qr_dokumen ?>" width="100px">
                            </td> 
                            <td style="width: 50%">
                                <!-- <p>
                                    Ketua Panitia.<br/><br/><br/><br/><br/><br/>
                                    ..........................<br/>
                                    NIP. .............................
                                </p> -->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>  
    </body>
</html>