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
                            <th>Telp</th>
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
                                <td><?php echo $list['telp'] ?></td>
                                <td>
                                    <?php
                                    $data_dokumen_judul = [
                                        'tipe' => DOKUMEN_SP_PEMBIMBING_TESIS,
                                        'jenis' => DOKUMEN_JENIS_TESIS_JUDUL_STR,
                                        'identitas' => $list['nim'],
                                    ];
                                    $dokumen_judul = $this->dokumen->detail_by_data($data_dokumen_judul);

                                    $no_surat_judul = '';
                                    $no_sk_judul = '';
                                    $tgl_sk_judul = '';
                                    $tgl_surat_judul = '';

                                    if(!empty($dokumen_judul)){
                                        $no_surat_judul = $dokumen_judul->no_doc;
                                        $tgl_surat_judul = $dokumen_judul->date;
                                    }

                                    $ujian = $this->tesis->detail_ujian_by_tesis($list['id_tesis'], UJIAN_TESIS_PROPOSAL);
                                    ?>
                                    <b>Judul</b> <br/>
                                    <?php echo toindo($list['tgl_pengajuan']) ?><br/><br/>
                                    <b>SP Pembimbing</b> <br/>
                                    <?php echo $tgl_surat_judul ? toindo($tgl_surat_judul) : ''; ?><br/><br/>
                                    <b>Ujian Proposal</b> <br/>
                                    <?php echo $ujian ? $ujian->tanggal ? toindo($ujian->tanggal) : '' : ''; ?><br/><br/>
                                    <b>MKPT</b> <br/>
                                    <?php echo toindo($list['tgl_pengajuan_mkpt']) ?><br/><br/>
                                    <b>Tesis</b> <br/>
                                    <?php echo toindo($list['tgl_pengajuan_tesis']) ?>
                                </td>
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
                                        $ujian = $this->tesis->detail_ujian_by_tesis($list['id_tesis'], UJIAN_TESIS_UJIAN);
                                        $pengujis = $this->tesis->read_penguji($ujian->id_ujian);

                                        $data_dokumen = [
                                            'tipe' => DOKUMEN_SK_UJIAN_TESIS,
                                            'jenis' => DOKUMEN_JENIS_TESIS_UJIAN_STR,
                                            'identitas' => $list['nim'],
                                        ];
                                        $dokumen = $this->dokumen->detail_by_data($data_dokumen);

                                        $no_surat = '';
                                        $no_sk = '';
                                        $tgl_sk = '';
                                        $tgl_surat = '';
                                        $link_zoom = '';

                                        if(!empty($dokumen)){
                                            $no_surat = $dokumen->no_doc;
                                            $no_sk = $dokumen->no_ref_doc;
                                            $tgl_sk = date('d/m/Y', strtotime($dokumen->date_doc));
                                            $tgl_surat = date('d/m/Y', strtotime($dokumen->date));
                                        }

                                        $ujian = $this->tesis->detail_ujian_by_tesis($list['id_tesis'], UJIAN_TESIS_UJIAN);

                                        if(!empty($ujian)){
                                            $link_zoom = $ujian->link_zoom ? $ujian->link_zoom : '';
                                        }
                                        ?>
                                        <br><br>
                                        <button type="button" class="btn btn-primary col-sm-12" data-toggle="modal" data-target="#myModalSKTesis<?= $list['id_tesis']?>">
                                            <i class="fa fa-file"></i> SK Ujian
                                        </button>
                                        <br><br>
                                        <div class="modal fade" id="myModalSKTesis<?= $list['id_tesis']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <?php $attributes = array('target' => '_blank'); ?>
                                                    <?php echo form_open('prodi/magister/tesis/ujian/cetak_sk_tesis', $attributes) ?>
                                                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                                    <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">
                                                                SK Ujian Tesis
                                                                <br><?= $list['judul']?>
                                                                <br><?= $list['nama'].' - '.$list['nim'];?> 
                                                            </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                                            <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                                            <?php
                                                            if($list['id_prodi'] == S2_ILMU_HUKUM){
                                                            ?>
                                                                <input type="text" name="no_sk" class="form-control" style="width: 100%" value="<?= $no_sk; ?>" required placeholder="Nomor SK">
                                                                <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy"  style="width: 100%" >
                                                                    <input type="text" name="tgl_sk" class="form-control" value="<?= $tgl_sk; ?>" required placeholder="Tanggal Penetapan">
                                                                    <div class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-th"></span>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            }
                                                            else if($list['id_prodi'] == S2_KENOTARIATAN){
                                                            ?>
                                                                <input type="text" name="no_surat" class="form-control" style="width: 100%" value="<?= $no_surat; ?>" required placeholder="Nomor SK 1a">
                                                                <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy"  style="width: 100%" >
                                                                    <input type="text" name="tgl_surat" class="form-control" value="<?= $tgl_surat; ?>" required placeholder="Tanggal SK 1b">
                                                                    <div class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-th"></span>
                                                                    </div>
                                                                </div>
                                                                <input type="text" name="no_sk" class="form-control" style="width: 100%" value="<?= $no_sk; ?>" required placeholder="Nomor SK 2a">
                                                                <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy"  style="width: 100%" >
                                                                    <input type="text" name="tgl_sk" class="form-control" value="<?= $tgl_sk; ?>" required placeholder="Tanggal SK 2b">
                                                                    <div class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-th"></span>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn bg-light-blue-active"><i class="fa fa-print"></i> SK Tesis</button>
                                                        </div>
                                                    </form>
                                                    <?php echo form_close() ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $data_dokumen_berita = [
                                            'tipe' => DOKUMEN_BERITA_ACARA_UJIAN_TESIS,
                                            'jenis' => DOKUMEN_JENIS_TESIS_UJIAN_STR,
                                            'identitas' => $list['nim'],
                                        ];
                                        $dokumen_berita = $this->dokumen->detail_by_data($data_dokumen_berita);

                                        $no_surat = '';
                                        $no_sk = '';
                                        $tgl_sk = '';
                                        $tgl_surat = '';
                                        $link_zoom = '';

                                        if(!empty($dokumen_berita)){
                                            $no_surat = $dokumen_berita->no_doc;
                                            $no_sk = $dokumen_berita->no_ref_doc;
                                            $tgl_sk = $dokumen_berita->date_doc ? date('d/m/Y', strtotime($dokumen_berita->date_doc)) : '';
                                            $tgl_surat = $dokumen_berita->date ? date('d/m/Y', strtotime($dokumen_berita->date)) : '';
                                            //echo $dokumen_berita->date_doc;
                                        }

                                        $ujian = $this->tesis->detail_ujian_by_tesis($list['id_tesis'], UJIAN_TESIS_UJIAN);

                                        if(!empty($ujian)){
                                            $link_zoom = $ujian->link_zoom ? $ujian->link_zoom : '';
                                        }
                                        ?>
                                        <button type="button" class="btn btn-primary col-sm-12" data-toggle="modal" data-target="#myModalBeritaAcara<?= $list['id_tesis']?>">
                                            <i class="fa fa-file"></i> Berita Acara
                                        </button>
                                        <br><br>
                                        <div class="modal fade" id="myModalBeritaAcara<?= $list['id_tesis']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    
                                                    <?php $attributes = array('target' => '_blank'); ?>
                                                    <?php echo form_open('prodi/magister/tesis/ujian/cetak_berita', $attributes) ?>
                                                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                                    <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">
                                                                Berita Acara Ujian Tesis
                                                                <br><?= $list['judul']?>
                                                                <br><?= $list['nama'].' - '.$list['nim'];?> 
                                                            </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                                            <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                                            <input type="text" name="no_sk" class="form-control" style="width: 100%" value="<?= $no_sk; ?>" required placeholder="Nomor SK">
                                                            <div class="input-group date" data-provide="datepicker" data-date-format="dd/mm/yyyy"  style="width: 100%" >
                                                                <input type="text" name="tgl_sk" class="form-control" value="<?= $tgl_sk; ?>" required placeholder="Tanggal Penetapan">
                                                                <div class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-th"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn bg-light-blue-active"><i class="fa fa-print"></i> Berita Acara</button>
                                                        </div>
                                                    </form>
                                                    <?php echo form_close() ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $data_dokumen_undangan = [
                                            'tipe' => DOKUMEN_UNDANGAN_UJIAN_TESIS,
                                            'jenis' => DOKUMEN_JENIS_TESIS_UJIAN_STR,
                                            'identitas' => $list['nim'],
                                        ];
                                        $dokumen_undangan = $this->dokumen->detail_by_data($data_dokumen_undangan);

                                        $no_surat = '';
                                        $no_sk = '';
                                        $tgl_sk = '';
                                        $tgl_surat = '';
                                        $link_zoom = '';

                                        if(!empty($dokumen_undangan)){
                                            $no_surat = $dokumen_undangan->no_doc;
                                            $no_sk = $dokumen_undangan->no_ref_doc;
                                            $tgl_sk = date('d/m/Y', strtotime($dokumen_undangan->date_doc));
                                            $tgl_surat = date('d/m/Y', strtotime($dokumen_undangan->date));
                                        }

                                        $ujian = $this->tesis->detail_ujian_by_tesis($list['id_tesis'], UJIAN_TESIS_UJIAN);

                                        if(!empty($ujian)){
                                            $link_zoom = $ujian->link_zoom ? $ujian->link_zoom : '';
                                        }
                                        ?>
                                        <button type="button" class="btn btn-primary col-sm-12" data-toggle="modal" data-target="#myModalUndangan<?= $list['id_tesis']?>">
                                            <i class="fa fa-file"></i> Undangan
                                        </button>
                                        <br><br>
                                        <div class="modal fade" id="myModalUndangan<?= $list['id_tesis']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    
                                                    <?php $attributes = array('target' => '_blank'); ?>
                                                    <?php echo form_open('prodi/magister/tesis/ujian/cetak_undangan', $attributes) ?>
                                                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                                    <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">
                                                                Undangan Ujian Tesis
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
                                                            <input type="text" name="link_zoom" class="form-control" style="width: 100%" value="<?= $link_zoom; ?>" required placeholder="Link Zoom">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn bg-light-blue-active"><i class="fa fa-print"></i> Undangan</button>
                                                        </div>
                                                    </form>
                                                    <?php echo form_close() ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $data_dokumen_presensi = [
                                            'tipe' => DOKUMEN_DAFTAR_HADIR_UJIAN_TESIS,
                                            'jenis' => DOKUMEN_JENIS_TESIS_UJIAN_STR,
                                            'identitas' => $list['nim'],
                                        ];
                                        $dokumen_presensi = $this->dokumen->detail_by_data($data_dokumen_presensi);

                                        $no_surat = '';
                                        $no_sk = '';
                                        $tgl_sk = '';
                                        $tgl_surat = '';
                                        $link_zoom = '';

                                        if(!empty($dokumen_presensi)){
                                            $no_surat = $dokumen_presensi->no_doc;
                                            $no_sk = $dokumen_presensi->no_ref_doc;
                                            $tgl_sk = date('d/m/Y', strtotime($dokumen_presensi->date_doc));
                                            $tgl_surat = date('d/m/Y', strtotime($dokumen_presensi->date));
                                        }

                                        $ujian = $this->tesis->detail_ujian_by_tesis($list['id_tesis'], UJIAN_TESIS_UJIAN);

                                        if(!empty($ujian)){
                                            $link_zoom = $ujian->link_zoom ? $ujian->link_zoom : '';
                                        }
                                        ?>
                                        <button type="button" class="btn btn-primary col-sm-12" data-toggle="modal" data-target="#myModalDaftarHadir<?= $list['id_tesis']?>">
                                            <i class="fa fa-file"></i> Daftar Hadir
                                        </button>
                                        <br><br>
                                        <div class="modal fade" id="myModalDaftarHadir<?= $list['id_tesis']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    
                                                    <?php $attributes = array('target' => '_blank'); ?>
                                                    <?php echo form_open('prodi/magister/tesis/ujian/cetak_daftar_hadir', $attributes) ?>
                                                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                                    <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">
                                                                Daftar Hadir Ujian Tesis
                                                                <br><?= $list['judul']?>
                                                                <br><?= $list['nama'].' - '.$list['nim'];?> 
                                                            </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                                            <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                                            <input type="text" name="link_zoom" class="form-control" style="width: 100%" value="<?= $link_zoom; ?>" required placeholder="Link Zoom">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn bg-light-blue-active"><i class="fa fa-print"></i> Daftar Hadir</button>
                                                        </div>
                                                    </form>
                                                    <?php echo form_close() ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- <hr style="margin: 2px"/> -->
                                        <!-- SK Proposal -->
                                        <?php //$attributes = array('target' => '_blank'); ?>
                                        <?php //echo form_open('prodi/magister/tesis/proposal/cetak_sk_proposal', $attributes) ?>
                                        <?php //echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                        <?php //echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                        <!-- <input type="text" name="no_sk" class="form-control" required placeholder="NOMOR SK">
                                        <button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> SK Proposal</button> -->
                                        <?php //echo form_close() ?>  
                                        <!-- <hr style="margin: 5px"/> -->
                                        <!-- Berita Acara -->
                                        <?php //$attributes = array('target' => '_blank'); ?>
                                        <?php //echo form_open('prodi/magister/tesis/proposal/cetak_berita', $attributes) ?>
                                        <?php //echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                        <?php //echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                        <!-- <button type="submit" class="btn btn-xs bg-light-blue-active"><i class="fa fa-print"></i> Berita Acara</button> -->
                                        <?php //echo form_close() ?>                                                                    
                                        <?php
                                    }
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