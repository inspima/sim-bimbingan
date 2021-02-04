<?php echo '<strong>' . $disertasi['nama'] . '</strong><br>' . $disertasi['nim'] ?>
<div class="divider5"></div>
<b>Judul</b>
<div class="divider3"></div>
<?php
echo $disertasi['judul'];
?>
<div class="divider5"></div>
<b>Berkas</b>
<div class="divider3"></div>
<?php
if ($jenis == TAHAPAN_DISERTASI_KUALIFIKASI):
    ?>
    <a class="btn btn-xs bg-red-active" href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/kualifikasi/<?php echo $disertasi['berkas_kualifikasi'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Berkas Syarat</a>
    <?php
elseif ($jenis == TAHAPAN_DISERTASI_PROPOSAL):
    ?>
    <a class="btn btn-xs bg-red-active" href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/proposal/<?php echo $disertasi['berkas_proposal'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Berkas Syarat</a>
    <?php
elseif ($jenis == TAHAPAN_DISERTASI_KELAYAKAN):
    ?>
    <a class="btn btn-xs bg-red-active" href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/kelayakan/<?php echo $disertasi['berkas_kelayakan'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Berkas Syarat</a>
    <?php
elseif ($jenis == TAHAPAN_DISERTASI_TERTUTUP):
    ?>
    <a class="btn btn-xs bg-red-active" href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/tertutup/<?php echo $disertasi['berkas_tertutup'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Berkas Syarat</a>
    <?php
elseif ($jenis == TAHAPAN_DISERTASI_TERBUKA):
    ?>
    <a class="btn btn-xs bg-red-active" href="<?php echo base_url() ?>assets/upload/mahasiswa/disertasi/terbuka/<?php echo $disertasi['berkas_terbuka'] ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Berkas Syarat</a>
    <?php
endif;
?>
