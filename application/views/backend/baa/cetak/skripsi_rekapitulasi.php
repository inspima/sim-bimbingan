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
        <td width="10%"><img src="assets/backend/cetak/logo.png" width="100px"></td>
        <td width="90%" align="center">
          <strong><p style="font-size:17px;margin-bottom: 0px;">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN REPUBLIK INDONESIA<br>
          UNIVERSITAS AIRLANGGA<br>
          FAKULTAS HUKUM<br></p>
         </strong><p style="font-size:14px;margin: 0px 0 0px 0;">Kampus B, Jl. Dharmawangsa Dalam Selatan Surabaya 60286 Telp. (031) 5023151, 5023152 Fax. (031) 5020454<br>
          Website: http://fh.unair.ac.id - Email: humas@fh.unair.ac.id </p>
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
		      <td align="center"><b><br><br>REKAPITULASI NILAI SKRIPSI<br><br><br><br></b></td>
		    </tr>
		</table> 
		</td>
    </tr>
    

    <tr>
    	<td>
    	<table border="0" style="width:100%">
		    <tr>
		   		<td style="width:15%" align="left"><b>Nama</b></td>
		   		<td style="width:1%" align="left"><b>:</b></td>
		   		<td style="width:84%" align="left"><b><?=$skripsi->nama?></b></td>
		    </tr>
		    <tr>
		   		<td align="left"><b><br>NIM</b></td>
		   		<td align="left"><b><br>:</b></td>
		   		<td align="left"><b><br><?=$skripsi->nim?></b></td>
		    </tr>
		    <tr>
		   		<td align="left"><b><br>Bidang Minat</b></td>
		   		<td align="left"><b><br>:</b></td>
		   		<td align="left"><b><br><?=$skripsi->departemen?></b></td>
		    </tr>
		    <tr>
		   		<td align="left"><b><br>Judul Skripsi</b></td>
		   		<td align="left"><b><br>:</b></td>
		   		<td align="left"><b><br><?=$judul->judul?></b></td>
		    </tr>
		</table> 
		<br>
		</td>
    </tr>

    <tr>
    	<td>
    	<table border="1" style="width:100%; border: 1px solid black;border-collapse: collapse;text-align:center;">
		    <tr >
		   		<td style="width:6%"><b>NO</b></td>
		   		<td style="width:47%"><b>TIM PENGUJI SKRIPSI</b></td>
		   		<td style="width:47%"><b>SKOR TERBOBOT</b></td>
		    </tr>
		    <tr>
		   		<td>1.</td>
		   		<td>Ketua Penguji</td>
		   		<td></td>
		    </tr>
		    <tr>
		   		<td>2.</td>
		   		<td>Anggota I</td>
		   		<td></td>
		    </tr>
		    <tr>
		   		<td>3.</td>
		   		<td>Anggota II</td>
		   		<td></td>
		    </tr>
		    <tr>
		   		<td>4.</td>
		   		<td>Anggota III</td>
		   		<td></td>
		    </tr>
		    <tr>
		   		<td>5.</td>
		   		<td>Anggota IV</td>
		   		<td></td>
		    </tr>
		    <tr>
		   		<td></td>
		   		<td>NILAI SKRIPSI</td>
		   		<td></td>
		    </tr>
		</table> 
		<br>
		</td>
    </tr>

    <tr>
    	<td>
    	<table border="0" style="width:100%">
		    <tr>
		    	<td style="width:100%" align="left">Berdasarkan skor terbobot total tersebut diatas. Tim penguji skripsi menyatakan mahasiswa tersebut diatas lulus/tidak lulus *) <br><br>dengan nilai : ......................<br><br>(.......................................)</td>
		    </tr>
		    <tr>
		    	<td style="width:100%" align="left"><br></td>
		    </tr>
		    
		</table> <br>
		</td>
    </tr>

    <tr>
    	<td>
    	<table border="0" style="width:100%">
		    <tr>
		    	<td style="width:60%" align="left"></td>
		    	<td style="width:40%" align="left">Surabaya, ...................................</td>
		    </tr>
		    <tr>
		    	<td align="left"></td>
		    	<td align="left">Ketua Tim Penguji Skripsi,</td>
		    </tr>
		    <tr>
		    	<td align="left"></td>
		    	<td align="left"><br><br><br></td>
		    </tr>
		    <tr>
		    	<td align="left"></td>
		    	<td align="left"><?php echo $penguji_ketua->nama?></td>
		    </tr>
		    <tr>
		    	<td align="left"></td>
		    	<td align="left">NIP. <?php echo $penguji_ketua->nip?></td>
		    </tr>
		</table> <br>
		</td>
    </tr>

    <tr>
    	<td>
    	<table border="0" style="width:100%">
		    <tr>
		    	<td style="width:100%" align="left"><br><br><b>Catatan :</b></td>
		    </tr>
		    <tr>
		    	<td style="width:100%" align="left">1. *) Coret yang tidak perlu </td>
		    </tr>
		    <tr>
		    	<td style="width:100%" align="left">2. Nilai skripsi adalah jumlah nilai terbobot dibagi Jumlah Penguji</td>
		    </tr>
		    <tr>
		    	<td style="width:100%" align="left">3. Nilai Huruf didasarkan pada NILAI SKRIPSI dan berpedoman pada</td>
		    </tr>
		    <tr>
		    	<td style="width:100%" align="left">
		    		<table border="1" style="width:40%; border: 1px solid black;border-collapse: collapse;text-align:center;">
		    			<tr>
		    				<td style="width:50%">NILAI SKRIPSI</td>
		    				<td  style="width:50%">NILAI HURUF</td>
		    			</tr>
		    			<tr>
		    				<td >75-100</td>
		    				<td >A</td>
		    			</tr>
		    			<tr>
		    				<td >70-74,9</td>
		    				<td >AB</td>
		    			</tr>
		    			<tr>
		    				<td >65-69,9</td>
		    				<td >B</td>
		    			</tr>
		    			<tr>
		    				<td >60-64,9</td>
		    				<td >BC</td>
		    			</tr>
		    			<tr>
		    				<td >55-59,9</td>
		    				<td >C</td>
		    			</tr>
		    			<tr>
		    				<td >40-54,9</td>
		    				<td >Tidak Lulus</td>
		    			</tr>
		    		</table>
		    	</td>
		    </tr>
		    
		</table> <br>
		</td>
    </tr>
    

</table>  

</body>
</html>