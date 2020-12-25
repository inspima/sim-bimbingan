<?php if ($this->session->flashdata('msg')): ?>
    <?php
    $class_alert = 'alert ' . $this->session->flashdata('msg-title') . ' alert-dismissable';
    ?>
    <div class='<?= $class_alert ?>'>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Notifikasi</h4>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php endif; ?>
<div class="row">
    <!-- left column -->
    <div class="col-sm-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h2 class="box-title">Informasi Tesis</h2>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <?php $this->view('backend/widgets/tesis/informasi_tesis_judul', ['tesis' => $tesis]); ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- left column -->
    <div class="col-sm-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">1. Setting Jadwal</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('dosen/tesis/proposal/jadwal_save'); ?>
            <div class="box-body">
                <div class="form-group">
                    <label>Tanggal</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <?php
                        if ($ujian) {
                            $id_ujian = $ujian->id_ujian;
                            $tanggal = toindo($ujian->tanggal);
                            $id_ruang = $ujian->id_ruang;
                            $ruang = $ujian->ruang . ' - ' . $ujian->gedung;
                            $id_jam = $ujian->id_jam;
                            $jam = $ujian->jam;
                        } else {
                            $id_ujian = '';
                            $tanggal = '';
                            $id_ruang = '';
                            $ruang = '-Pilih Ruang-';
                            $id_jam = '';
                            $jam = '-Pilih Jam-';
                        }
                        ?>
                        <?php echo formtext('hidden', 'id_ujian', $id_ujian, '') ?>
                        <input type="text" name="tanggal" value="<?php echo $tanggal ?>" class="form-control pull-right" id="datepicker" disabled>              
                    </div>
                </div>
                <div class="form-group">
                    <label>Ruang</label>
                    <select name="id_ruang" class="form-control select2" style="width: 100%;" disabled>
                        <option value="<?php echo $id_ruang ?>"><?php echo $ruang ?></option>
                        <?php
                        foreach ($mruang as $list) {
                            ?>
                            <option value="<?php echo $list['id_ruang'] ?>"><?php echo $list['ruang'] . ' - ' . $list['gedung'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jam</label>
                    <select name="id_jam" class="form-control select2" style="width: 100%;" disabled>
                        <option value="<?php echo $id_jam ?>"><?php echo $jam ?></option>
                        <?php
                        foreach ($mjam as $list) {
                            ?>
                            <option value="<?php echo $list['id_jam'] ?>"><?php echo $list['jam'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!-- /.box-body -->
            <?php echo form_close() ?>
        </div>
        <!-- /.box -->
    </div>
    <!-- left column -->
</div>

<div class="row">
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">3. Dosen Penguji</h3>
            </div>
            <div class="box-body table-responsive">
                <?php
                if ($ujian) {
                    ?>
                    <div class="form-group">
                        <table class="table table-bordered">
                            <tr>
                                <th>Nama</th>
                                <th>Tim</th>
                                <th>Status</th>
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
                                    <td><?= $index + 1 ?>. <?php echo $listpenguji['nama'] ?><br/><b><?php echo $listpenguji['nip'] ?></b></td>
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
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                    <?php //$this->view('backend/widgets/tesis/list_penguji_dosen', ['tesis' => $tesis, 'ujian' => $ujian]); ?>
                    <?php
                } else {
                    ?>
                    <div class="form-group">
                        <p>Setting ujian terlebih dahulu</p>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <!-- /.box -->
    </div>
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">4. Status Ujian</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo form_open('dosen/tesis/proposal/update_status_ujian_ketua'); ?>
            <div class="box-body">
                <div class="form-group">
                    <?php
                    if($ujian){
                        $penguji = $this->tesis->read_penguji($ujian->id_ujian);
                        foreach ($penguji as $listpenguji) {
                            if($listpenguji['nip'] == $this->session_data['username']){
                                $status_tim = $listpenguji['status_tim'];
                            }
                        }
                        if(date('Y-m-d') >= $ujian->tanggal) {
                    ?>
                        <label>Status Ujian</label>
                        <select name="status_ujian" class="form-control select2" style="width: 100%;" required <?= ($status_tim != '1') ? 'disabled' : ''; ?> >
                            <?php
                            foreach ($status_ujians as $status_ujian) {
                                ?>
                                <option value="<?php echo $status_ujian['value'] ?>" <?php if ($status_ujian['value'] == $tesis->status_ujian_proposal) echo 'selected' ?>><?php echo $status_ujian['text'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    <?php
                        } else {
                            echo "<b>Ujian belum dilaksanakan</b>";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="box-footer">
                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                <?php echo formtext('hidden', 'id_tesis', $tesis->id_tesis, 'required') ?>
                <?php
                if($ujian){
                    $penguji = $this->tesis->read_penguji($ujian->id_ujian);
                    foreach ($penguji as $listpenguji) {
                        if($listpenguji['nip'] == $this->session_data['username']){
                            $status_tim = $listpenguji['status_tim'];
                        }
                    }
                    if(date('Y-m-d') >= $ujian->tanggal && $status_tim == '1') {
                        echo '<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Status Ujian</button>';
                    }
                }
                ?>
            </div>
            <!-- /.box-body -->
            <?php echo form_close() ?>
        </div>
        <!-- /.box -->
    </div>
</div>