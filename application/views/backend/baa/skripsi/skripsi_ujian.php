<?php if($this->session->flashdata('msg')): ?>
  <?php 
  $class_alert = 'alert '.$this->session->flashdata('msg-title').' alert-dismissable';
  ?>
  <div class='<?=$class_alert?>'>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-check"></i> Notifikasi</h4>
    <?php echo $this->session->flashdata('msg'); ?>
  </div>
<?php endif; ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?=$subtitle?></h3>
                <div class="pull-right">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Judul</th>
                            <th>Berkas Skripsi&Turnitin</th>
                            <th>Pembimbing</th>
                            <th>Departemen</th>
                            <th>Gelombang / Semester</th>
                            <th>Jadwal</th>
                            <th>Penguji</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach($skripsi as $list){
                        $penguji = $this->skripsi->count_penguji_approve($list['id_ujian']);
                        if($penguji < 5)
                        {

                        }
                        else
                        if($penguji == 5)
                        {
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?=$list['nama'].'<br>'.$list['nim']?></td>
                            <td><?php 
                            $judul = $this->skripsi->read_judul($list['id_skripsi']);
                            echo $judul->judul;
                            ?></td>
                             <td><a href="<?php echo base_url()?>assets/upload/turnitin/<?php echo $list['turnitin']?>" target="_blank"><img src="<?php echo base_url()?>assets/img/pdf.png" width="20px" height="auto"></a></td>
                            <td><?php 
                            $pembimbing = $this->skripsi->read_pembimbing($list['id_skripsi']);
                            echo $pembimbing->nama;
                            ?></td>                         
                            <td><?php echo $list['departemen']?></td>
                            <td><?=$list['gelombang'].' / '.$list['semester']?></td>
                            <td>
                            <?php 
                                echo '<strong>Tanggal : </strong>'.toindo($list['tanggal']).'<br>';
                                echo '<strong>Jam     : </strong>'.$list['jam'].'<br>';
                                echo '<strong>Ruang   : </strong>'.$list['ruang'].' - '.$list['gedung'].'<br>';
                            ?>
                            </td>
                            <td>
                            <?php 
                            $penguji = $this->skripsi->read_penguji($list['id_ujian']);
                            foreach($penguji as $show)
                            {
                                if($show['status_tim'] == '1')
                                {
                                    $ka = 'ketua';
                                }
                                else
                                if($show['status_tim'] == '2')
                                {
                                    $ka = 'anggota';
                                }

                                if($show['usulan_dosbing'] == '0')
                                {
                                    $up = '';
                                }
                                else
                                if($show['usulan_dosbing'] == '1')
                                {
                                    $up = '- usulan pembimbing';
                                }
                                else
                                if($show['usulan_dosbing'] == '2')
                                {
                                    $up = '- pembimbing';
                                }

                                echo '- '.$show['nama'].'<strong>('.$ka.$up.')</strong><br>';
                            }
                            ?>
                            </td>
                            <td>
                            <?php 
                            $ketua = $this->skripsi->read_pengujiketua($list['id_ujian']);
                            if($ketua)
                            {

                            }
                            else
                            {
                                echo 'belum set ketua penguji';
                            }
                            ?>
                            <!-- Surat Tugas -->
                            <?php $attributes = array('target' => '_blank');?>
                            <?php echo form_open('dashboardb/skripsi/skripsi_ujian/cetak_surat_tugas', $attributes)?>
                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                            <?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
                            <?php echo formtext('hidden', 'id_ujian', $list['id_ujian'], 'required') ?>
                            <button type="submit" class="btn btn-xs btn-primary">Surat Tugas</button>
                            <?php echo form_close()?>
                            <!-- Berita Acara -->
                            <?php $attributes = array('target' => '_blank');?>
                            <?php echo form_open('dashboardb/skripsi/skripsi_ujian/cetak_berita', $attributes)?>
                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                            <?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
                            <?php echo formtext('hidden', 'id_ujian', $list['id_ujian'], 'required') ?>
                            <button type="submit" class="btn btn-xs btn-primary">Cetak Berita</button>
                            <?php echo form_close()?>
                            <!-- Pemberitahuan -->
                            <?php $attributes = array('target' => '_blank');?>
                            <?php echo form_open('dashboardb/skripsi/skripsi_ujian/cetak_pemberitahuan', $attributes)?>
                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                            <?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
                            <?php echo formtext('hidden', 'id_ujian', $list['id_ujian'], 'required') ?>
                            <button type="submit" class="btn btn-xs btn-primary">Cetak Pemberitahuan</button>
                            <?php echo form_close()?>
                            <!-- Penilaian -->
                            <?php $attributes = array('target' => '_blank');?>
                            <?php echo form_open('dashboardb/skripsi/skripsi_ujian/cetak_penilaian', $attributes)?>
                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                            <?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
                            <?php echo formtext('hidden', 'id_ujian', $list['id_ujian'], 'required') ?>
                            <button type="submit" class="btn btn-xs btn-primary">Cetak Penilaian</button>
                            <?php echo form_close()?>
                            <!-- Rekapitulasi -->
                            <?php $attributes = array('target' => '_blank');?>
                            <?php echo form_open('dashboardb/skripsi/skripsi_ujian/cetak_rekapitulasi', $attributes)?>
                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                            <?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
                            <?php echo formtext('hidden', 'id_ujian', $list['id_ujian'], 'required') ?>
                            <button type="submit" class="btn btn-xs btn-primary">Cetak Rekapitulasi</button>
                            <?php echo form_close()?>
                            <!-- Perbaikan -->
                            <?php $attributes = array('target' => '_blank');?>
                            <?php echo form_open('dashboardb/skripsi/skripsi_ujian/cetak_perbaikan', $attributes)?>
                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                            <?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
                            <?php echo formtext('hidden', 'id_ujian', $list['id_ujian'], 'required') ?>
                            <button type="submit" class="btn btn-xs btn-primary">Cetak Perbaikan</button>
                            <?php echo form_close()?>
                            <!-- konsumsi -->
                            <?php $attributes = array('target' => '_blank');?>
                            <?php echo form_open('dashboardb/skripsi/skripsi_ujian/cetak_absensi', $attributes)?>
                            <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                            <?php echo formtext('hidden', 'id_skripsi', $list['id_skripsi'], 'required') ?>
                            <?php echo formtext('hidden', 'id_ujian', $list['id_ujian'], 'required') ?>
                            <button type="submit" class="btn btn-xs btn-primary">Cetak Konsumsi</button>
                            <?php echo form_close()?>
                            </td>

                        </tr>      
                        <?php 
                        $no++;
                        } 
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