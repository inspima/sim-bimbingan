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
            table .padded tr th,table .padded tr td{
                padding: 8px;
            }
        </style>
    </head>
    <body>

	<?php $this->load->view('backend/widgets/common/header_document') ?>

        <table border="0" style="width:100%">

            <tr>
                <td>
                    <table border="0" style="width:100%">
                        <tr>
                            <td align="center"><h3 style="margin: 5px"><b>PENILAIAN UJIAN PROPOSAL</b></h3></td>
                        </tr>
                    </table> 
                </td>
            </tr>


            <tr>
                <td>
                    <table border="1" class="padded" style="width:100%;border-collapse: collapse;font-size: 1.2em">
                        <tr>
                            <td style="width:25%" align="left">NAMA</td>
                            <td style="width:2%" align="left">:</td>
                            <td style="width:50%" align="left"><?= $disertasi->nama ?></td>
                            <td colspan="2" style="width:23%" align="center">Nilai</td>
                        </tr>
                        <tr>
                            <td style="width:25%" align="left">NIM</td>
                            <td style="width:2%" align="left">:</td>
                            <td style="width:50%" align="left"><?= $disertasi->nim ?></td>
                            <td style="width:3%" align="center">4</td>
                            <td style="width:20%" align="center">Sangat Baik</td>
                        </tr>

                        <tr>
                            <td style="width:25%" align="left">PROGRAM STUDI</td>
                            <td style="width:2%" align="left">:</td>
                            <td style="width:50%" align="left"><?= $disertasi->nm_prodi ?></td>
                            <td style="width:3%" align="center">3</td>
                            <td style="width:20%" align="center">Baik</td>
                        </tr>

                        <tr>
                            <td style="width:25%" align="left">HARI, TANGGAL</td>
                            <td style="width:2%" align="left">:</td>
                            <td style="width:50%" align="left"><?php echo hari($jadwal->tanggal) ?>, <?php echo woday_toindo($jadwal->tanggal) ?></td>
                            <td style="width:3%" align="center">2</td>
                            <td style="width:20%" align="center">Cukup Baik</td>
                        </tr>
                        <tr>
                            <td style="width:20%" align="left">PUKUL</td>
                            <td style="width:2%" align="left">:</td>
                            <td style="width:50%" align="left"><?= substr($jadwal->jam, 0, 5); ?></td>
                            <td style="width:3%" align="center">1</td>
                            <td style="width:20%" align="center">Kurang</td>
                        </tr>
                    </table> 
                </td>
            </tr>
            <tr>
                <td>
                    <table border="1" class="padded" style="width:100%;border-collapse: collapse;font-size: 1.2em;margin-top: 20px">
                        <tr style="background-color: #ffffcc">
                            <th style="text-align: center" colspan="2">KOMPONEN PENILAIAN</th>
                            <th style="width: 25%;text-align: center">SKALA NILAI</th>
                            <th style="width: 25%;text-align: center">NILAI</th>
                        </tr>
                        <tr>
                            <td style="width:3%">A.</td>
                            <td style="width: 47%">Penguasaan Metodelogi Penelitian di Bidang Ilmunya :</td>
                            <td style="text-align: center">1-4</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="width:3%">B.</td>
                            <td style="width: 47%">Penguasaan Materi Bidang Ilmunya Baik Yang Bersifat Dasar Maupun Kekhususan  :</td>
                            <td style="text-align: center">1-4</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="width:3%">C.</td>
                            <td style="width: 47%">Kemampuan Penalaran Termasuk Kemampuan Untuk Mengadaan Abstraksi dan extrapolasi  :</td>
                            <td style="text-align: center">1-4</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="width:3%">D.</td>
                            <td style="width: 47%">Kemampuan Sistematisasi dan Perumusan Hasil Pemikiran : </td>
                            <td style="text-align: center">1-4</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="width:3%"></td>
                            <td style="width: 47%"></td>
                            <td style="text-align: center"><b>JUMLAH : </b>
                                <br/>
                                <br/>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><b>NILAI AKHIR : </b></td>
                            <td style="text-align: center">
                                <b>JUMLAH : </b>
                                <hr style="line-height: 2;margin: 2px"/>
                                4
                            </td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>


        </table>  

    </body>
</html>
