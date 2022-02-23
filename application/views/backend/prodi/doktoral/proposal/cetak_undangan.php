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

	<?php $this->load->view('backend/widgets/common/header_document') ?>

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
                                    Mohon Kesediaan untuk menjadi Penguji<br/>
                                    Pada Ujian Proposal
                                </p>
                                <table border="0" style="width:100%">
                                    <?php
                                    $no = 1;
                                    foreach ($promotors as $promotor):
                                        if ($no == 1):
                                            ?>
                                            <tr>
                                                <td style="width:8%">Yth.</td>
                                                <td style="width:50%"><?= $no ?>. <?php echo $promotor['nama'] ?><td>
                                                <td style="width:43%">(Promotor)</td>
                                            </tr>
                                            <?php
                                        else:
                                            ?>
                                            <tr>
                                                <td style="width:8%"></td>
                                                <td style="width:50%"><?= $no ?>. <?php echo $promotor['nama'] ?><td>
                                                <td style="width:43%">(Ko-Promotor)</td>
                                            </tr>
                                        <?php
                                        endif;
                                        $no++;
                                    endforeach;
                                    ?>
                                    <?php
                                    foreach ($pengujis as $penguji):
                                        if ($no == count($promotors) + 1):
                                            ?>
                                            <tr>
                                                <td style="width:8%"></td>
                                                <td style="width:50%"><?= $no ?>. <?php echo $penguji['nama'] ?><td>
                                                <td style="width:43%">(Ketua)</td>
                                            </tr>
                                            <?php
                                        else:
                                            ?>
                                            <tr>
                                                <td style="width:8%"></td>
                                                <td style="width:50%"><?= $no ?>. <?php echo $penguji['nama'] ?><td>
                                                <td style="width:43%">(Anggota)</td>
                                            </tr>
                                        <?php
                                        endif;
                                        $no++;
                                    endforeach;
                                    ?>
                                </table>
                                <p>Sehubungan dengan akan dilaksanakannya Ujian Proposal Mahasiswa Program Doktor Program Studi Ilmu Hukum Fakultas Hukum Universitas Airlangga :</p>
                                <table border="0" style="width:100%">
                                    <tr>
                                        <td style="width:8%"></td>
                                        <td style="width:27%">NAMA</td>
                                        <td style="width:3%">:</td>
                                        <td style="width:60%"><?= $disertasi->nama ?><td>
                                    </tr>
                                    <tr>
                                        <td style="width:8%"></td>
                                        <td style="width:27%">NIM</td>
                                        <td style="width:3%">:</td>
                                        <td style="width:60%"><?= $disertasi->nim ?><td>
                                    </tr>
                                    <tr>
                                        <td style="width:8%"></td>
                                        <td style="width:27%">JUDUL</td>
                                        <td style="width:3%">:</td>
                                        <td style="width:60%"><?= $disertasi->judul ?><td>
                                    </tr>
                                    <tr>
                                        <td style="width:8%"></td>
                                        <td style="width:27%">Promotor</td>
                                        <td style="width:3%">:</td>
                                        <td style="width:60%">
                                            <?php
                                            foreach ($promotors as $promotor):
                                                if ($promotor['status_tim'] == '1'):
                                                    ?>
                                                    <?php echo $promotor['nama'] ?>
                                                    <?php
                                                endif;
                                            endforeach;
                                            ?>
                                        <td>
                                    </tr>
                                    <tr>
                                        <td style="width:8%"></td>
                                        <td style="width:27%">Kopromotor</td>
                                        <td style="width:3%">:</td>
                                        <td style="width:60%">
                                            <?php
                                            $no = 1;
                                            foreach ($promotors as $promotor):
                                                if ($promotor['status_tim'] == '2'):
                                                    ?>
                                                    <?php echo $no . '. ' . $promotor['nama'] ?>
                                                    <?php
                                                    $no++;
                                                endif;
                                            endforeach;
                                            ?>
                                        <td>
                                    </tr>
                                </table>
                                <p>Ujian Proposal dilaksanakan pada :</p>
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
                                <p>Maka dengan ini mohon kesediaan Saudara untuk menjadi Penguji pada Ujian Proposal tersebut.</p>
                                <p>Atas perhatian Saudara, kami sampaikan terima kasih.</p>
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
                                    <br/>
									<?php $this->load->view('backend/widgets/common/element_ttd',['ttd'=>$wadek1->ttd]) ?>
									<br/>
                                    <?= $wadek1->nama_dosen ?><br/>
                                    NIP. <?= $wadek1->nip ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>


        </table>  

    </body>
</html>
