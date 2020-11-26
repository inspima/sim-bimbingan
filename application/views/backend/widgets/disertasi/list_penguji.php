<?php
if ($jadwal) {
    ?>              
    <div class="form-group">
        <table class="table table-condensed ">
            <tr class="bg-gray-light">
                <th>Nama</th>
                <th>Tim</th>
                <th>Status</th>
            </tr>
            <?php
            $penguji = $this->disertasi->read_penguji($jadwal->id_ujian);
            $str_status_tim = '';
            foreach ($penguji as $index => $listpenguji) {
                if ($listpenguji['status_tim'] == '1') {
                    $str_status_tim = 'Ketua';
                } else if ($listpenguji['status_tim'] == '2') {
                    $str_status_tim = 'Anggota';
                }
                ?>
                <tr>
                    <td><?= $index + 1 ?>. <?php echo $listpenguji['nama'] ?><br/><b><?php echo $listpenguji['nip'] ?></b></td>
                    <td><button class="btn btn-xs bg-blue-gradient" style="color:white"><?php echo $str_status_tim ?></button>
                    </td>
                    <td>
                        <?php
                        if ($listpenguji['status'] == '1') {
                            ?>
                            <a class="btn btn-xs btn-warning"> Belum disetujui</a>
                            <?php
                        } else
                        if ($listpenguji['status'] == '2') {
                            ?>
                            <a class="btn btn-xs btn-success"> Disetujui</a>
                            <?php
                        } else
                        if ($listpenguji['status'] == '3') {
                            ?>
                            <a class="btn btn-xs btn-danger"> Ditolak</a>
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
        <p>Jadwal ujian belum ada</p>
    </div>
    <?php
}
?>