<div class="form-group">
    <label>NIM</label>
    <hr class="divider-line-thin"/>
    <?php echo $tesis->nim ?>
</div>
<div class="form-group">
    <label>Nama</label>
    <hr class="divider-line-thin"/>
    <?php echo $tesis->nama ?>
</div>
<div class="form-group">
    <label>Judul</label>
    <hr class="divider-line-thin"/>
    <?php
    $judul = $this->tesis->read_judul($tesis->id_tesis);
    ?>
    <?php echo $judul->judul ?>
</div>