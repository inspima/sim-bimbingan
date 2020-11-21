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