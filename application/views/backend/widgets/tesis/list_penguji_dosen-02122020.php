<div class="form-group">
    <table class="table table-bordered">
        <tr>
            <th>Nama</th>
            <th>Tim</th>
            <th>Status</th>
            <th>Opsi</th>
        </tr>
        <tr>
            <td><?= $index=1 ?>. <?php echo $tesis->nama_pembimbing_satu ?><br/><b><?php echo $tesis->nip_pembimbing_satu ?></b></td>
            <td>
                <button type="button" class="btn btn-xs bg-blue-gradient" style="color:white" data-toggle="modal" data-target="#modal-tim-pembimbing-1">
                    Pembimbing I
                </button>
                <div class="modal fade" id="modal-tim-pembimbing-1" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Pilih Status Penguji</h4>
                            </div>
                            <div class="modal-body text-center">
                                <button type="button" class="btn btn-block bg-blue"> Pembimbing I</button>                          
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </td>
            <td>
            <?php
            if ($tesis->status_pembimbing_satu == NULL) {
                ?>
                <button type="submit" class="btn btn-xs btn-warning"> Belum disetujui</button>
                <?php
            } else
            if ($tesis->status_pembimbing_satu == '1') {
                ?>
                <button type="submit" class="btn btn-xs btn-success"> Disetujui</button>
                <?php
            } else
            if ($tesis->status_pembimbing_satu == '2') {
                ?>
                <button type="submit" class="btn btn-xs btn-danger"> Ditolak</button>
                <?php
            }
            ?>
            </td>
            <td>
            </td>
        </tr>
        <tr>
            <td><?= $index + 1 ?>. <?php echo $tesis->nama_pembimbing_dua ?><br/><b><?php echo $tesis->nip_pembimbing_dua ?></b></td>
            <td>
                <button type="button" class="btn btn-xs bg-blue-gradient" style="color:white" data-toggle="modal" data-target="#modal-tim-pembimbing-2">
                    Pembimbing II
                </button>
                <div class="modal fade" id="modal-tim-pembimbing-2" style="display: none;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Pilih Status Penguji</h4>
                            </div>
                            <div class="modal-body text-center">
                                <button type="button" class="btn btn-block bg-blue"> Pembimbing II</button>                          
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </td>
            <td>
            <?php
            if ($tesis->status_pembimbing_dua == NULL) {
                ?>
                <button type="submit" class="btn btn-xs btn-warning"> Belum disetujui</button>
                <?php
            } else
            if ($tesis->status_pembimbing_dua == '1') {
                ?>
                <button type="submit" class="btn btn-xs btn-success"> Disetujui</button>
                <?php
            } else
            if ($tesis->status_pembimbing_dua == '2') {
                ?>
                <button type="submit" class="btn btn-xs btn-danger"> Ditolak</button>
                <?php
            }
            ?>
            </td>
            <td>
            </td>
        </tr>
        <?php
        $penguji = $this->tesis->read_penguji($ujian->id_ujian);
        $str_status_tim = '';
        foreach ($penguji as $index => $listpenguji) {
            if ($listpenguji['status_tim'] == '1') {
                $str_status_tim = 'Ketua';
            } else if ($listpenguji['status_tim'] == '2') {
                $str_status_tim = 'Anggota';
            }
            ?>
            <tr>
                <td><?= $index + 3 ?>. <?php echo $listpenguji['nama'] ?><br/><b><?php echo $listpenguji['nip'] ?></b></td>
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
                                    <?php echo form_open('dosen/tesis/' . $this->uri->segment(3) . '/penguji_update_statustim') ?>
                                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                    <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                                    <?php echo formtext('hidden', 'id_ujian', $ujian->id_ujian, 'required') ?>
                                    <?php echo formtext('hidden', 'id_penguji', $listpenguji['id_penguji'], 'required') ?>
                                    <?php echo formtext('hidden', 'status_tim', '1', 'required'); ?>
                                    <button type="submit" class="btn btn-block bg-blue"> Ketua</button>
                                    <?php echo form_close(); ?>
                                    <hr style="margin: 5px"/>
                                    <?php echo form_open('dosen/tesis/' . $this->uri->segment(3) . '/penguji_update_statustim') ?>
                                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                    <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
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
                    <?php echo form_open('dosen/tesis/' . $this->uri->segment(3) . '/penguji_delete') ?>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
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
