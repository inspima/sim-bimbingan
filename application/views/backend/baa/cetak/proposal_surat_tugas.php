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
          <strong><p style="font-size:17px;margin-bottom: 0px;">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN<br>
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
		      <td align="center"><b>SURAT   TUGAS<br />
		      Nomor : <?php echo $gelombang->no_sk?> </b></td>
		    </tr>
		</table> 
		</td>
    </tr>
    
    <tr>
    	<td>
    	<table border="0" style="width:100%">
		    <tr>
			  <td style="width:15%" align="left">
		      Dekan dengan ini menugaskan kepada  :
		      </td>
		    </tr>
		</table> 
		<br>
		</td>
    </tr>

    <tr>
    	<td>
    	<table border="1" style="width:100%">
    		<tr>
		   		<td style="width:15%" align="left"><strong>No</strong></td>
		   		<td style="width:40%" align="left"><strong>Nama Penguji Proposal </strong></td>
		   		<td style="width:40%" align="left"><strong>Keterangan</strong></td>
		    </tr>
		
		    <tr>
		   		<td style="width:15%" align="left">1</td>
		   		<td style="width:40%" align="left"><?=$penguji_ketua->nama?></td>
		   		<td style="width:40%" align="left">(Ketua)</td>
		    </tr>
			
	
			
			  <?php 
		    $no = '2';
		    foreach($penguji_anggota as $list){
		    ?>
		    <tr>
		   		<td style="width:15%" align="left"><?=$no?></td>
		   		<td style="width:40%" align="left"><?=$list['nama']?></td>
		   		<td style="width:40%" align="left">(Penguji)</td>
		    </tr>
			<?php $no++;}?>
		</table> 
		<br>
		</td>
    </tr>

    <tr>
    	<td>
    	<table border="0" style="width:100%">
		    <tr>
		   		<td style="width:15%" align="left"><b>Nama</b></td>
		   		<td style="width:1%" align="left"><b>:</b></td>
		   		<td style="width:84%" align="left"><b><?=$proposal->nama?></b></td>
		    </tr>
		    <tr>
		   		<td align="left"><b>NIM</b></td>
		   		<td align="left"><b>:</b></td>
		   		<td align="left"><b><?=$proposal->nim?></b></td>
		    </tr>
		    <tr>
		   		<td align="left"><b>Judul Proposal</b></td>
		   		<td align="left"><b>:</b></td>
		   		<td align="left"><b><?=$judul->judul?></b></td>
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
		    	<td style="width:40%" align="left"></td>
		    	<td style="width:10%" align="left"></td>
		    	<td style="width:48%" align="left"></td>
		    </tr>
		    <tr>
		    	<td colspan="4" align="left">Demikian surat tugas ini diterbitkan agar dilaksanakan sebaik-baiknya.</td>
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
		      <td style="width:60%" align="left"></td>
		      <td style="width:40%" align="left"><br>a.n. Dekan</td>
		    </tr>
		    <tr>
		      <td style="width:60%" align="left"></td>
		      <td style="width:40%" align="left">Wadek I<br><br><br><br><br></td>
		    </tr>
		    <tr>
		      <td style="width:60%" align="left"></td>
		      <td style="width:40%" align="left"><?=$wadek->nama?></td>
		    </tr>
		    <tr>
		      <td style="width:60%" align="left"></td>
		      <td style="width:40%" align="left">NIP. <?=$wadek->nip?><br><br><br></td>
		    </tr>
		</table> <br>
		</td>
    </tr>
    

</table>
</body>
</html>