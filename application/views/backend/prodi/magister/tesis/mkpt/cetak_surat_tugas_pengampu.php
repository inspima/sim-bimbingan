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
            Dekan Fakultas Hukum Universitas Airlangga menugaskan Dosen yang namanya tercantum di bawah ini sebagai <b>Dosen Mata Kuliah Penunjang Tesis</b> pada Semester <?= explode(' ', $semester->semester)[0] ?> Tahun Akademik <?= explode(' ', $semester->semester)[1] ?> Mahasiswa Program Studi Magister <?= ucwords(strtolower($tesis->nm_prodi));?> Fakultas Hukum Universitas Airlangga, a.n<br>
            <b><?= $tesis->nama.' / NIM. '.$tesis->nim ?>.</b>
        </p>

        <table border="1" cellspacing="0" cellpadding="5" style="width:100%">   
            <tr align="center">
                <td><b>No.</b></td>
                <td><b>Nama</b></td>
                <td><b>Topik</b></td>
            </tr>
            <?php
            $tesis_mkpts = $this->tesis->read_tesis_mkpt($tesis->id_tesis); 
            $no = 0;   
            $hitung_nilai_publish = 0;
            if (!empty($tesis_mkpts)) {
                $sudah_publish_semua=$this->tesis->cek_mkpt_sudah_publish($tesis->id_tesis);
                foreach ($tesis_mkpts as $index => $mkpt) {
                    $mkpt_pengampus = $this->tesis->read_tesis_mkpt_pengampu($mkpt['id_tesis_mkpt']);
                    foreach ($mkpt_pengampus as $index_pengampu => $pengampu){
                        $no++;

                        echo '
                        <tr>
                            <td>'.$no.'</td>
                            <td>'.$pengampu['nama'].'<br>NIP. '.$pengampu['nip'].'</td>
                            <td>'.$mkpt['mkpt'].'</td>
                        </tr>
                        ';

                        ?>
                    <?php
                    }
                }
            }
            ?>
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