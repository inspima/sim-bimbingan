<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <style type="text/css">
            body {
                margin: -30px 0px 0 0px;
                font-family: "Times New Roman", Times, serif;
                font-size: 12pt;
            }
            .line {
                background-image: url("assets/backend/cetak/line.png");
                background-repeat: repeat-x;
            }
        </style>
    </head>
    <body>
        <?php
        $index = 1;
        foreach ($pengujis as $penguji):
            ?>
            <table align="center" width="100%" border="0">
                <tbody>
                    <tr>
                        <td width="10%"><img src="assets/backend/cetak/logo.png" width="100px"></td>
                        <td width="90%" align="center">
                            <strong><p style="font-size:17px;margin-bottom: 0px;">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN<br>
                                    UNIVERSITAS AIRLANGGA<br>
                                    FAKULTAS HUKUM<br></p>
                            </strong><p style="font-size:14px;margin: 0px 0 0px 0;">Kampus B, Jl. Dharmawangsa Dalam Selatan Surabaya 60286 Telp. (031) 5023151, 5023152 Fax. (031) 5020454<br>
                                Website: http://fh.unair.ac.id - Email: humas@fh.unair.ac.id </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="line">&nbsp;
                        </td>
                    </tr>
                </tbody>
            </table>

            <table border="0" style="width:100%">            
                <tr>
                    <td>
                        <table border="0" style="width:100%">
                            <tr>
                                <td style="width:5%"></td>
                                <td style="width:13%">
                                    Nomor
                                </td>
                                <td style="width:2%">:</td>
                                <td style="width:75%">
                                    <b>000<?php echo rand(1, 9) ?>/UN3.1.3/PK/<?php echo date('Y') ?></b>
                                </td>
                                <td style="width:5%;text-align: right">
                                    .......................
                                </td>
                            </tr>
                            <tr>
                                <td style="width:5%"></td>
                                <td style="width:13%">
                                    Lampiran
                                </td>
                                <td style="width:2%">:</td>
                                <td style="width:80%" colspan="2">
                                    1 berkas
                                </td>
                            </tr>
                            <tr>
                                <td style="width:5%"></td>
                                <td style="width:13%;vertical-align: text-top">
                                    Perihal
                                </td>
                                <td style="width:2%;vertical-align: text-top">:</td>
                                <td style="width:80%;vertical-align: text-top" colspan="2">
                                    <p style="margin: 0px;margin-bottom: 20px">
                                        UNDANGAN PENYANGGAH
                                    </p>
                                    <table border="0" style="width:100%">
                                        <tr>
                                            <td style="width:8%">Yth.</td>
                                            <td style="width:50%"><?php echo $penguji['nama'] ?><td>
                                            <td style="width:43%"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:8%">Di -</td>
                                            <td style="width:50%"><td>
                                            <td style="width:43%"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:8%">Tempat</td>
                                            <td style="width:50%"><td>
                                            <td style="width:43%"></td>
                                        </tr>
                                    </table>
                                    <p>Mengharap kehadiran Saudara sebagai Undangan Akademik Ujian Doktor Terbuka atas nama <b> <?= $disertasi->nama ?></b> /NIM.  <b> <?= $disertasi->nim ?></b> yang akan diselenggarakan pada :</p>
                                    <table border="0" style="width:100%">
                                        <tr>
                                            <td style="width:8%"></td>
                                            <td style="width:27%">Hari, tanggal</td>
                                            <td style="width:3%">:</td>
                                            <td style="width:60%"><?php echo hari($jadwal->tanggal) ?>,  <?php echo woday_toindo($jadwal->tanggal) ?><td>
                                        </tr>
                                        <tr>
                                            <td style="width:8%"></td>
                                            <td style="width:27%">Pukul</td>
                                            <td style="width:3%">:</td>
                                            <td style="width:60%"><?= substr($jadwal->jam, 0, 5); ?> - Selesai<td>
                                        </tr>
                                        <tr>
                                            <td style="width:8%"></td>
                                            <td style="width:27%">Tempat</td>
                                            <td style="width:3%">:</td>
                                            <td style="width:60%"><?= $jadwal->ruang . ' Gedung ' . $jadwal->gedung ?><td>
                                        </tr>
                                    </table>
                                    <p>Atas kehadirannya kami sampaikan terima kasih.</p>
                                </td>
                            </tr>
                        </table> 
                    </td>
                </tr>

                <tr>
                    <td>
                        <table border="0" style="width:100%;margin-top: 30px">
                            <tr>
                                <td style="width: 60%">

                                </td> 
                                <td style="width: 40%">
                                    <p>
                                        a.n. Dekan<br/>
                                        Wakil Dekan I,
                                        <br/><br/><br/><br/><br/><br/>
                                        <?= $wadek1->nama_dosen ?><br/>
                                        NIP. <?= $wadek1->nip ?>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>


            </table>  
            <?php
            if ($index < count($pengujis)):
                ?>
                <div style="page-break-after:always;"></div>
                <?php
            endif;
            ?>
            <?php
            $index++;
        endforeach;
        ?>
    </body>
</html>