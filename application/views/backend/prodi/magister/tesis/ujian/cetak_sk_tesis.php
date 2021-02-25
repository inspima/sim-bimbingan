<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <style type="text/css">
            body {
                margin: -30px -10px 0px -10px;
                font-family: "Times New Roman", Times, serif;
                font-size: 12pt;
            }
            .line {
                background-image: url("assets/backend/cetak/line.png");
                background-repeat: repeat-x;
            }
            .page_break {
                page-break-before: always;
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
        <div style="padding: 0px 25px 25px 25px;">
            <p align="center">
                KEPUTUSAN DEKAN<br>
                FAKULTAS HUKUM UNIVERSITAS AIRLANGGA<br>
                Nomor : <?= $no_sk?><br><br>
                Tentang<br><br>
                PENGUJI TESIS PROGRAM STUDI MAGISTER <?= strtoupper($tesis->nm_prodi);?><br>
                <?= strtoupper(explode(' ', $semester->semester)[0]) ?> TAHUN AKADEMIK <?= explode(' ', $semester->semester)[1] ?>
            </p>
            <p align="justify">
                <table align="center" width="100%" border="0">
                    <tbody>
                        <tr>
                            <td rowspan="2" valign="top">MENIMBANG</td>   
                            <td rowspan="2" valign="top">:</td>   
                            <td valign="top">a.</td> 
                            <td align="justify">bahwa dalam rangka untuk melaksanakan ujian tesis bagi mahasiswa Program Studi Magister Ilmu Hukum yang telah menyelesaikan tesis perlu ditetapkan Dosen Penguji Tesis;</td>
                        </tr>
                        <tr>
                            <td valign="top">b.</td> 
                            <td align="justify">bahwa sehubungan pertimbangan sebagaimana dimaksud pada huruf a perlu diterbitkan Keputusan Dekan</td>
                        </tr>
                        <tr>
                            <td rowspan="7" valign="top">MENGINGAT</td>
                            <td rowspan="7" valign="top">:</td>   
                            <td valign="top">1.</td> 
                            <td align="justify">Undang-undang Nomor 20 Tahun 2003 tentang Sistem Pendidikan Nasional 9 LNRI  Tahun 2003 Nomor 78, TLNRI Nomor 4301);</td>
                        </tr>
                        <tr>
                            <td valign="top">2.</td> 
                            <td align="justify">Peraturan Pemerintah Republik Indonesia Nomor 30 Tahun 2006 tentang Penetapan Universitas Airlangga sebagai Badan Hukum Milik Negara (LNRI tahun 2006 Nomor 66);</td>
                        </tr>
                        <tr>
                            <td valign="top">3.</td> 
                            <td align="justify">Peraturan Pemerintah Nomor 57 tahun 1954 (LN Tahun 1954 No. 99) jo Nomor 3 Tahun 1955 (LN Tahun 1955 No. 4) tentang Pendirian Universitas Airlangga;</td>
                        </tr>
                        <tr>
                            <td valign="top">4.</td> 
                            <td align="justify">Keputusan Dirjen Dikti Depdikbud RI Nomor 593/Dikti/Kep/1993 tentang Pemberian Izin Penyelenggaraan Program Studi Magister dan Doktor di Universitas Airlangga;</td>
                        </tr>
                        <tr>
                            <td valign="top">5.</td> 
                            <td align="justify">Keputusan Rektor Universitas Airlangga Nomor 6005/J03/PP/2001 tanggal 28 Mei 2001 tentang Pembukaan Minat Studi Hukum Bisnis dan Hukum Pemerintahan pada Program Magister Program Studi Ilmu Hukum Program Pascasarjana Universitas Airlangga;</td>
                        </tr>
                        <tr>
                            <td valign="top">6.</td> 
                            <td align="justify">Keputusan Rektor Universitas Airlangga Nomor 1677/J03/PP/2004 tanggal 8 Maret 2004 tentang Pembukaan Minat Studi Peradilan pada Program Magister Program Studi Ilmu Hukum Program Pascasarjana Universitas Airlangga;</td>
                        </tr>
                        <tr>
                            <td valign="top">7.</td> 
                            <td align="justify">Keputusan Rektor Universitas Airlangga Nomor 5788/J03/PP/2007 tentang Pelimpahan Pengelolaan Penyelenggaraan Pendidikan Program Magister dari Program Pascasarjana ke Fakultas di Lingkungan Universitas Airlangga.</td>
                        </tr>
                    </tbody>
                </table>
            </p>
        </div>

        <div class="page_break"></div>
        
        <div style="padding: 25px 25px 25px 25px;">
            <p align="center">
                MEMUTUSKAN
            </p>
            <p align="justify">
                MENETAPKAN
                <br><br>
                <table align="center" width="100%" border="0">
                    <tbody>
                        <tr>
                            <td valign="top">Pertama</td> 
                            <td valign="top">:</td>
                            <td align="justify">Menetapkan penguji tesis sesuai dengan bidang penulisannya pada Semester <?= explode(' ', $semester->semester)[0] ?> Tahun Akademik <?= explode(' ', $semester->semester)[1] ?> seperti tercantum dalam lampiran keputusan ini;</td>
                        </tr>
                        <tr>
                            <td valign="top">Kedua</td>
                            <td valign="top">:</td>
                            <td align="justify">Penguji tesis wajib memberikan penilaian sesuai dengan kemampuan/penguasaan materi yang diuji;</td>
                        </tr>
                        <tr>
                            <td valign="top">Ketiga</td>  
                            <td valign="top">:</td>
                            <td align="justify">Keputusan ini mulai berlaku pada tanggal ditetapkan dengan ketentuan apabila di kemudian hari terdapat kekeliruan dan atau kekurangan akan diperbaiki sebagaimana mestinya.</td>
                        </tr>
                    </tbody>
                </table>
            </p>
            <p align="justify">
                <table border="0" style="width:100%">            
                    <tr>
                        <td>
                            <table border="0" style="width:100%;margin-top: 30px">
                                <tr>
                                    <td style="width: 60%">
                                    </td> 
                                    <td style="width: 40%">
                                        <p>
                                            <table>
                                                <tr>
                                                    <td style="padding-left: 0px;">Ditetapkan di</td>
                                                    <td>:</td> 
                                                    <td>Surabaya</td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-left: 0px;">Pada tanggal</td>
                                                    <td>:</td> 
                                                    <td><?= woday_toindo(date('Y-m-d'))?></td>
                                                </tr>
                                            </table>
                                            D e k a n,
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
            </p>
        </div>

        <div class="page_break"></div>

        <div style="padding: 25px 25px 25px 25px;">
            <p align="justify">
                Lampiran 1: Keputusan Dekan tanggal, <?= woday_toindo(date('Y-m-d'))?>  Nomor : <?= $no_sk?> tentang Penguji Tesis Program Studi Magister Ilmu Hukum Semester <?= explode(' ', $semester->semester)[0] ?> Tahun Akademik <?= explode(' ', $semester->semester)[1] ?> untuk mahasiswa an. <b><?= $tesis->nama.' ('.$tesis->nim.')' ?></b> dengan judul : 
                <?php
                $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_UJIAN);
                echo $judul->judul;
                ?>.
            </p>
            <p align="center">
                Daftar Penguji<br>
                Program Studi Magister Ilmu Hukum<br>
                Semester <?= explode(' ', $semester->semester)[0] ?> Tahun Akademik <?= explode(' ', $semester->semester)[1] ?><br>
            </p>


            <table border="1" cellspacing="0" cellpadding="5" style="width:100%">   
                <tr align="center">
                    <td>No</td> 
                    <td>Nama Penguji Tesis</td> 
                    <td>Keterangan</td>
                </tr>
                <?php
                $no = 0;
                foreach ($pengujis as $uji) {
                    $no++;
                    $str_status_tim = '';
                    if ($uji['status_tim'] == '1') {
                        $str_status_tim = 'Ketua';
                    } else if ($uji['status_tim'] == '2') {
                        $str_status_tim = 'Anggota';
                    }
                    echo '
                    <tr>
                        <td>'.$no.'</td>
                        <td>'.$uji['nama'].'</td>
                        <td>'.$str_status_tim.'</td>
                    </tr>';
                }
                ?>
            </table>

            <table border="0" style="width:100%">            
                <tr>
                    <td>
                        <table border="0" style="width:100%;margin-top: 30px">
                            <tr>
                                <td style="width: 60%">

                                </td> 
                                <td style="width: 40%">
                                    <p>
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
        </div>

    </body>
</html>