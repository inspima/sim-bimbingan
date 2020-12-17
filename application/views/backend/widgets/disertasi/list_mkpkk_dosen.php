<?php
$disertasi_mkpkks = $this->disertasi->read_disertasi_mkpkk($disertasi->id_disertasi);
if (!empty($disertasi_mkpkks)) {
    ?>
    
    <table class="table table-condensed ">
        <tr class="bg-gray-light">
            <th>Mata Kuliah</th>
            <th class="text-center">Nilai</th>
        </tr>
        <?php
        foreach ($disertasi_mkpkks as $index => $mkpkk) {
            ?>
            <tr>
                <td><?= $index + 1 ?>. <?php echo $mkpkk['mkpkk'] ?><br/>
                    <hr class="divider-line-semi-bold"/>
                    <b class="text-info">Dosen Pengampu</b><br/>
                    <?php
                    $mkpkk_pengampus = $this->disertasi->read_mkpkk_pengampu($mkpkk['id_mkpkk']);
                    foreach ($mkpkk_pengampus as $index_pengampu => $pengampu):
                        ?>
                        <?= $index_pengampu + 1 ?>. <b><?php echo $pengampu['nama'] ?></b> <br/><i><?php echo $pengampu['nip'] ?></i><br/>
                        <?php
                    endforeach;
                    ?>
                </td>
                <td class="text-center">
                    <?php
                    if ($mkpkk['nilai_publish'] != '0') {
                        ?>
                        <?php echo $mkpkk['nilai_angka'] ?>
                        <?php
                    } else {
                        ?>
                        <div class="btn btn-xs btn-danger">Belum Di Publish</div>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>

    <?php
} else {
    ?>
    <div class="form-group">
        <p>Data belum ada</p>
    </div>
    <?php
}
?>