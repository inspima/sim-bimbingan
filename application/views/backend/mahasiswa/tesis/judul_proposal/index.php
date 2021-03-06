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
<?php $this->view('backend/widgets/tesis/informasi_status', ['jenis' => TAHAPAN_TESIS_JUDUL_PROPOSAL]); ?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Tabel <?= $subtitle ?></h3>
        <div class="pull-right">
            <a class="btn btn-primary" href="<?= base_url() ?>mahasiswa/tesis/judul_proposal/add">
                <i class="fa fa-plus"></i> TAMBAH</a>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tesis</th>
                    <th>Departemen</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($tesis as $list) {
                    ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?php
                            $judul = $this->tesis->read_judul($list['id_tesis']);
                            echo '<b>Judul : </b>'.$judul->judul.'<br>';
                            echo '<b>Latar Belakang : </b>'.$judul->latar_belakang.'<br>';
                            echo '<b>Rumusan Masalah Pertama : </b>'.$judul->rumusan_masalah_pertama.'<br>';
                            echo '<b>Rumusan Masalah Kedua : </b>'.$judul->rumusan_masalah_kedua.'<br>';
                            echo '<b>Rumusan Masalah Ketiga Dst. : </b>'.$judul->rumusan_masalah_lain.'<br>';
                            echo '<b>Penelusuran Artikel Internet : </b>'.$judul->penelusuran_artikel_internet.'<br>';
                            echo '<b>Penelusuran Artikel Repository UNAIR : </b>'.$judul->penelusuran_artikel_unair.'<br>';
                            echo '<b>Uraian Topik : </b>'.$judul->uraian_topik.'<br>';

                            if($list['berkas_orisinalitas'] != '') {
                                echo '<b>Berkas Orisinalitas : </b><a href="'.base_url().'assets/upload/mahasiswa/tesis/judul_proposal/'.$list['berkas_orisinalitas'].'" target="_blank"><img src="'. base_url() .'assets/img/pdf.png" width="20px" height="auto"></a><br>';
                            }

                            $dosbing_satu = '<i>belum ditentukan</i>';
                            $dosbing_dua = '<i>belum ditentukan</i>';
                            if($list['nip_pembimbing_satu'] != '' && $list['nip_pembimbing_satu'] != ''){
                                $dosbing_satu = $list['nip_pembimbing_satu'].' '.$list['nama_pembimbing_satu'];
                            }
                            if($list['nip_pembimbing_dua'] != '' && $list['nip_pembimbing_dua'] != ''){
                                $dosbing_dua = $list['nip_pembimbing_dua'].' '.$list['nama_pembimbing_dua'];
                            }
                            
                            echo '<b>Pembimbing Utama : </b>'.$dosbing_satu.' ';
                            
                            if($list['status_pembimbing_satu'] == NULL) {
                                echo '';
                            } else if($list['status_pembimbing_satu'] == '1') {
                            
                                echo '<a class="btn btn-xs btn-success pull-left" href="#">
                                <i class="fa fa-check"></i> Diterima</a>';
                            } else if($list['status_pembimbing_satu'] == '2') {
                            
                                echo '<a class="btn btn-xs btn-danger pull-left" href="#">
                                <i class="fa fa-check"></i> Ditolak</a>';
                            }

                            echo '<br>';
                            
                            echo '<b>Pembimbing Kedua : </b>'.$dosbing_dua.' ';

                            if($list['status_pembimbing_dua'] == NULL) {
                                echo '';
                            } else if($list['status_pembimbing_dua'] == '1') {
                                echo '<a class="btn btn-xs btn-success pull-left" href="#">
                                <i class="fa fa-check"></i> Diterima</a>';
                            } else if($list['status_pembimbing_dua'] == '2') {
                                echo '<a class="btn btn-xs btn-danger pull-left" href="#">
                                <i class="fa fa-check"></i> Ditolak</a>';
                            }

                            ?>
                        </td>
                        <td><?= $list['departemen'] ?></td>
                        <td><?= date('d-m-Y', strtotime($list['tgl_pengajuan'])) ?></td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_JUDUL_PROPOSAL]); ?>
                            <?php
                            if ($list['status_judul_proposal'] == STATUS_TESIS_JUDUL_PROPOSAL_PENGAJUAN)
                            {
                            ?>
                                <a href="<?= base_url() ?>mahasiswa/tesis/judul_proposal/edit/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-green"><i class="fa fa-edit"></i> Edit</a>
                            <?php
                            } 
                            if ($list['status_proposal'] < STATUS_TESIS_PROPOSAL_PENGAJUAN && $list['status_judul_proposal'] == STATUS_TESIS_JUDUL_PROPOSAL_SETUJUI_PEMBIMBING)
                            {
                            ?>
                                <hr style = "margin:5px"/>
                                <a href = "<?= base_url() ?>mahasiswa/tesis/proposal/add/<?= $list['id_tesis'] ?>" class = "btn btn-xs bg-blue"><i class = "fa fa-mail-forward"></i> Ajukan Proposal</a>
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