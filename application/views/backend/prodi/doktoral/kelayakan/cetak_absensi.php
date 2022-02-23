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
                padding: 10px;
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
                            <td align="center"><h3 style="margin: 5px"><b>DAFTAR HADIR</b></h3></td>
                        </tr>
                    </table> 
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" class="padded" style="width:100%;">
                        <tr>
                            <td style="width: 20%">Hari, Tanggal</td>
                            <td style="width: 3%">:</td>
                            <td style="width: 77%"><?php echo hari($jadwal->tanggal) ?>, <?php echo woday_toindo($jadwal->tanggal) ?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%">Pukul</td>
                            <td style="width: 3%">:</td>
                            <td style="width: 77%"><?= substr($jadwal->jam, 0, 5); ?> - Selesai</td>
                        </tr>
                        <tr>
                            <td style="width: 20%">Ruang</td>
                            <td style="width: 3%">:</td>
                            <td style="width: 77%">Ruang <?= $jadwal->ruang . ' Gedung ' . $jadwal->gedung ?></td>
                        </tr> 
                        <tr>
                            <td style="width: 20%">Acara</td>
                            <td style="width: 3%">:</td>
                            <td style="width: 77%">Ujian Kelayakan Mahasiswa <?= $disertasi->nama ?> (<?= $disertasi->nim ?>)</td>
                        </tr>
                    </table> 
                </td>
            </tr>
            <tr>
                <td>
                    <table border="1" class="padded" style="width:100%;border-collapse: collapse;margin-top: 20px;font-size: 1.2em">
                        <tr style="background-color: #cccccc">
                            <th style="width:10%">NO</th>
                            <th style="width:60%;text-align: center">NAMA</th>
                            <th style="width:30%;text-align: center">TTD</th>
                        </tr>
                        <?php for ($i = 1; $i < 10; $i++):
                            ?>
                            <tr>
                                <td style="text-align: center"><?= $i ?>.</td>
                                <td></td>
                                <td><?= $i ?>.</td>
                            </tr>
                            <?php
                        endfor;
                        ?>
                    </table>
                </td>
            </tr>
        </table>  

    </body>
</html>
