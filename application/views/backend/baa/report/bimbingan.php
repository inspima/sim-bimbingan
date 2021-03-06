<head>
</head>

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
                        <?php echo form_open('backend/baa/report/skripsi');?>
                         <!--<tr>
                            <td>Semester</td>
                            <td>
                                 <select name="id_semester" class="form-control select2" style="width: 100%;" required>
                                    <option value="">Pilih</option>
                                    <?php 
                                    foreach($semester as $list){
                                    ?>
                                    <option value="<?php echo $list['id_semester']?>" <?php if($id_semester == $list['id_semester']) {echo " selected ";}?>><?php echo $list['semester']?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                       <tr>
                            <td>Tgl Awal</td>
                            <td><input type="date" name="start-date"></td>
                        </tr>
                        <tr>
                            <td>Tgl Akhir</td>
                            <td><input type="date" name="end-date"></td>
                        </tr>
                        <tr>
                            <td>Departemen</td>
                            <td>
                                <select name="id_departemen" class="form-control select2" style="width: 100%;" required>
                                    <option value="">Pilih</option>
                                    <?php 
                                    foreach($departemen as $listdep){
                                    ?>
                                    <option value="<?php echo $listdep['id_departemen']?>" <?php if($id_departemen == $listdep['id_departemen']) {echo " selected ";}?>><?php echo $listdep['departemen']?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" name="submit" value="submit"></td>
                        </tr>-->
                        <?=form_close()?>
                    </table>
                </div>
                <hr/>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah Bimbingan</th>
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
                                <td><a href="bimbingan/detail_bimbingan/<?=$d_b->nip?>" target="_blank"><?php echo $d_b->jumlah ?></a></td>
                                
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>

<script>
   $(function(){
     $("#example1").DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'copyHtml5',
            'pageLength'
        ],
    });
   })
</script>