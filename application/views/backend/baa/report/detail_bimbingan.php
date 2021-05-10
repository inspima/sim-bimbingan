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
                <div class="pull-left">
                 
                </div>
                 
            </div>
            <div class="box-header">
                <!--<a class="btn btn-primary" href="<?php echo base_url().'backend/baa/report/bimbingan'?>" role="button">Back</a>-->
            </div>
            
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                
                <hr/>
                <table id="datatable-export" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>JUDUL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        //var_dump($data_ujian);
                        foreach ($data_bimbingan as $d_b) {
                            ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?php echo '<strong>' . $d_b->nama  ?></td>
                                <td><?php echo '<strong>' . $d_b->nim  ?></td>
                                <td><?php echo '<strong>' . $d_b->judul  ?></td>
                                
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