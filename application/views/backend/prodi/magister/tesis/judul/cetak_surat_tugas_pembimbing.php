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
            <b><u>SURAT TUGAS</u></b>
            <br>Nomor : <?php echo $no_surat; ?>
        </p>
        <p align="justify">
            Menunjuk Surat Keputusan Dekan Fakultas Hukum Universitas Airlangga No. <?= $no_sk;?> tanggal <?= woday_toindo($tgl_sk); ?> tentang Pembimbing dan Penguji Tesis Program Studi Magister <?= ucwords(strtolower($tesis->nm_prodi));?> <?= explode(' ', $semester->semester)[0] ?> Tahun Akademik <?= explode(' ', $semester->semester)[1] ?>, dengan ini Dekan menugaskan Dosen yang namanya tersebut di bawah ini sebagai <b>Pembimbing Tesis</b> Mahasiswa Program Studi Magister <?= ucwords(strtolower($tesis->nm_prodi));?> Fakultas Hukum Universitas Airlangga, yang mengajukan bimbingan Tesis :
        </p>

        <table border="1" cellspacing="0" cellpadding="5" style="width:100%">   
            <tr align="center">
                <td><b>No.</b></td>
                <td><b>Dosen Pembimbing</b></td>
                <td><b>Mahasiswa</b></td>
                <td><b>Judul Tesis</b></td>
            </tr>
            <tr>
                <td>1.</td>
                <td>
                    <?= $tesis->nama_pembimbing_satu.'<br>NIP. '.$tesis->nip_pembimbing_satu.'<br><b>(Pembimbing Utama)</b>'; ?>
                </td>
                <td rowspan="2" valign="top">
                    <?= $tesis->nama.'<br>NIM. '.$tesis->nim ?> 
                </td>
                <td rowspan="2" valign="top">
                    <?php
                    $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_JUDUL);
                    echo $judul->judul;
                    ?>
                </td>
            </tr>
            <tr>
                <td>2.</td>
                <td>
                    <?= $tesis->nama_pembimbing_dua.'<br>NIP. '.$tesis->nip_pembimbing_dua.'<br><b>(Pembimbing Kedua)</b>'; ?>
                </td>
            </tr>
        </table>

        <table border="0" style="width:100%">            
            <tr>
                <td>
                    <table border="0" style="width:100%;margin-top: 30px">
                        <tr>
                            <td style="width: 55%">

                            </td> 
                            <td style="width: 45%">
                                <p>
                                    <?= woday_toindo(date('Y-m-d'))?><br>
                                    Dekan,
                                    <br/><br/><br/><br/><br/><br/>
                                    <?= $dekan ? $dekan->nama_dosen : 'Iman Prihandono, Ph.D.' ?><br/>
                                    NIP. <?= $dekan ? $dekan->nip : '197602042005011003' ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>  

    </body>
</html>