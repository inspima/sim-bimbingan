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
        <table border="0" style="width:100%">
            <tr>
                <td>
                    <table border="0" style="width:100%">
                        <tr>
                            <td>Nomor</td>
                            <td>:</td>
                            <td><?= $no_surat; ?></td>
                            <td></td>
                            <td><?= woday_toindo($tgl_surat); ?></td>
                        </tr>
                        <tr>
                            <td>Lampiran</td>
                            <td>:</td>
                            <td colspan="3">-</td>
                        </tr>
                        <tr>
                            <td valign="top">Perihal</td>
                            <td valign="top">:</td>
                            <td colspan="3">
                                Permohonan kesediaan untuk menjadi<br>
                                Penguji Proposal Tesis
                                <br><br>
                                Kepada Yth
                                <table border="0" style="width:100%">
                                    <?php
                                    $no = 0;
                                    foreach ($pengujis as $penguji){
                                        $no++;
                                        $status_tim = '';
                                        if($penguji['status_tim'] == '1'){
                                            $status_tim = 'Ketua';
                                        }
                                        else {
                                            if($penguji['nip'] == $tesis->nip_pembimbing_satu){
                                                $status_tim = 'Pembimbing Utama';
                                            }
                                            else if($penguji['nip'] == $tesis->nip_pembimbing_dua){
                                                $status_tim = 'Pembimbing Kedua';
                                            }
                                            else {
                                                $status_tim = 'Anggota';
                                            }
                                        }
                                        echo ' 
                                        <tr>
                                            <td>'.$no.'</td>
                                            <td>'.$penguji['nama'].'</td>
                                            <td>('.$status_tim.')</td>
                                        </tr>';
                                    }
                                    ?>
                                </table>
                                <br>
                                <p align="justify">
                                    Sehubungan dengan selesainya penulisan proposal tesis peserta Program Studi Magister <?= ucwords(strtolower($tesis->nm_prodi));?> Fakultas Hukum Universitas Airlangga Semester <?= ($semester ? explode(' ', $semester->semester)[0] : '') ?> Tahun Akademik <?= ($semester ? explode(' ', $semester->semester)[1] : ''); ?> :
                                </p>
                                <table border="0" style="width:100%">
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
                                    <tr>
                                        <td>Pembimbing Utama</td>
                                        <td>:</td>
                                        <td><?php echo $tesis->nama_pembimbing_satu ?></td>
                                    </tr>
                                    <tr>
                                        <td>Pembimbing Kedua</td>
                                        <td>:</td>
                                        <td><?php echo $tesis->nama_pembimbing_dua ?></td>
                                    </tr>
                                </table>
                                <p align="justify">
                                    Ujian proposal tesis direncanakan akan diselenggarakan :
                                </p>
                                <table border="0" style="width:100%">
                                    <tr>
                                        <td>Hari, Tanggal</td>
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
                                        <td><?= ' Gedung ' . $jadwal->gedung ?></td>
                                    </tr>
                                    <tr>
                                        <td>Ruang</td>
                                        <td>:</td>
                                        <td><?= $jadwal->ruang; ?></td>
                                    </tr>
                                </table>
                                <p align="justify">
                                    Maka dengan ini mohon kesediaan Saudara untuk menjadi Ketua/Anggota Penguji ujian proposal tesis tersebut.
                                    <br><br>
                                    Atas perhatian Saudara, kami sampaikan terima kasih
                                </p>
                            </td>
                        </tr>
                    </table> 
                </td>
            </tr>
        </table> 
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
                                    <?= woday_toindo($tgl_surat); ?><br>
                                    Dekan,
                                    <br/><br/>
                                    <img src="<?= str_replace(base_url(), "", ($dekan->ttd ? $dekan->ttd : $this->dosen->detail('197602042005011003')->ttd)); ?>" width="70px"/>
                                    <br/><br/>
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