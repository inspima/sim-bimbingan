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
<div class="btn-group">
    <?php 
    foreach($prodi as $data){
    $id = $this->uri->segment(5) ? $this->uri->segment(5) : $max_id_prodi;
    ?>
        <a class="<?= ($id == $data['id_prodi']) ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>dosen/tesis/mkpt/pengampu/<?= $data['id_prodi']?>"><?= $data['jenjang'].' '.$data['nm_prodi'];?></a>   
    <?php
    }
    ?>
</div>
<div class="divider10"></div>
<div class="box">
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Mahasiswa</th>
                    <th>Tesis</th>
                    <th>Departemen</th>                    
                    <th>MKPT</th>
                    <th>Berkas MKPT</th>
                    <th>Status</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($tesis_mkpt as $list) {
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= '<b>' . $list['nama_mhs'] . '</b><br>' . $list['nim'].'<br>';?></td>
                        <td><?php
                            if($list['jenis'] == TAHAPAN_TESIS_JUDUL){ 
                                $judul = $this->tesis->read_judul($list['id_tesis'], TAHAPAN_TESIS_JUDUL);
                            }
                            if($list['jenis'] == TAHAPAN_TESIS_PROPOSAL){ 
                                $judul = $this->tesis->read_judul($list['id_tesis'], TAHAPAN_TESIS_PROPOSAL);
                            }
                            if($list['jenis'] == TAHAPAN_TESIS_MKPT){ 
                                $judul = $this->tesis->read_judul($list['id_tesis'], TAHAPAN_TESIS_MKPT);
                            }
                            if($list['jenis'] == TAHAPAN_TESIS_UJIAN){ 
                                $judul = $this->tesis->read_judul($list['id_tesis'], TAHAPAN_TESIS_UJIAN);
                            }
                            echo '<b>Judul : </b>'.$judul->judul.'<br>';
                            echo '<b>Latar Belakang : </b>'.$judul->latar_belakang.'<br>';
                            echo '<b>Rumusan Masalah Pertama : </b>'.$judul->rumusan_masalah_pertama.'<br>';
                            echo '<b>Rumusan Masalah Kedua : </b>'.$judul->rumusan_masalah_kedua.'<br>';
                            echo '<b>Rumusan Masalah Ketiga Dst. : </b>'.$judul->rumusan_masalah_lain.'<br>';
                            echo '<b>Penelusuran Artikel Internet : </b>'.$judul->penelusuran_artikel_internet.'<br>';
                            echo '<b>Penelusuran Artikel Repository UNAIR : </b>'.$judul->penelusuran_artikel_unair.'<br>';
                            echo '<b>Uraian Topik : </b>'.$judul->uraian_topik.'<br>';

                            if($list['berkas_orisinalitas'] != '') {
                                echo '<b>Berkas Orisinalitas : </b><a href="'.base_url().'assets/upload/mahasiswa/tesis/judul/'.$list['berkas_orisinalitas'].'" target="_blank"><img src="'. base_url() .'assets/img/pdf.png" width="20px" height="auto"></a><br>';
                            }

                            ?>
                        </td>
                        <td><?= $list['departemen'] ?></td>
                        <td>
                            <?php
                            echo '<b>Kode</b><br>'.$list['kode'].'<br>';
                            echo '<b>MKPT</b><br>'.$list['mkpt'].'<br>';
                            echo '<b>SKS</b><br>'.$list['sks'].'<br><br>';
                            echo '<b>Pengampu MKPT</b><br><b>'.$list['nama_pengampu_mkpt'].'</b><br>'.$list['nip_pengampu_mkpt'].'<br>';
                            if($list['status_pengampu_mkpt'] == NULL) {
                            ?>
                                <a class="btn btn-xs btn-primary pull-left" href="#">
                                <i class="fa fa-check"></i> Pengajuan</a>
                            <?php
                            } else if($list['status_pengampu_mkpt'] == '1') {
                            ?>
                                <a class="btn btn-xs btn-success pull-left" href="#">
                                <i class="fa fa-check"></i> Diterima</a>
                            <?php
                            } else if($list['status_pengampu_mkpt'] == '2') {
                            ?>
                                <a class="btn btn-xs btn-success pull-left" href="#">
                                <i class="fa fa-check"></i> Ditolak</a>
                            <?php
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            if($list['berkas_mkpt'] != '') {
                            ?>
                                <a href="<?php echo base_url() ?>assets/upload/mahasiswa/tesis/mkpt/<?php echo $list['berkas_mkpt'] ?>" target="_blank"><img src="<?php echo base_url() ?>assets/img/pdf.png" width="20px" height="auto"></a>
                            <?php 
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            if($list['jenis'] == TAHAPAN_TESIS_JUDUL){ 
                                $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_JUDUL]); 
                            }
                            if($list['jenis'] == TAHAPAN_TESIS_PROPOSAL){ 
                                $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_PROPOSAL]); 
                            }
                            if($list['jenis'] == TAHAPAN_TESIS_MKPT){ 
                                $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_MKPT]); 
                            }
                            if($list['jenis'] == TAHAPAN_TESIS_MKPT){ 
                                $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_UJIAN]); 
                            }
                            if ($list['status_proposal'] > STATUS_TESIS_PROPOSAL_UJIAN) {
                                ?>
                                <hr style="margin:5px"/>
                                <b>Hasil Ujian Proposal</b><br/>
                                <?php
                                echo $this->tesis->get_status_ujian($list['status_ujian_proposal'], UJIAN_TESIS_PROPOSAL);
                            }
                            if ($list['status_mkpt'] > STATUS_TESIS_MKPT_UJIAN) {
                                ?>
                                <hr style="margin:5px"/>
                                <b>Hasil Ujian Proposal</b><br/>
                                <?php
                                echo $this->tesis->get_status_ujian($list['status_ujian_mkpt'], UJIAN_TESIS_MKPT);
                            }
                            if ($list['status_tesis'] > STATUS_TESIS_UJIAN) {
                                ?>
                                <hr style="margin:5px"/>
                                <b>Hasil Ujian Tesis</b><br/>
                                <?php
                                echo $this->tesis->get_status_ujian($list['status_ujian_tesis'], UJIAN_TESIS_UJIAN);
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            if($list['nip_pengampu_mkpt'] == $this->session_data['username']){
                                if($list['status_pengampu_mkpt'] == NULL) {
                                ?>
                                    <a class="btn btn-xs btn-success" href="<?= base_url()?>dosen/tesis/mkpt/approve_pengampu/<?= $list['id_tesis_mkpt_pengampu']?>/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Approve</a>
                                    <a class="btn btn-xs btn-danger" href="<?= base_url()?>dosen/tesis/mkpt/reject_pengampu/<?= $list['id_tesis_mkpt_pengampu']?>/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Reject</a>
                                <?php
                                } else if($list['status_pengampu_mkpt'] != NULL && $list['status_mkpt'] < STATUS_TESIS_MKPT_UJIAN) {
                                ?>
                                    <a class="btn btn-xs btn-warning" href="<?= base_url()?>dosen/tesis/mkpt/batal_pengampu/<?= $list['id_tesis_mkpt_pengampu']?>/<?= $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Batal</a>
                                <?php
                                } else if($list['status_pengampu_mkpt'] != NULL && $list['status_mkpt'] == STATUS_TESIS_MKPT_UJIAN) {
                                ?>
                                    <a class="btn btn-xs btn-success pull-left" href="<?= base_url()?>dosen/tesis/mkpt/nilai/<?php echo $list['id_tesis_mkpt_pengampu']?>/<?php echo $list['id_tesis']?>">
                                    <i class="fa fa-edit"></i> Nilai</a>
                                <?php
                                } 
                            }
                            ?>
                        </td>
                    </tr>      
                    <?php
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>



<!-- /.box -->