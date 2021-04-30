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
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $subtitle ?></h3>
                <div class="pull-right">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <div>
                    <table width="50%">
                        <?php echo form_open();?>
                        <tr>
                            <td>Tgl Awal</td>
                            <td><input type="date" name="start" value="<?=$start?>"></td>
                        </tr>
                        <tr>
                            <td>Tgl Akhir</td>
                            <td><input type="date" name="end" value="<?=$end?>"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" name="submit" value="submit"></td>
                        </tr>
                        <?=form_close()?>
                    </table>
                </div>
                <hr/>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Judul Proposal</th>
                            <th>Judul MKPT</th>
                            <th>Judul Tesis</th>
                            <th>Tanggal Ujian</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($data_ujian as $d_ujian) {
                            
                        
                        //var_dump($d_ujian);
                        
                            
                            ?>
                            
                            <tr>
                                <td><?= $no ?></td>
                                <td><?php echo '<strong>' . $d_ujian->nama  ?></td>
                                <td><?php echo '</strong><br>' . $d_ujian->nim ?></td>
                                <td><?php echo $d_ujian->proposal ?></td>
                                <td><?php echo $d_ujian->mkpt?></td>
                                <td><?php echo $d_ujian->tesis?></td>
                                <td><?php echo $d_ujian->tanggal?></td>
                                <td><?php echo $d_ujian->nilai ?></td>
                                
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