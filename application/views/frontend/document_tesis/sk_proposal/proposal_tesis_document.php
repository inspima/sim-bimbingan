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
        <!-- <table align="center" width="100%" border="0">
            <tbody>
                <tr>
                    <td width="10%"><img src="assets/backend/cetak/logo_unair.png" width="100px"></td>
                    <td width="90%" align="center">
                        <p style="font-size:20px;margin-bottom: 0px;">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI
                            <br>UNIVERSITAS AIRLANGGA
                            <br><b>FAKULTAS HUKUM</b><br>
                        </p>
                        <p style="font-size:13px;margin: 0px 0px 0px 0px;">
                            Kampus B, Jl. Dharmawangsa Dalam Selatan Surabaya 60286 Telp. (031) 5023151, 5023152 Fax. (031) 5020454<br>
                            Laman: http://fh.unair.ac.id - Email: humas@fh.unair.ac.id 
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="line">&nbsp;
                    </td>
                </tr>
            </tbody>
        </table> -->

        <?php $this->load->view('backend/widgets/common/header_document') ?>

        <div style="padding: 0px 25px 25px 25px;">
            <p align="center">
                <?php
                if($tesis->id_prodi == S2_ILMU_HUKUM){
                ?>
                KEPUTUSAN DEKAN<br>
                FAKULTAS HUKUM UNIVERSITAS AIRLANGGA<br>
                Nomor : <?= $no_sk?><br><br>
                Tentang<br><br>
                PENGUJI PROPOSAL TESIS PROGRAM STUDI MAGISTER <?= strtoupper($tesis->nm_prodi);?><br>
                <?= strtoupper(explode(' ', $semester->semester)[0]) ?> TAHUN AKADEMIK <?= explode(' ', $semester->semester)[1] ?>
                <?php
                }
                else if($tesis->id_prodi == S2_KENOTARIATAN){
                ?>
                <b>KEPUTUSAN DEKAN<br>
                    FAKULTAS HUKUM UNIVERSITAS AIRLANGGA<br>
                    Nomor : <?= $no_sk?><br><br>
                    Tentang<br><br>
                    PENGUJI PROPOSAL TESIS MAGISTER <?= strtoupper($tesis->nm_prodi);?><br>
                    SEMESTER <?= strtoupper(explode(' ', $semester->semester)[0]) ?> TAHUN AKADEMIK <?= explode(' ', $semester->semester)[1] ?><br>
                    a.n. <?php echo strtoupper($tesis->nama); ?> (NIM. <?php echo $tesis->nim ?>)<br><br>
                    DEKAN FAKULTAS HUKUM UNIVERSITAS AIRLANGGA,
                </b>
                <?php
                }
                ?>
            </p>
            <p align="justify">
                <table align="center" width="100%" border="0">
                    <tbody>
                        <?php
                        if($tesis->id_prodi == S2_ILMU_HUKUM){
                        ?>
                        <tr>
                            <td rowspan="2" valign="top">MENIMBANG</td>   
                            <td rowspan="2" valign="top">:</td>   
                            <td valign="top">a.</td> 
                            <td align="justify">bahwa dalam rangka untuk melaksanakan ujian proposal tesis bagi mahasiswa Program Studi Magister Ilmu Hukum yang telah menyelesaikan proposal tesis perlu ditetapkan Dosen Penguji Proposal Tesis;</td>
                        </tr>
                        <tr>
                            <td valign="top">b.</td> 
                            <td align="justify">bahwa sehubungan pertimbangan sebagaimana dimaksud pada huruf a perlu diterbitkan Keputusan Dekan</td>
                        </tr>
                        <?php
                        }
                        else if($tesis->id_prodi == S2_KENOTARIATAN){
                        ?>
                        <tr>
                            <td rowspan="3" valign="top">MENIMBANG</td>   
                            <td rowspan="3" valign="top">:</td>   
                            <td valign="top">a.</td> 
                            <td align="justify">bahwa   untuk    menyelesaikan  penulisan  tesis  bagi  maha-siswa Program Studi   Magister Kenotariatan Fakultas Hukum Universitas Airlangga wajib menempuh ujian Proposal Tesis;</td>
                        </tr>
                        <tr>
                            <td valign="top">b.</td> 
                            <td align="justify">bahwa   untuk  melaksanakan   ujian  Proposal Tesis sebagai-mana dimaksud pada huruf a, Dekan Fakultas Hukum telah menerbitkan Keputusan Dekan Tentang Pembimbing/Penguji Tesis Semester <?= explode(' ', $semester->semester)[0] ?> Tahun Akademik <?= explode(' ', $semester->semester)[1] ?>;</td>
                        </tr>
                        <tr>
                            <td valign="top">c.</td> 
                            <td align="justify">bahwa  berdasarkan pertimbangan sebagaimana dimaksud pada huruf a dan b perlu menetapkan Keputusan Dekan tentang Penguji Proposal Tesis Program Studi Magister Kenotariatan Semester <?= explode(' ', $semester->semester)[0] ?> Tahun Akademik <?= explode(' ', $semester->semester)[1] ?>.</td>
                        </tr>
                        <?php
                        }
                        if($tesis->id_prodi == S2_ILMU_HUKUM){
                        ?>
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
                        <?php
                        }
                        else if($tesis->id_prodi == S2_KENOTARIATAN){
                        ?>
                        <tr>
                            <td rowspan="6" valign="top">MENGINGAT</td>
                            <td rowspan="6" valign="top">:</td>   
                            <td valign="top">1.</td> 
                            <td align="justify">Undang Undang Nomor 20 Tahun  2003   tentang Sistem Pendidikan Nasional (Lembaran Negara Republik Indonesia Tahun 2003 Nomor 78, Tambahan Lembaran Negara Republik Indonesia Nomor 4301);</td>
                        </tr>
                        <tr>
                            <td valign="top">2.</td> 
                            <td align="justify">Peraturan Pemerintah Nomor 57 Tahun 1954 tentang Pendirian Universitas Airlangga (Lembaran Negara Republik Indonesia Tahun 1954 Nomor 99), Tambahan Lembaran Negara Republik Indonesia Nomor 695);</td>
                        </tr>
                        <tr>
                            <td valign="top">3.</td> 
                            <td align="justify">Peraturan Pemerintah Nomor 30 Tahun 2006 tentang Penetapan Universitas Airlangga sebagai Badan Hukum Milik Negara (Lembaran Negara Republik Indonesia Tahun 2006 Nomor 66);</td>
                        </tr>
                        <tr>
                            <td valign="top">4.</td> 
                            <td align="justify">Keputusan Dirjen Pendidikan Tinggi Depdiknas tanggal 7 April 2000 Nomor 78/ DIKTI/KEP/2000 tentang Perubahan Status Program Pendidikan Spesialis I Notariat Menjadi Program Studi Magister Kenotariatan Fakultas Hukum Universitas Airlangga;</td>
                        </tr>
                        <tr>
                            <td valign="top">5.</td> 
                            <td align="justify">Peraturan Rektor Universitas Airlangga Nomor 26/H3/PR/ 2011 tentang Organisasi Dan Tata Kerja Universitas Airlangga;</td>
                        </tr>
                        <tr>
                            <td valign="top">6.</td> 
                            <td align="justify">Keputusan Dekan Nomor <?= $no_surat?> tanggal <?= woday_toindo($tgl_surat)?> tentang Pembimbing dan Penguji Tesis Semester Genap Tahun Akademik 2020/2021 Program Studi Magister Kenotariatan Fakultas Hukum Universitas Airlangga.</td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </p>
        </div>

        <div class="page_break"></div>
        
        <div style="padding: 25px 25px 25px 25px;">
            <p align="center">
                MEMUTUSKAN
            </p>
            <?php
            if($tesis->id_prodi == S2_ILMU_HUKUM){
            ?>
            <p align="justify">
                MENETAPKAN
                <br><br>
                <table align="center" width="100%" border="0">
                    <tbody>
                        <tr>
                            <td valign="top">Pertama</td> 
                            <td valign="top">:</td>
                            <td align="justify">Menetapkan penguji proposal tesis sesuai dengan bidang penulisannya pada Semester <?= explode(' ', $semester->semester)[0] ?> Tahun Akademik <?= explode(' ', $semester->semester)[1] ?> seperti tercantum dalam lampiran keputusan ini;</td>
                        </tr>
                        <tr>
                            <td valign="top">Kedua</td>
                            <td valign="top">:</td>
                            <td align="justify">Penguji proposal tesis wajib memberikan penilaian sesuai dengan kemampuan/penguasaan materi yang diuji;</td>
                        </tr>
                        <tr>
                            <td valign="top">Ketiga</td>  
                            <td valign="top">:</td>
                            <td align="justify">Keputusan ini mulai berlaku pada tanggal ditetapkan dengan ketentuan apabila di kemudian hari terdapat kekeliruan dan atau kekurangan akan diperbaiki sebagaimana mestinya.</td>
                        </tr>
                    </tbody>
                </table>
            </p>
            <?php
            }
            else if($tesis->id_prodi == S2_KENOTARIATAN){
            ?>
            <p align="justify">
                <table align="center" width="100%" border="0">
                    <tbody>
                        <tr>
                            <td valign="top">Menetapkan</td> 
                            <td valign="top">:</td>
                            <td align="justify">
                                <b>
                                KEPUTUSAN DEKAN TENTANG PENGUJI PROPOSAL TESIS MAGISTER <?= strtoupper($tesis->nm_prodi);?> SEMESTER <?= strtoupper(explode(' ', $semester->semester)[0]) ?> TAHUN AKADEMIK <?= explode(' ', $semester->semester)[1] ?> a.n. <?php echo strtoupper($tesis->nama); ?> (NIM. <?php echo $tesis->nim ?>)
                                </b>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">Kesatu</td> 
                            <td valign="top">:</td>
                            <td align="justify">Menetapkan penguji proposal tesis sesuai dengan bidang penulisannya pada Semester <?= explode(' ', $semester->semester)[0] ?> Tahun Akademik <?= explode(' ', $semester->semester)[1] ?> seperti tercantum dalam lampiran keputusan ini;</td>
                        </tr>
                        <tr>
                            <td valign="top">Kedua</td>
                            <td valign="top">:</td>
                            <td align="justify">Penguji Proposal Tesis wajib memberikan penilaian untuk menentukan kelanjutan proposal dalam penelitian Tesis  sesuai dengan kemampuan/penguasaan materi yang diuji;</td>
                        </tr>
                        <tr>
                            <td valign="top">Ketiga</td>  
                            <td valign="top">:</td>
                            <td align="justify">Keputusan ini mulai berlaku pada tanggal ditetapkan dengan ketentuan apabila dikemudian hari terdapat kekeliruan dan atau kekurangan akan diperbaiki sebagaimana mestinya;</td>
                        </tr>
                        <tr>
                            <td valign="top">Keempat</td>  
                            <td valign="top">:</td>
                            <td align="justify">Keputusan ini berlaku sejak tanggal ditetapkan.</td>
                        </tr>
                    </tbody>
                </table>
            </p>
            <?php
            }
            ?>
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
                                                    <td><?= woday_toindo($tgl_sk)?></td>
                                                </tr>
                                            </table>
                                            D e k a n,
                                            <br/><br/><br/>
                                            <img src="<?= str_replace(base_url(), "", ($dekan->ttd ? $dekan->ttd : $this->dosen->detail('19641211199002200')->ttd)); ?>" width="200px"/>
                                            <br/>
                                            <?php
                                            if($tesis->id_prodi == S2_ILMU_HUKUM){
                                            ?>
                                            <?= $dekan ? $dekan->nama_dosen : 'Iman Prihandono, Ph.D.'; ?><br/>
                                            <?php
                                            }
                                            else if($tesis->id_prodi == S2_KENOTARIATAN){
                                            ?>
                                            <b><?= $dekan ? $dekan->nama_dosen : 'Iman Prihandono, Ph.D.'; ?></b><br/>
                                            <?php
                                            }
                                            ?>
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
            <?php
            if($tesis->id_prodi == S2_ILMU_HUKUM){
            ?>
            <p align="justify">
                Lampiran 1: Keputusan Dekan tanggal, <?= woday_toindo(date('Y-m-d'))?>  Nomor : <?= $no_sk?> tentang Penguji Proposal Tesis Program Studi Magister <?= $tesis->nm_prodi;?> Semester <?= explode(' ', $semester->semester)[0] ?> Tahun Akademik <?= explode(' ', $semester->semester)[1] ?> untuk mahasiswa an. <b><?= $tesis->nama.' ('.$tesis->nim.')' ?></b> dengan judul : 
                <?php
                $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_PROPOSAL);
                echo $judul->judul;
                ?>.
            </p>
            <?php
            }
            else if($tesis->id_prodi == S2_KENOTARIATAN){
            ?>
            <p align="justify">
                <table>
                    <tr>
                        <td valign="top">Lampiran</td>
                        <td valign="top">:</td>
                        <td>Keputusan Dekan Nomor <?= $no_sk?> tanggal <?= woday_toindo(date('Y-m-d'))?> Tentang Penguji Proposal Tesis Magister <?= $tesis->nm_prodi;?> Semester <?= explode(' ', $semester->semester)[0] ?> Tahun Akademik <?= explode(' ', $semester->semester)[1] ?> a.n. <?= $tesis->nama.' ('.$tesis->nim.')' ?>.</td>
                    </tr>
                </table>
            </p>
            <?php
            }
            ?>
            <?php
            if($tesis->id_prodi == S2_ILMU_HUKUM){
            ?>
            <p align="center">
                Daftar Penguji<br>
                Program Studi Magister <?= $tesis->nm_prodi;?><br>
                Semester <?= explode(' ', $semester->semester)[0] ?> Tahun Akademik <?= explode(' ', $semester->semester)[1] ?><br>
            </p>
            <?php
            }
            ?>
            <br><br><br>
            <?php
            if($tesis->id_prodi == S2_ILMU_HUKUM){
            ?>
            <table border="1" cellspacing="0" cellpadding="5" style="width:100%">   
                <tr align="center">
                    <td>No</td> 
                    <td>Nama Penguji Proposal Tesis</td> 
                    <td>Keterangan</td>
                </tr>
                <?php
                $no = 0;
                foreach ($pengujis as $uji) {
                    $str_status_tim = '';
                    if ($uji['status_tim'] == '1') {
                        $no++;
                        $str_status_tim = 'Ketua';
                        echo '
                        <tr>
                            <td>'.$no.'</td>
                            <td>'.$uji['nama'].'</td>
                            <td>'.$str_status_tim.'</td>
                        </tr>';
                    }
                }
                foreach ($pengujis as $uji) { 
                    if($uji['nip'] == $tesis->nip_pembimbing_satu){
                        $no++;
                        $str_status_tim = 'Pembimbing Utama / Anggota';
                        echo '
                        <tr>
                            <td>'.$no.'</td>
                            <td>'.$uji['nama'].'</td>
                            <td>'.$str_status_tim.'</td>
                        </tr>';
                    }
                }
                foreach ($pengujis as $uji) { 
                    if($uji['nip'] == $tesis->nip_pembimbing_dua){
                        $no++;
                        $str_status_tim = 'Pembimbing Kedua / Anggota';
                        echo '
                        <tr>
                            <td>'.$no.'</td>
                            <td>'.$uji['nama'].'</td>
                            <td>'.$str_status_tim.'</td>
                        </tr>';
                    }
                }
                foreach ($pengujis as $uji) {
                    if($uji['status_tim'] == '2' && $uji['nip'] != $tesis->nip_pembimbing_satu && $uji['nip'] != $tesis->nip_pembimbing_dua){
                        $no++;
                        $str_status_tim = 'Anggota';
                        echo '
                        <tr>
                            <td>'.$no.'</td>
                            <td>'.$uji['nama'].'</td>
                            <td>'.$str_status_tim.'</td>
                        </tr>';
                    }
                }
                ?>
            </table>
            <?php
            }
            else if($tesis->id_prodi == S2_KENOTARIATAN){
            $judul = $this->tesis->read_judul($tesis->id_tesis, TAHAPAN_TESIS_PROPOSAL);
            ?>
            <table border="1" cellspacing="0" cellpadding="5" style="width:100%">   
                <tr align="center">
                    <td><b>No</b></td> 
                    <td><b>Nama Panitia Penguji</b></td> 
                    <td><b>Susunan Penguji</b></td>
                    <td><b>J u d u l</b></td>
                </tr>
                <?php
                $no = 0;
                foreach ($pengujis as $uji) {
                    $str_status_tim = '';
                    if ($uji['status_tim'] == '1') {
                        $no++;
                        $str_status_tim = 'Ketua';
                        echo '
                        <tr>
                            <td>'.$no.'</td>
                            <td>'.$uji['nama'].'</td>
                            <td>'.$str_status_tim.'</td>
                            <td rowspan="'.(count($pengujis)).'">'.$judul->judul.'</td>
                        </tr>';
                    }
                }
                foreach ($pengujis as $uji) { 
                    if($uji['nip'] == $tesis->nip_pembimbing_satu){
                        $no++;
                        $str_status_tim = 'Pembimbing Utama / Anggota';
                        echo '
                        <tr>
                            <td>'.$no.'</td>
                            <td>'.$uji['nama'].'</td>
                            <td>'.$str_status_tim.'</td>
                        </tr>';
                    }
                }
                foreach ($pengujis as $uji) { 
                    if($uji['nip'] == $tesis->nip_pembimbing_dua){
                        $no++;
                        $str_status_tim = 'Pembimbing Kedua / Anggota';
                        echo '
                        <tr>
                            <td>'.$no.'</td>
                            <td>'.$uji['nama'].'</td>
                            <td>'.$str_status_tim.'</td>
                        </tr>';
                    }
                }
                foreach ($pengujis as $uji) {
                    if($uji['status_tim'] == '2' && $uji['nip'] != $tesis->nip_pembimbing_satu && $uji['nip'] != $tesis->nip_pembimbing_dua){
                        $no++;
                        $str_status_tim = 'Anggota';
                        echo '
                        <tr>
                            <td>'.$no.'</td>
                            <td>'.$uji['nama'].'</td>
                            <td>'.$str_status_tim.'</td>
                        </tr>';
                    }
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
                                        Dekan,
                                        <br/><br/><br/>
                                        <img src="<?= str_replace(base_url(), "", ($dekan->ttd ? $dekan->ttd : $this->dosen->detail('19641211199002200')->ttd)); ?>" width="200px"/>
                                        <br/>
                                        <?php
                                        if($tesis->id_prodi == S2_ILMU_HUKUM){
                                        ?>
                                        <?= $dekan ? $dekan->nama_dosen : 'Iman Prihandono, Ph.D.'; ?><br/>
                                        <?php
                                        }
                                        else if($tesis->id_prodi == S2_KENOTARIATAN){
                                        ?>
                                        <b><?= $dekan ? $dekan->nama_dosen : 'Iman Prihandono, Ph.D.'; ?></b><br/>
                                        <?php
                                        }
                                        ?>
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