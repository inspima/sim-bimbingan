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
<?php $this->view('backend/widgets/tesis/informasi_status', ['jenis' => TAHAPAN_TESIS_PROPOSAL]); ?>
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
                            <th>Berkas Proposal</th>
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
                                    <?php
                                    if($list['berkas_proposal'] != '') {
                                    ?>
                                        <a href="<?php echo base_url() ?>assets/upload/mahasiswa/tesis/proposal/<?php echo $list['berkas_proposal'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                                    <?php 
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php $this->view('backend/widgets/tesis/column_penguji', ['id_tesis' => $list['id_tesis'], 'jenis' => UJIAN_TESIS_PROPOSAL]); ?>
                                </td>
                                <td class="text-center">
                                    <?php $this->view('backend/widgets/tesis/column_jadwal', ['id_tesis' => $list['id_tesis'], 'jenis' => UJIAN_TESIS_PROPOSAL]); ?>
                                </td>
                                <td class="text-center">
                                    <?php $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_PROPOSAL]); ?>
                                    <?php
                                    if ($list['status_proposal'] >= STATUS_TESIS_PROPOSAL_UJIAN) {
                                        $ujian = $this->tesis->detail_ujian_by_tesis($list['id_tesis'], UJIAN_TESIS_PROPOSAL);
                                        $pengujis = $this->tesis->read_penguji($ujian->id_ujian);

                                        $data_dokumen = [
                                            'tipe' => DOKUMEN_SK_PROPOSAL_TESIS,
                                            'jenis' => DOKUMEN_JENIS_TESIS_PROPOSAL_STR,
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

                                        $ujian = $this->tesis->detail_ujian_by_tesis($list['id_tesis'], UJIAN_TESIS_PROPOSAL);

                                        if(!empty($ujian)){
                                            $link_zoom = $ujian->link_zoom ? $ujian->link_zoom : '';
                                        }
                                        ?>
                                        <br><br>
                                        <button type="button" class="btn btn-primary col-sm-12" data-toggle="modal" data-target="#myModalSKProposal<?= $list['id_tesis']?>">
                                            <i class="fa fa-file"></i> SK Proposal
                                        </button>
                                        <br><br>
                                        <div class="modal fade" id="myModalSKProposal<?= $list['id_tesis']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <?php $attributes = array('target' => '_blank'); ?>
                                                    <?php echo form_open('prodi/magister/tesis/proposal/cetak_sk_proposal', $attributes) ?>
                                                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                                    <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">
                                                                SK Ujian Proposal
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
                                                            <button type="submit" class="btn bg-light-blue-active"><i class="fa fa-print"></i> SK Proposal</button>
                                                        </div>
                                                    </form>
                                                    <?php echo form_close() ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $data_dokumen_berita = [
                                            'tipe' => DOKUMEN_BERITA_ACARA_PROPOSAL_TESIS,
                                            'jenis' => DOKUMEN_JENIS_TESIS_PROPOSAL_STR,
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
                                            $tgl_sk = date('d/m/Y', strtotime($dokumen_berita->date_doc));
                                            $tgl_surat = date('d/m/Y', strtotime($dokumen_berita->date));
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
                                                    <?php echo form_open('prodi/magister/tesis/proposal/cetak_berita', $attributes) ?>
                                                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                                    <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">
                                                                Berita Acara Ujian Proposal
                                                                <br><?= $list['judul']?>
                                                                <br><?= $list['nama'].' - '.$list['nim'];?> 
                                                            </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                                            <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                                            <input type="text" name="no_sk" class="form-control" style="width: 100%" value="<?= $no_sk; ?>" required placeholder="Nomor SK">
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
                                            'tipe' => DOKUMEN_BERITA_ACARA_PROPOSAL_TESIS,
                                            'jenis' => DOKUMEN_JENIS_TESIS_PROPOSAL_STR,
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
                                        ?>
                                        <button type="button" class="btn btn-primary col-sm-12" data-toggle="modal" data-target="#myModalUndangan<?= $list['id_tesis']?>">
                                            <i class="fa fa-file"></i> Undangan
                                        </button>
                                        <br><br>
                                        <div class="modal fade" id="myModalUndangan<?= $list['id_tesis']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    
                                                    <?php $attributes = array('target' => '_blank'); ?>
                                                    <?php echo form_open('prodi/magister/tesis/proposal/cetak_undangan', $attributes) ?>
                                                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                                    <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">
                                                                Undangan Ujian Proposal
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
                                            'tipe' => DOKUMEN_BERITA_ACARA_PROPOSAL_TESIS,
                                            'jenis' => DOKUMEN_JENIS_TESIS_PROPOSAL_STR,
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
                                        ?>
                                        <button type="button" class="btn btn-primary col-sm-12" data-toggle="modal" data-target="#myModalDaftarHadir<?= $list['id_tesis']?>">
                                            <i class="fa fa-file"></i> Daftar Hadir
                                        </button>
                                        <br><br>
                                        <div class="modal fade" id="myModalDaftarHadir<?= $list['id_tesis']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    
                                                    <?php $attributes = array('target' => '_blank'); ?>
                                                    <?php echo form_open('prodi/magister/tesis/proposal/cetak_daftar_hadir', $attributes) ?>
                                                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                                                    <?php echo formtext('hidden', 'id_tesis', $list['id_tesis'], 'required') ?>
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">
                                                                Daftar Hadir Ujian Proposal
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