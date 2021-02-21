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
<?php $this->view('backend/widgets/tesis/tab_link_prodi'); ?>
<div class="divider10"></div>
<?php $this->view('backend/widgets/tesis/informasi_status', ['jenis' => TAHAPAN_TESIS_UJIAN]); ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $subtitle ?></h3>
                <div class="pull-right">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tesis</th>
                            <th>Tgl.Pengajuan</th>
                            <th class="text-center">Penguji</th>
                            <th class="text-center">Jadwal</th>
                            <th class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($tesis as $list) {
                            ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td>
                                    <?php echo '<strong>' . $list['nama'] . '</strong><br>' . $list['nim'] ?>
                                    <br/>
                                    <b>Judul</b> <br/>
                                    <?php
                                    echo $list['judul']
                                    ?>
                                </td>
                                <td><?php echo toindo($list['tgl_pengajuan']) ?></td>
                                <td class="text-center">
                                    <?php $this->view('backend/widgets/tesis/column_penguji', ['id_tesis' => $list['id_tesis'], 'jenis' => UJIAN_TESIS_UJIAN]); ?>
                                </td>
                                <td class="text-center">
                                    <?php $this->view('backend/widgets/tesis/column_jadwal', ['id_tesis' => $list['id_tesis'], 'jenis' => UJIAN_TESIS_UJIAN]); ?>
                                </td>
                                <td class="text-center">
                                    <?php $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_UJIAN]); ?>
                                    <?php
                                    if ($list['status_tesis'] >= STATUS_TESIS_UJIAN) {
                                        ?>
                                        <hr style="margin: 5px"/>
                                        <!-- Undangan -->
                                        <?php $attributes = array('target' => '_blank'); ?>
                                        <?php echo form_open('prodi/magister/tesis/ujian/cetak_undangan', $attributes) ?>
                                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                        <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                        <button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Undangan</button>
                                        <?php echo form_close() ?>                                        
                                        <hr style="margin: 2px"/>
                                        <!-- Berita Acara -->
                                        <?php $attributes = array('target' => '_blank'); ?>
                                        <?php echo form_open('prodi/magister/tesis/ujian/cetak_berita', $attributes) ?>
                                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                        <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                        <button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Berita Acara</button>
                                        <?php echo form_close() ?>                                        
                                        <hr style="margin: 2px"/>
                                        <!-- Penilaian -->
                                        <?php $attributes = array('target' => '_blank'); ?>
                                        <?php echo form_open('prodi/magister/tesis/ujian/cetak_penilaian', $attributes) ?>
                                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                        <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                        <button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Form Penilaian</button>
                                        <?php echo form_close() ?>                                      
                                        <hr style="margin: 2px"/>
                                        <!-- Daftar Hadir -->
                                        <?php $attributes = array('target' => '_blank'); ?>
                                        <?php echo form_open('prodi/magister/tesis/ujian/cetak_absensi', $attributes) ?>
                                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                        <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                        <button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Daftar Hadir</button>
                                        <?php echo form_close() ?>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <!--
                                <td>
                                    <?php
                                    /*$ujian = $this->tesis->read_jadwal($list['id_tesis'], UJIAN_TESIS_UJIAN);
                                    if($ujian){
                                        if($ujian->tanggal <= date('Y-m-d')){
                                        ?>
                                            <a class="btn btn-xs btn-success pull-left" href="<?= base_url()?>prodi/magister/tesis/ujian/nilai_ujian/<?php echo $list['id_tesis']?>/<?php echo $ujian->id_ujian?>"><i class="fa fa-edit"></i> Nilai</a>
                                        <?php
                                        }
                                    }*/
                                    ?>
                                </td>
                                -->
                            </tr>      
                            <?php
                            $no++;
                        }
                        ?>
                        </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>