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
                <a class="btn btn-xs btn-primary" href="<?= base_url()?>dashboardb/thesis/thesis/add">
                    <i class="fa fa-plus"></i> Tambah</a>
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
                            <th>Jadwal</th>
                            <th>Penguji</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach($thesis as $list){
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?php echo '<strong>'.$list['nama'].'</strong><br>'.$list['nim']?></td>
                            <td>
                            <?php 
                            $judul = $this->thesis->read_judul($list['id_skripsi']);
                            echo $judul->judul;
                            ?>
                            </td>                            
                            <td>
                            <?php 
                            $ujian = $this->thesis->read_ujian($list['id_skripsi']);
                            if($ujian)
                            {
                            echo '<strong>Tanggal</strong> :<br>'.toindo($ujian->tanggal).'<br>';
                            echo '<strong>Ruang</strong>  :<br>'.$ujian->ruang.' '.$ujian->gedung.'<br>';
                            echo '<strong>Jam</strong>     :<br>'.$ujian->jam;
                            }
                            else
                            {
                                echo '';
                            }
                            ?>
                            </td>
                            <td>
                            <?php
                            $penguji = $this->thesis->read_penguji_single($list['id_skripsi']);
                            $num = 1;
                            foreach($penguji as $show)
                            {
                                if($show['status'] == '1')
                                {
                                ?>
                                <p style="color:red">
                                <?php
                                echo $num.' '.$show['nama'].'<br>';    
                                ?>
                                </p>
                                <?php
                                }
                                else
                                {
                                echo $num.' '.$show['nama'].'<br>';    
                                }
                                $num++;
                            }
                            ?>
                            </td>
                            <td>
                                <a class="btn btn-xs btn-primary" href="<?= base_url()?>dashboardb/thesis/thesis/setting/<?php echo $list['id_skripsi']?>">
                                <i class="fa fa-gear"></i> Setting</a>
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