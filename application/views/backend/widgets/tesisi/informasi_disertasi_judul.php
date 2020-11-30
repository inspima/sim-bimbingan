<div class="form-group">
    <label>NIM</label>
    <hr class="divider-line-thin"/>
    <?php echo $disertasi->nim ?>
</div>
<div class="form-group">
    <label>Nama</label>
    <hr class="divider-line-thin"/>
    <?php echo $disertasi->nama ?>
</div>
<div class="form-group">
    <label>Judul</label>
    <hr class="divider-line-thin"/>
    <?php
    $judul = $this->disertasi->read_judul($disertasi->id_disertasi);
    ?>
    <?php echo $judul->judul ?>
</div>
<?php
if (!empty($disertasi->nip_penasehat)):
    ?>
    <div class="form-group">
        <label>Penasehat Akademik</label>
        <hr class="divider-line-thin"/>
        <p><?php echo $disertasi->nama_penasehat ?> <br/> <b><?php echo $disertasi->nip_penasehat ?></b></p>
    </div>
    <?php
endif;
?>