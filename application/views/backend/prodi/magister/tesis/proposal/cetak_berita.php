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
            <u><h2>BERITA ACARA UJIAN PROPOSAL TESIS</h2></u>
        </p>
        <p align="justify">
            Pada hari <b><?php echo hari($jadwal->tanggal) ?>, <?php echo woday_toindo($jadwal->tanggal) ?></b> mulai pukul <b><?= substr($jadwal->jam, 0, 5); ?> - selesai</b> di Program Studi Magister <?= ucwords(strtolower($tesis->nm_prodi));?> Fakultas Hukum Universitas Airlangga diselenggarakan ujian proposal tesis atas nama :
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
                        <tr>
                            <td>Minat</td>
                            <td>:</td>
                            <td><?php echo $tesis->nm_minat ?></td>
                        </tr>
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
                        foreach ($pengujis as $penguji):
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
                                                <?= $no ?>.
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
                        foreach ($pengujis as $penguji):
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
                                                <?= $no ?>.
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
                        foreach ($pengujis as $penguji):
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
                                                <?= $no ?>.
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
                        foreach ($pengujis as $penguji):
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
                                                <?= $no ?>.
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
                                 $keterangan = '<br>Masih harus diuji kembali pada tanggal : '.$date_doc;
                            }
                        }
                        else {
                             $status_lanjut = 'Dapat / Tidak Dapat *)';
                             $keterangan = '';
                        }
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
                                    <br/><br/>
                                    <img src="<?= str_replace(base_url(), "", $this->tesis->read_penguji_id($ketua_penguji->id_penguji)[0]['ttd']) ?>" width="70px"/>
                                    <br/><br/>
                                    <?= $this->tesis->read_penguji_id($ketua_penguji->id_penguji)[0]['nama']; ?><br/>
                                    NIP. <?= $this->tesis->read_penguji_id($ketua_penguji->id_penguji)[0]['nip']; ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>  
    </body>
</html>