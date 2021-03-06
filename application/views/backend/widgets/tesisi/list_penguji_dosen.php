<div class="form-group">
    <table class="table table-bordered">
        <tr>
            <th>Nama</th>
            <th>Tim</th>
            <th>Status</th>
            <th>Opsi</th>
        </tr>
        <?php
        $penguji = $this->disertasi->read_penguji($ujian->id_ujian);
        $str_status_tim = '';
        foreach ($penguji as $listpenguji) {
            if ($listpenguji['status_tim'] == '1') {
                $str_status_tim = 'Ketua';
            } else if ($listpenguji['status_tim'] == '2') {
                $str_status_tim = 'Anggota';
            }
            ?>
            <tr>
                <td><?php echo $listpenguji['nama'] ?><br/><b><?php echo $listpenguji['nip'] ?></b></td>
                <td>
                    <button type="button" class="btn btn-xs bg-blue-gradient" style="color:white" data-toggle="modal" data-target="#modal-tim-penguji-<?php echo $listpenguji['id_penguji'] ?>">
                        <?php echo $str_status_tim ?>
                    </button>
                    <div class="modal fade" id="modal-tim-penguji-<?php echo $listpenguji['id_penguji'] ?>" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Pilih Status Penguji</h4>
                                </div>
                                <div class="modal-body text-center">
                                    <?php echo form_open('dosen/disertasi/' . $this->uri->segment(3) . '/penguji_update_statustim') ?>
                                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                    <?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
                                    <?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
                                    <?php echo formtext('hidden', 'id_penguji', $listpenguji['id_penguji'], 'required') ?>
                                    <?php echo formtext('hidden', 'status_tim', '1', 'required'); ?>
                                    <button type="submit" class="btn btn-block bg-blue"> Ketua</button>
                                    <?php echo form_close(); ?>
                                    <hr style="margin: 5px"/>
                                    <?php echo form_open('dosen/disertasi/' . $this->uri->segment(3) . '/penguji_update_statustim') ?>
                                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                    <?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
                                    <?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
                                    <?php echo formtext('hidden', 'id_penguji', $listpenguji['id_penguji'], 'required') ?>
                                    <?php echo formtext('hidden', 'status_tim', '2', 'required'); ?>
                                    <button type="submit" class="btn btn-block bg-blue-active"> Anggota</button>
                                    <?php echo form_close(); ?>
                                    <hr style="margin: 5px"/>                                                        
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </td>
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
                        <button type="submit" class="btn btn-xs btn-danger"> Ditolak</button>
                        <?php
                    }
                    ?>
                </td>
                <td>
                    <?php echo form_open('dosen/disertasi/' . $this->uri->segment(3) . '/penguji_delete') ?>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_disertasi', $disertasi->id_disertasi, 'required') ?>
                    <?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
                    <?php echo formtext('hidden', 'id_penguji', $listpenguji['id_penguji'], 'required') ?>
                    <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                    <?php echo form_close() ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
