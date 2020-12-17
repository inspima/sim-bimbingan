<?php
$disertasi_mkpkks = $this->disertasi->read_disertasi_mkpkk($id_disertasi);
if (!empty($disertasi_mkpkks)) {
    ?>
    <ol>
        <?php
        foreach ($disertasi_mkpkks as $index => $mkpkk) {
            ?>
            <li><?php echo $mkpkk['mkpkk'] ?></li>
            <?php
        }
        ?>
    </ol>
    <?php
} else {
    ?>
    <div class="form-group">
        <p>Data belum ada</p>
    </div>
    <?php
}
?>