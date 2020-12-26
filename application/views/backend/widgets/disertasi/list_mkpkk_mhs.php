<?php
$disertasi_mkpkks = $this->disertasi->read_disertasi_mkpkk($disertasi->id_disertasi);
if (!empty($disertasi_mkpkks)) {
    ?>              
    <div class="form-group">
        <table class="table table-bordered ">
            <tr class="bg-gray">
                <th>Mata Kuliah</th>
                <th>Pengampu</th>
                <th class="text-center">Nilai</th>
            </tr>
            <?php
			$sudah_publish_semua=$this->disertasi->cek_mkpkk_sudah_publish($disertasi->id_disertasi);
            foreach ($disertasi_mkpkks as $index => $mkpkk) {
                ?>
                <tr>
                    <td><?= $index + 1 ?>. <?php echo $mkpkk['mkpkk'] ?></td>
                    <td>
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
                        if ($sudah_publish_semua) {
                            ?>
                            <strong style="font-size: 1.2em"><?php echo $mkpkk['nilai_angka'] ?></strong>
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
    </div>

    <?php
} else {
    ?>
    <div class="form-group">
        <p>Data belum ada</p>
    </div>
    <?php
}
?>
