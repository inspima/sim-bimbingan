<table class="table table-condensed ">
    <tr class="bg-gray-light">
        <th>Nama</th>
        <th>Tim</th>
        <th>Status</th>
        <th>Opsi</th>
    </tr>
    <?php
    $str_status_tim = '';
    $promotors = $this->disertasi->read_promotor_kopromotor($disertasi->id_disertasi);
    foreach ($promotors as $promotor) {
        if ($promotor['status_tim'] == '1') {
            $str_status_tim = 'Promotor';
        } else if ($promotor['status_tim'] == '2') {
            $str_status_tim = 'Co-Promotor';
        }
        ?>
        <tr>
            <td><?php echo $promotor['nama'] ?><br/><b><?php echo $promotor['nip'] ?></b></td>
            <td>
                <button type="button" class="btn btn-xs bg-blue-gradient" style="color:white" >
                    <?php echo $str_status_tim ?>
                </button>
            <td>
                <?php
                if ($promotor['status'] == '1') {
                    ?>
                    <button type="submit" class="btn btn-xs btn-warning"> Belum Approve</button>
                    <?php
                } else
                if ($promotor['status'] == '2') {
                    ?>
                    <button type="submit" class="btn btn-xs btn-success"> Approved</button>
                    <?php
                } else
                if ($promotor['status'] == '3') {
                    ?>
                    <button type="submit" class="btn btn-xs btn-danger"> Rejected</button>
                    <?php
                }
                ?>
            </td>
            <td>
                <?php if ($promotor['status'] != '2'):
                    ?>
                    <?php echo form_open('mahasiswa/disertasi/' . $action . '/promotor_delete') ?>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
                    <?php echo formtext('hidden', 'id_promotor', $promotor['id_promotor'], 'required') ?>
                    <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                    <?php echo form_close() ?>
                    <?php
                endif;
                ?>
            </td>
        </tr>
        <?php
    }
    ?>
</table>