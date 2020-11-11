<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>

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

<?php $this->load->view('backend/baa/cetak/kop')?>

<table border="0" style="width:100%">
    
    <tr>
    	<td>
    	<table border="0" style="width:100%">
		    <tr>
		      <td align="center"><u><b>BERITA ACARA UJIAN PROPOSAL SKRIPSI</b></u></td>
		    </tr>
		</table> 
		</td>
    </tr>
    
    <tr>
    	<td>
    	<table border="0" style="width:100%">
		    <tr>
		      <td style="width:15%" align="left">Pada Hari ini <?php echo hari($jadwal->tanggal)?> tanggal <?php echo woday_toindo($jadwal->tanggal)?> telah dilaksanakan ujian proposal skripsi atas nama mahasiswa:</td>
		    </tr>
		</table> 
		<br>
		</td>
    </tr>

    <tr>
    	<td>
    	<table border="0" style="width:100%">
		    <tr>
		   		<td style="width:15%" align="left">Nama</td>
		   		<td style="width:1%" align="left">:</td>
		   		<td style="width:84%" align="left"><?=$proposal->nama?></td>
		    </tr>
		    <tr>
		   		<td align="left">NIM</td>
		   		<td align="left">:</td>
		   		<td align="left"><?=$proposal->nim?></td>
		    </tr>
		    <tr>
		   		<td align="left">Minat Studi</td>
		   		<td align="left">:</td>
		   		<td align="left"><?=$proposal->departemen?></td>
		    </tr>
		    <tr>
		   		<td align="left">Judul Proposal</td>
		   		<td align="left">:</td>
		   		<td align="left"><?=$judul->judul?></td>
		    </tr>
		</table> 
		<br>
		</td>
    </tr>

    <tr>
    	<td>
    	<table border="0" style="width:100%">
		    <tr>
		    	<td style="width:2%" align="left"></td>
		    	<td style="width:98%" align="left"></td>
		    </tr>

		    <tr>
		    	<td colspan="2" align="left">Berdasarkan hasil musyawarah Tim Penguji Proposal Skripsi diputuskan sebagai berikut:</td>
		    </tr>
		    <tr>
		    	<td align="left" style="vertical-align: top;">1.</td>
		    	<td align="left">Proposal skripsi yang diajukan oleh mahasiswa tersebut(pilih salah satu)</td>
		    </tr>
		    <tr>
		    	<td align="left" style="vertical-align: top;"></td>
		    	<td align="left"><img src="assets/backend/cetak/kotak.png" width="10px"> LAYAK dan dapat dilanjutkan untuk penulisan skripsi.<br><br></td>
		    </tr>
		    <tr>
		    	<td align="left"></td>
		    	<td align="left"><img src="assets/backend/cetak/kotak.png" width="10px"> LAYAK dengan catatan perbaikan dan dapat dilanjutkan untuk penulisan skripsi.<br><br></td>
		    </tr>
		    <tr>
		    	<td align="left"></td>
		    	<td align="left"><img src="assets/backend/cetak/kotak.png" width="10px"> TIDAK LAYAK dan harus diuji kembali pada hari _____________ tanggal ____________________.<br><br></td>
		    </tr>
		    <tr>
		    	<td align="left" style="valign:top;">2.</td>
		    	<td align="left">Merekomendasikan dosen berikut ini sebagai Pembimbing Skripsi (diisi apabila dinyatakan LAYAK  atau LAYAK DENGAN PERBAIKAN) :</td>
		    </tr>
		    <tr>
		    	<td align="left"></td>
		    	<td align="left">- _____________________________________________________ ; atau</td>
		    </tr>
		    <tr>
		    	<td align="left"></td>
		    	<td align="left">- _____________________________________________________ .</td>
		    </tr>
		    <tr>
		    	<td align="left"></td>
		    	<td align="left">(Mohon Ketua Departemen memberi lingkaran pada Pembimbing Skripsi yang dipilih dan diberi paraf.)</td>
		    </tr>
		</table> <br>
		</td>
    </tr>

    <tr>
    	<td>
    	<table border="0" style="width:100%">
		    <tr>
		    	<td style="width:40%"align="left">Tim Penguji Proposal Skripsi</td>
		    	<td style="width:20%"align="left"></td>
		    	<td style="width:40%"align="left"></td>
		    </tr>
		    <tr>
		    	<td align="left">Nama</td>
		    	<td align="left"></td>
		    	<td align="left">Tandatangan</td>
		    </tr>
		    <?php 
		    $no = 1;
		    foreach($penguji as $list){?>
		    <tr>
		    	<td align="left"><?php echo $no.'. '.$list['nama'];?></td>
		    	<td align="left"></td>
		    	<td align="left">________________________________</td>
		    </tr>
		    <?php 
		    $no++;
			}
		    ?>
		</table> <br>
		</td>
    </tr>

    <tr>
    	<td>
    	<table border="1" style="width:100%; border: 1px solid black;border-collapse: collapse;">
		    <tr>
		    	<td style="width:33%" align="left">Tanggal :</td>
		    	<td style="width:33%" align="left">Tanggal :</td>
		    	<td style="width:33%" align="left">Tanggal :</td>
		    </tr>
		    <tr>
		    	<td align="left">Mengusulkan<br>Ketua Departemen,<br><br><br><br><br><?=$kadep->nama_dosen.'<br>NIP. '.$kadep->nip?></td>
   	            <td align="left">Menerima<br>Dosen Pembimbing,<br><br><br><br><br><br><br></td>
   		        <td align="left">Menyetujui<br>KPS,<br><br><br><br><br><?=$kps->nama_dosen.'<br>NIP. '.$kps->nip?></td>
		    </tr>
		</table> <br>
		</td>
    </tr>
    
    <tr>
    	<td>
    	<table border="0" style="width:100%">
		    <tr>
		    	<td style="width:10%"align="left"><br><br><br><br><br>Catatan :</td>
		    	<td style="width:90%"align="left"><br><br><br><br><br>Berita acara dibuat dalam enam rangkap untuk:</td>
		    </tr>
		    <tr>
		    	<td align="left"></td>
		    	<td align="left">- Sub Bagian Akademik</td>
		    </tr>
		    <tr>
		    	<td align="left"></td>
		    	<td align="left">- Sub Bagian Keuangan</td>
		    </tr>
		    <tr>
		    	<td align="left"></td>
		    	<td align="left">- Ketua Departemen</td>
		    </tr>
		    <tr>
		    	<td align="left"></td>
		    	<td align="left">- Koordinator Program Studi</td>
		    </tr>
		    <tr>
		    	<td align="left"></td>
		    	<td align="left">- Dosen Pembimbing Skripsi yang ditunjuk</td>
		    </tr>
		    <tr>
		    	<td align="left"></td>
		    	<td align="left">- Mahasiswa yang bersangkutan</td>
		    </tr>
		</table> <br>
		</td>
    </tr>

</table>  

</body>
</html>