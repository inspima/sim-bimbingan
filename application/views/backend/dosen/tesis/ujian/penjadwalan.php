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
        <a class="<?= ($id == $data['id_prodi']) ? 'btn btn-default' : 'btn bg-blue'; ?>" href="<?php echo base_url() ?>dosen/tesis/ujian/penjadwalan/<?= $data['id_prodi']?>"><?= $data['jenjang'].' '.$data['nm_prodi'];?></a>   
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
                    <th>Info Tesis</th>
                    <th class="text-center">Berkas Proposal</th>
                    <th class="text-center">Berkas Tesis</th>
                    <th class="text-center">Berkas Syarat</th>
                    <th>Tgl.Pengajuan</th>
                    <th colspan="2">Pembimbing</th>
                    <th class="text-center">Status</th>
                    <th>Ujian</th>
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
                        <td class="text-center">
                            <a href="<?php echo base_url()?>assets/upload/mahasiswa/tesis/proposal/<?php echo $list['berkas_proposal']?>" target="_blank"><img src="<?php echo base_url()?>assets/img/pdf.png" width="20px" height="auto"></a>
                        </td>
                        <td class="text-center">
                            <a href="<?php echo base_url()?>assets/upload/mahasiswa/tesis/ujian/<?php echo $list['berkas_tesis']?>" target="_blank"><img src="<?php echo base_url()?>assets/img/pdf.png" width="20px" height="auto"></a>
                        </td>
                        <td class="text-center">
                            <a href="<?php echo base_url()?>assets/upload/mahasiswa/tesis/ujian/<?php echo $list['berkas_syarat_tesis']?>" target="_blank"><img src="<?php echo base_url()?>assets/img/pdf.png" width="20px" height="auto"></a>
                        </td>
                        <td><?php echo toindo($list['tgl_pengajuan']) ?></td>
                        <td><?php echo $list['nama_pembimbing_satu'] ?><br/><b><?php echo $list['nip_pembimbing_satu'] ?></b></td>
                        <td><?php echo $list['nama_pembimbing_dua'] ?><br/><b><?php echo $list['nip_pembimbing_dua'] ?></b></td>
                        <td class="text-center">
                            <?php $this->view('backend/widgets/tesis/column_status', ['tesis' => $list, 'jenis' => TAHAPAN_TESIS_UJIAN]); ?>
                            <?php if ($list['status_tesis'] > STATUS_TESIS_UJIAN) {
                                ?>
                                <hr style="margin:5px"/>
                                <b>Hasil Ujian</b><br/>
                                <?php
                                echo $this->tesis->get_status_ujian($list['status_ujian_tesis'], UJIAN_TESIS_UJIAN);
                            }
                            ?>
                        </td>
                        <td>
                        	<a href="<?= base_url() ?>dosen/tesis/ujian/setting/<?= $list['id_tesis'] ?>" class="btn btn-xs bg-blue"><i class="fa fa-edit"></i> Ujian & Penguji</a>
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