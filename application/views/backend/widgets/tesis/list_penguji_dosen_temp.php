<div class="form-group">
    <table class="table table-bordered">
        <tr>
            <th>Nama</th>
            <th>Status</th>
            <th>Opsi</th>
        </tr>
        <?php
        $penguji = $this->tesis->read_penguji_temp($tesis->id_tesis, $asal_pengusul);
        $str_status_tim = '';
        foreach ($penguji as $index => $listpenguji) {
            
            ?>
            <tr>
                <td><?= $index+1; ?>. <?php echo $listpenguji['nama'] ?><br/><b><?php echo $listpenguji['nip'] ?></b></td>
                <td>
                    <?php
                    if ($listpenguji['status'] == '1') {
                        ?>
                        <button type="submit" class="btn btn-xs btn-warning"> Belum disetujui</button>
                        <?php
                    } else
                    if ($listpenguji['status'] == '2') {
                        ?>
                        <button type="submit" class="btn btn-xs btn-success"> Disetujui</button>
                        <?php
                    } else
                    if ($listpenguji['status'] == '3') {
                        ?>
                        <button type="submit" class="btn btn-xs btn-danger"> Ditolak Penguji</button>
                        <?php
                    }
                    if ($listpenguji['status'] == '4') {
                        ?>
                        <button type="submit" class="btn btn-xs btn-danger"> Ditolak KPS</button>
                        <?php
                    }
                    ?>
                </td>
                <td>
                    <?php 
                    if ($listpenguji['status'] == '1') {
                        echo form_open('dosen/tesis/' . $this->uri->segment(3) . '/penguji_usulan_delete'); ?>
                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                        <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                        <?php echo formtext('hidden', 'id_penguji', $listpenguji['id_penguji'], 'required') ?>
                        <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                        <?php echo form_close(); 
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
