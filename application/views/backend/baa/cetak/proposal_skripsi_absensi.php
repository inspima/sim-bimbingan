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
<br><br>
<table align="center" width="100%" border="0">
    <tbody>
      <tr>
        <td align="center"><img src="assets/backend/cetak/logo.png" width="70px"></td>
      </tr>
    </tbody>
  </table>

<table border="0" style="width:100%">
    
    <tr>
    	<td>
    	<table border="0" style="width:100%">
		    <tr>
		      <td align="center"><br><b>DAFTAR HADIR<br>UJIAN PROPOSAL SKRIPSI</b><br><br></td>
		    </tr>
			<tr>
		      <td align="center">FAKULTAS HUKUM UNIVERSITAS AIRLANGGA<br>SEMESTER <?php echo strtoupper($proposal->semester)?><br><br></td>
		    </tr>
		</table> 
		</td>
    </tr>
    
    <tr>
    	<td>
    	<table border="0" style="width:100%;font-weight:bold;">
		    <tr>
		   		<td style="width:30%;height:30px;" align="left">NAMA MAHASISWA</td>
		   		<td style="width:1%" align="left">:</td>
		   		<td style="width:69%" align="left"><?=$proposal->nama?></td>
		    </tr>
		    <tr>
		   		<td align="left" style="width:30%;height:30px;">NIM</td>
		   		<td align="left">:</td>
		   		<td align="left"><?=$proposal->nim?></td>
		    </tr>
			<tr>
		   		<td align="left" style="width:30%;height:30px;">HARI, TGL</td>
		   		<td align="left">:</td>
		   		<td align="left"><?php echo wday_toindo($jadwal->tanggal)?></td>
		    </tr>
			<tr>
		   		<td align="left" style="width:30%;height:30px;">WAKTU</td>
		   		<td align="left">:</td>
		   		<td align="left"><?php echo $jadwal->jam.' WIB'?></td>
		    </tr>
			<tr>
		   		<td align="left" style="width:30%;height:30px;">RUANG</td>
		   		<td align="left">:</td>
		   		<td align="left"><?php echo $jadwal->ruang.' - '.$jadwal->gedung?></td>
		    </tr>
		</table> 
		<br>
		</td>
    </tr>

    <tr>
    	<td>
    	<table border="1" style="width:100%;font-weight:bold;">
		    <tr>
		    	<td style="width:10%;height:20px;"align="center">NO</td>
		    	<td style="width:50%"align="center">NAMA PENGUJI</td>
		    	<td style="width:40%"align="center">TANDA TANGAN</td>
		    </tr>
		    <?php 
		    $no = 1;
		    foreach($penguji as $list){?>
		    <tr>
		    	<td align="center" style="height:40px;"><?php echo $no;?></td>
		    	<td align="left"><?php echo $list['nama']?></td>
		    	<td align="center"></td>
		    </tr>
		    <?php 
		    $no++;
			}
		    ?>
		    
		</table> <br>
		</td>
    </tr>

    
    
    

</table>  
    <i>Catatan : kembali ke petugas</i>
</body>
</html>