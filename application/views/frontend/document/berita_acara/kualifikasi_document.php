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
                            <td align="center"><h3><b>BERITA ACARA UJIAN KUALIFIKASI</b></h3></td>
                        </tr>
                    </table> 
                </td>
            </tr>

            <tr>
                <td>
                    <table border="0" style="width:100%">
                        <tr>
                            <td>
                                <p style="line-height: 2;margin: 5px">Pada hari ini <b><?php echo hari($jadwal->tanggal) ?></b> Tanggal <b> <?php echo woday_toindo($jadwal->tanggal) ?></b> pukul <b><?= substr($jadwal->jam, 0, 5); ?> - Selesai</b> WIB di <b>Ruang <?= $jadwal->ruang . ' Gedung ' . $jadwal->gedung ?></b> Fakultas Hukum Universitas Airlangga, dilaksanakan Ujian Kualifikasi :</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" style="width:100%">
                        <tr>
                            <td style="width:3%">

                            </td>
                            <td style="width:10%">
                                NAMA
                            </td>
                            <td style="width:2%">:</td>
                            <td style="width:85%">

                                <b><?php echo $disertasi->nama ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:3%">

                            </td>
                            <td style="width:10%">
                                NIM
                            </td>
                            <td style="width:2%">:</td>
                            <td style="width:85%">
                                <b><?php echo $disertasi->nim ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:3%">

                            </td>
                            <td style="width:10%">
                                JUDUL
                            </td>
                            <td style="width:2%">:</td>
                            <td style="width:85%">
                                <b><?php echo $disertasi->judul ?></b>
                            </td>
                        </tr>
                    </table> 
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" style="width:100%;margin-top: 10px">
                        <tr>
                            <td>
                                <p style="line-height: 2">Panitia Penilai Ujian Kualifikasi terdiri dari </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" style="width:80%;margin-left: 10px">
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
                                        <?php if (!empty($dokumen_persetujuan[$no - 1]['waktu'])):
                                            ?>
                                            <?= $no ?>.
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
                                            <?= $no ?>.<img src="<?= $dokumen_persetujuan[$no - 1]['qr_image'] ?>" width="70px"/>
                                        <?php
                                        endif;
                                        ?>
                                    </td>
                                    <?php
                                else:
                                    ?>
                                    <td style = "width: 20%;text-align: left;">
                                        <?php if (!empty($dokumen_persetujuan[$no - 1]['waktu'])):
                                            ?>
                                            <?= $no ?>.
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
                                            <?= $no ?>.<img src="<?= $dokumen_persetujuan[$no - 1]['qr_image'] ?>" width="70px"/>
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
                            $no++;
                        endforeach;
                        ?>


                    </table>
                </td>
            </tr>

            <tr>
                <td>
                    <table border="0" style="width:100%;margin-top: 10px">
                        <tr>
                            <td>
                                <p style="line-height: 2">Memutuskan bahwa Ujian Kualifikasi bagi mahasiswa tersebut :  </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left: 10px;line-height: 1.5">
                                a.LULUS dengan Nilai : ……………  
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left: 10px;line-height: 1.5">
                                b.MENGULANG KEMBALI : ……………  
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left: 10px;line-height: 1.5">
                                c.GAGAL STUDI karena TIDAK LULUS pada UJIAN KEDUA : ……………  
                            </td>
                        </tr>
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
                                <p>
                                    Ketua Panitia.
                                    <?php
                                    if ($setujui_semua):
                                        if (!empty($ketua_penguji->ttd)) {
                                            ?>
                                            <br/><br/>
                                            <img src="<?= str_replace(base_url(), "", $ketua_penguji->ttd) ?>" width="100px"/>
                                            <br/>
                                            <?php
                                        } else {
                                            ?>
                                            <br/><br/><br/>
                                            <font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
                                            <br/><br/>
                                            <?php
                                        }
                                    else:
                                        ?>
                                        <br/><br/><br/><br/><br/><br/>
                                    <?php
                                    endif;
                                    ?>
                                    <?= $ketua_penguji->nama ?><br/>
                                    NIP. <?= $ketua_penguji->nip ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>


        </table>  

    </body>
</html>