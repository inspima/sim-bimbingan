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

<?php $this->load->view('backend/widgets/common/header_document') ?>
<table border="0" style="width:100%">

    <tr>
    	<td>
    	<table border="0" style="width:100%">
		    <tr>
		      <td style="width:10%" align="left">Nomor</td>
		      <td style="width:1%" align="left">:</td>
		      <td style="width:40%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/UN3.1.3/PPd/<?=date('Y')?></td>
		      <?php
		      $tanggal = date("Y-m-d");
		      ?>
		      <td style="width:49%" align="right"><?php echo woday_toindo($tanggal)?></td>
		    </tr>
		    <tr>
		      <td align="left">Lampiran</td>
		      <td align="left">:</td>
		      <td align="left">1 (Satu) Eksemplar</td>
		      <td align="right"></td>
		    </tr>
		    <tr>
		      <td align="left">Perihal</td>
		      <td align="left">:</td>
		      <td align="left">Pemberitahuan Ujian Skripsi</td>
		      <td align="right"></td>
		    </tr>
		</table> 
		<br>
		</td>
    </tr>
    
    <tr>
    	<td>
    	<table border="0" style="width:100%">
		    <tr>
		      <td style="width:100%" align="left">Sdr. <b><?=$skripsi->nama?></b></td>
		    </tr>
		    <tr>
		      <td style="width:100%" align="left">NIM. <b><?=$skripsi->nim?></b></td>
		    </tr>
		    <tr>
		      <td style="width:100%" align="left"><?=$skripsi->alamat?></td>
		    </tr>
		    <tr>
		      <td style="width:100%" align="left"><?=$skripsi->telp?></td>
		    </tr>
		</table> 
		<br>
		</td>
    </tr>

    <tr>
    	<td>
    	<table border="0" style="width:100%">
		    <tr>
		      <td style="width:15%" align="left"></td>
		      <td style="width:1%" align="left"></td>
		      <td style="width:84%" align="left"></td>
		    </tr>
		    <tr>
		      <td colspan="3">Diberitahukan bahwa Ujian Skripsi Saudara, akan dilaksanakan pada :</td>
		    </tr>
		    <tr>
		      <td colspan="3"><br></td>
		    </tr>
		    <tr>
		      <td align="left">Hari</td>
		      <td align="left">:</td>
		      <td align="left"><b><?php echo hari($skripsi->tanggal)?></b></td>
		    </tr>
		    <tr>
		      <td align="left">Tanggal</td>
		      <td align="left">:</td>
		      <td align="left"><b><?php echo woday_toindo($skripsi->tanggal)?></b></td>
		    </tr>
		    <tr>
		      <td align="left">Pukul</td>
		      <td align="left">:</td>
		      <td align="left"><b><?=substr($skripsi->jam,0,5);?> WIB</b></td>
		    </tr>
		    <tr>
		      <td align="left">Tempat</td>
		      <td align="left">:</td>
		      <td align="left"><?=$skripsi->ruang.' '.$skripsi->gedung?></td>
		    </tr>
		    <tr>
		      <td align="left" style="vertical-align: top;">Pakaian</td>
		      <td align="left" style="vertical-align: top;">:</td>
		      <td align="left">Pria &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Celana Hitam       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Hem Putih<br>
		      	Wanita : Rok Hitam &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Hem Putih<br>
		      	Dasi : Hitam
		      </td>
		    </tr>
		    <tr>
		      <td align="left"><b>Judul Skripsi</b></td>
		      <td align="left"><b>:</b></td>
		      <td align="left"><b><?='"'.$judul->judul.'"'?></b></td>
		    </tr>
		    <tr>
		      <td align="left"><b>Pembimbing</b></td>
		      <td align="left"><b>:</b></td>
		      <td align="left"><b><?=$penguji_pembimbing->nama?></b></td>
		    </tr>
		    <tr>
		      <td colspan="3"><br>Yang bersangkutan diharap membawa bahan-bahan yang Saudara anggap perlu</td>
		    </tr>
		</table> 
		<br>
		</td>
    </tr>

    <tr>
    	<td>
    	<table border="0" style="width:100%">
    	     <tr>
		    	<td style="width:60%" align="left"></td>
		    	<td style="width:40%" align="left">Surabaya, <?php echo tanggal_format_indonesia(date('Y-m-d')) ?></td>
		    </tr>
		    <tr>
		      <td style="width:60%" align="left"></td>
		      <td style="width:40%" align="left"><br>a.n. Dekan</td>
		    </tr>
		    <tr>
		      <td style="width:60%" align="left"></td>
		      <td style="width:40%" align="left">Wadek I<br>
				  <?php
					  if (!empty($wadek->ttd)) {
						  ?>
						  <br/><br/>
						  <img src="<?= str_replace(base_url(), "", $wadek->ttd) ?>" width="80px"/>
						  <br/>
						  <?php
					  } else {
						  ?>
						  <br/><br/><br/>
						  <font style="color: red;font-size: 9pt">TTD KOSONG</font><br/>
						  <br/><br/>
						  <?php
					  }
				  ?>
			  </td>
		    </tr>
		    <tr>
		      <td style="width:60%" align="left"></td>
		      <td style="width:40%" align="left"><?=$wadek->nama?></td>
		    </tr>
		    <tr>
		      <td style="width:60%" align="left"></td>
		      <td style="width:40%" align="left">NIP. <?=$wadek->nip?><br><br><br></td>
		    </tr>
		</table> 
		</td>
    </tr>

    <tr>
    	<td>
    	<table border="0" style="width:100%">
    		<tr>
		      <td colspan="3" align="left"><u><i>Tembusan</i></u> : Yth.</td>
		    </tr>
		    <tr>
		      <td colspan="3" align="left"><b>1. Panita Penguji Skripsi</b></td>
		    </tr>
		    <tr>
		      <td style="width:20%" align="left"><b>2. Ketua</b></td>
		      <td style="width:1%" align="left">:</td>
		      <td style="width:79%" align="left"><?=!empty($penguji_ketua)?$penguji_ketua->nama:'-'?></td>
		    </tr>
		    <tr style="vertical-align: top;">
		      <td style="width:20%" align="left" style="vertical-align: top;"><b>&nbsp;&nbsp;&nbsp;&nbsp;Anggota</b></td>
		      <td style="width:1%" align="left" style="vertical-align: top;">:</td>
		      <td style="width:79%" align="left">
		      	1.  <b><?=$penguji_pembimbing->nama?></b><br>
		      	<?php 
			    $no = '2';
			    foreach($penguji_anggota as $list){
			    ?>
			    <?=$no?>.  <?=$list['nama']?><br>
			    <?php 
				$no++;}
			    ?>
		      </td>
		    </tr>

		    
		</table> 
		<br>
		</td>
    </tr>

    

</table>  

</body>
</html>
