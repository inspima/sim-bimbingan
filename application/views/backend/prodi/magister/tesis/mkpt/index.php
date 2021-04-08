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
<?php $this->view('backend/widgets/tesis/informasi_status', ['jenis' => TAHAPAN_TESIS_MKPT]); ?>
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
                            <th>Detail MKPT</th>
                            <th>Opsi</th>
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
                                <td>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>No.</th>
                                            <th style="width: 35%">Topik</th>
                                            <th style="width: 10%">SKS</th>
                                            <th style="width: 45%">Dosen</th>
                                            <th style="width: 10%">Nilai</th>
                                            <th style="width: 10%">Status Ujian</th>
                                        </tr>
                                        <?php
                                        $tesis_mkpts = $this->tesis->read_tesis_mkpt($list['id_tesis']); 
                                        $hitung_pengampu_setuju = 0;   
                                        $hitung_nilai_publish = 0;
                                        $no = 0;
                                        if (!empty($tesis_mkpts)) {
                                            $sudah_publish_semua=$this->tesis->cek_mkpt_sudah_publish($list['id_tesis']);
                                            foreach ($tesis_mkpts as $index => $mkpt) {
                                                $no++;
                                                $mkpt_pengampus = $this->tesis->read_tesis_mkpt_pengampu($mkpt['id_tesis_mkpt']);
                                                if(!empty($mkpt_pengampus)){
                                                    foreach ($mkpt_pengampus as $index_pengampu => $pengampu){
                                                        if($pengampu['status'] == '1' ){
                                                            $status = '';
                                                            if($pengampu['status'] == '1'){
                                                                $hitung_pengampu_setuju = $hitung_pengampu_setuju + 1;
                                                                $status = '<button type="button" class="btn btn-xs btn-success"> Disetujui</button>';
                                                            }

                                                            foreach ($mdosen as $list_dosen) {
                                                                $dosen_mkpt = '';
                                                                if($pengampu['nip'] == $list_dosen['nip']){
                                                                    $dosen_mkpt = $list_dosen['nama'];
                                                                }
                                                            }

                                                            if($mkpt['nilai_publish'] != ''){
                                                                $hitung_nilai_publish = $hitung_nilai_publish + 1;
                                                            }

                                                            $status_ujian = ['1' => 'Lulus', '2' => 'Tidak Lulus', '0' => '', NULL => ''];

                                                            echo '
                                                            <tr>
                                                                <td>'.$no.'</td>
                                                                <td>'.$mkpt['mkpt'].'</td>
                                                                <td>'.$mkpt['sks'].'</td>
                                                                <td><b>'.$pengampu['nip'].'</b><br>'.$pengampu['nama'].'</td>
                                                                <td>'.$pengampu['nilai_angka'].'</td>
                                                                <td>'.$status_ujian[$pengampu['status_ujian']].'</td>
                                                            </tr>
                                                            ';
                                                        }
                                                        ?>
                                                    <?php
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </table>
                                </td>
                                <td class="text-center">
                                    <?php $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, TAHAPAN_TESIS_MKPT]); ?>

                                    <?php
                                    if ($list['status_mkpt'] >= STATUS_TESIS_MKPT_UJIAN) {
                                        $data_dokumen = [
                                            'tipe' => DOKUMEN_SP_PENGAMPU_MKPT_TESIS,
                                            'jenis' => DOKUMEN_JENIS_TESIS_MKPT_STR,
                                            'identitas' => $list['nim'],
                                        ];
                                        $dokumen = $this->dokumen->detail_by_data($data_dokumen);

                                        $no_surat = '';
                                        $no_sk = '';
                                        $tgl_sk = '';
                                        $tgl_surat = '';

                                        if(!empty($dokumen)){
                                            $no_surat = $dokumen->no_doc;
                                            $no_sk = $dokumen->no_ref_doc;
                                            $tgl_sk = date('d/m/Y', strtotime($dokumen->date_doc));
                                            $tgl_surat = date('d/m/Y', strtotime($dokumen->date));
                                        }
                                    ?>
                                    <br><br>
                                    <button type="button" class="btn btn-primary col-sm-12" data-toggle="modal" data-target="#myModalSP<?= $list['id_tesis']?>">
                                        <i class="fa fa-file"></i> Surat Tugas
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="myModalSP<?= $list['id_tesis']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                
                                                <?php $attributes = array('target' => '_blank'); ?>
                                                <?php echo form_open('prodi/magister/tesis/mkpt/cetak_surat_tugas_pengampu', $attributes) ?>
                                                <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                                <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">
                                                            Surat Tugas Pengampu MKPT Tesis
                                                            <br><?= $list['judul']?>
                                                            <br><?= $list['nama'].' - '.$list['nim'];?> 
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                                        <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                                        <input type="text" name="no_surat" class="form-control" style="width: 100%" value="<?= $no_surat; ?>" required placeholder="Nomor Surat">
                                                        <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy"  style="width: 100%" >
                                                            <input type="text" name="tgl_surat" class="form-control" value="<?= $tgl_surat; ?>" required placeholder="Tanggal Surat">
                                                            <div class="input-group-addon">
                                                                <span class="glyphicon glyphicon-th"></span>
                                                            </div>
                                                        </div>
                                                        <!-- <input type="text" name="no_sk" class="form-control" style="width: 100%" value="<?php //echo $no_sk; ?>" required placeholder="Nomor SK"> -->
                                                        <!-- <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy"  style="width: 100%" >
                                                            <input type="text" name="tgl_sk" class="form-control" value="<?= $tgl_sk; ?>" required placeholder="Tanggal SK">
                                                            <div class="input-group-addon">
                                                                <span class="glyphicon glyphicon-th"></span>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn bg-light-blue-active"><i class="fa fa-print"></i> Surat Tugas</button>
                                                    </div>
                                                </form>
                                                <?php echo form_close() ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    }
                                    /*if ($list['status_mkpt'] == STATUS_TESIS_MKPT_UJIAN) {
                                    ?>
                                        <hr style="margin: 5px"/>
                                        <!-- Surat Tugas -->
                                        <?php $attributes = array('target' => '_blank'); ?>
                                        <?php echo form_open('prodi/magister/tesis/mkpt/cetak_surat_tugas_pengampu', $attributes) ?>
                                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                        <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                        <input type="text" name="no_surat" class="form-control" required placeholder="NOMOR SURAT">
                                        <button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Surat Tugas</button>
                                        <?php echo form_close() ?>
                                    <?php
                                    }*/
                                    ?>
                                </td>
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