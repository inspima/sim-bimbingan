<div class="form-group">
    <table class="table table-bordered">
        <tr>
            <th>Nama</th>
            <th>Tim</th>
            <th>Status</th>
            <th>Opsi</th>
        </tr>
        <?php
        $penguji = $this->tesis->read_penguji($ujian->id_ujian);
        $str_status_tim = '';
        foreach ($penguji as $index => $listpenguji) {
            $btn = '';
            $btn_ketua = '';
            $btn_anggota = '';
            if ($listpenguji['status_tim'] == '1') {
                $str_status_tim = 'Ketua';
                $btn = 'bg-red-gradient';
                $btn_ketua = 'bg-blue-active';
                $btn_anggota = 'bg-blue';
            } else if ($listpenguji['status_tim'] == '2') {
                $str_status_tim = 'Anggota';
                $btn = 'bg-blue-gradient';
                $btn_ketua = 'bg-blue';
                $btn_anggota = 'bg-blue-active';
            }
            ?>
            <tr>
                <td><?= $index + 1 ?>. <?php echo $listpenguji['nama'] ?><br/><b><?php echo $listpenguji['nip'] ?></b></td>
                <td>
                    <button type="button" class="btn btn-xs <?= $btn;?>" style="color:white" data-toggle="modal" data-target="#modal-tim-penguji-<?php echo $listpenguji['id_penguji'] ?>">
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
                                    <?php echo form_open('dosen/tesis/' . $this->uri->segment(3) . '/penguji_update_statustim') ?>
                                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                    <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                                    <?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
                                    <?php echo formtext('hidden', 'id_penguji', $listpenguji['id_penguji'], 'required') ?>
                                    <?php echo formtext('hidden', 'status_tim', '1', 'required'); ?>
                                    <button type="submit" class="btn btn-block <?= $btn_ketua;?>"> Ketua</button>
                                    <?php echo form_close(); ?>
                                    <hr style="margin: 5px"/>
                                    <?php echo form_open('dosen/tesis/' . $this->uri->segment(3) . '/penguji_update_statustim') ?>
                                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                    <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                                    <?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
                                    <?php echo formtext('hidden', 'id_penguji', $listpenguji['id_penguji'], 'required') ?>
                                    <?php echo formtext('hidden', 'status_tim', '2', 'required'); ?>
                                    <button type="submit" class="btn btn-block <?= $btn_anggota;?>"> Anggota</button>
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
                    <?php
                    if($listpenguji['status'] != '2'){ 
                        echo form_open('dosen/tesis/' . $this->uri->segment(3) . '/penguji_delete') ?>
                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                        <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                        <?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
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
