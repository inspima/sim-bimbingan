<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <style type="text/css">
            body {
                margin: -10px 0px 0 0px;
                font-family: "Times New Roman", Times, serif;
                /*font-size: 12pt;*/
            }
            .line {
                background-image: url("assets/backend/cetak/line.png");
                background-repeat: repeat-x;
            }
        </style>
    </head>
    
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
                    ?>
                <body>
                    <p align="center" style="font-size: 20pt;">
                        FORM PENILAIAN MKPT <?= $no; ?>
                    </p>
                    <p align="justify" style="font-size: 12pt;">
                        Pada hari ini <?= hari(date('Y-m-d', strtotime($mkpt['waktu_update']))); ?>, <?= woday_toindo(date('Y-m-d', strtotime($mkpt['waktu_update'])));?> mulai pukul <?= str_replace(':', '.', substr(date('H:i:s', strtotime($mkpt['waktu_update'])), 0, 5)); ?> WIB sampai selesai di Program Studi Magister <?= ucwords(strtolower($tesis->nm_prodi));?> Fakultas Hukum Universitas Airlangga diselenggarakan ujian mata kuliah penunjang tesis atas :

                        <table>
                            <tr>
                                <td style="padding-left: 0px;">Nama</td>
                                <td>:</td>
                                <td><?= $tesis->nama; ?></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px;">NIM</td>
                                <td>:</td>
                                <td><?= $tesis->nim; ?></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px;">Minat Studi/Kelas</td>
                                <td>:</td>
                                <td><?= $tesis->nm_minat; ?></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px;">Topik</td>
                                <td>:</td>
                                <td><?= $mkpt['mkpt']; ?></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px;">Dosen MKPT</td>
                                <td>:</td>
                                <td><?= $pengampu['nama']; ?></td>
                            </tr>
                        </table>
                        <br><br>
                        Memutuskan bahwa ujian mata kuliah penunjang tesis bagi peserta tersebut :
                        <?php
                        if($pengampu['status'] == '1'){
                            $status = 'Lulus';
                        }
                        else if($pengampu['status'] == '2'){
                            $status = 'Tidak Lulus';
                        }
                        else {
                            $status = '';
                        }
                        if($status != ''){
                        ?>
                            <table>
                                <tr>
                                    <td style="padding-left: 0px;"><?= $status; ?> dengan nilai</td>
                                    <td>:</td>
                                    <td><?= $pengampu['nilai_angka']; ?></td>
                                </tr>
                                <?php
                                if($status == 'Tidak Lulus'){
                                ?>
                                <tr>
                                    <td style="padding-left: 0px;">Masih harus diuji kembali pada tanggal</td>
                                    <td>:</td>
                                    <td>.......................................................................................</td>
                                </tr>
                                <?php
                                }
                                ?>
                            </table>
                        <?php
                        }
                        ?>
                        <table border="0" style="width:100%">            
                            <tr>
                                <td>
                                    <table border="0" style="width:100%;margin-top: 30px">
                                        <tr>
                                            <td style="width: 55%">
                                                <img src="<?= $qr_dokumen ?>" width="100px">
                                            </td> 
                                            <td style="width: 45%">
                                                <p>
                                                    Surabaya, <?= woday_toindo(date('Y-m-d', strtotime($mkpt['waktu_update'])));?><br>
                                                    Dosen MKPT <?= $no; ?>
                                                    <br/><br/><br>
                                                    <img src="<?= str_replace(base_url(), "", ($this->dosen->detail($pengampu['nip'])->ttd)); ?>" width="200px"/>
                                                    <br/>
                                                    <?= $pengampu['nama'] ?><br/>
                                                    NIP. <?= $pengampu['nip'] ?>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </p>
                </body>
                <?php
                }
            }
        }
        ?>       
</html>