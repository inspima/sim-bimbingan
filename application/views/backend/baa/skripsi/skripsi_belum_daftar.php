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
                <!-- this is option -->
                <select id="select_departemen">
                    <option value="">Semua</option>
                    <?php foreach($list_departemen as $departemen){ ?>
                    <option value="<?php echo $departemen["id_departemen"] ?>" <?php echo $id_departemen == $departemen["id_departemen"] ? "selected" : "" ?>><?php echo $departemen["departemen"] ?></option>
                    <?php } ?>
                </select>

                <!-- this is table -->
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Judul</th>
                            <th>Departemen</th>
                            <th>Berkas Skripsi & Turnitin</th>
                           <!-- <th>Gelombang (Semester)</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <div class="form-group">
                        <?php 
                        $no = 1;
                        foreach($skripsi as $list){
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?php echo '<strong>'.$list['nama'].'</strong><br>'.$list['nim']?></td>
                            <td>
                           <?php echo $list['judul']?>
                            </td>                            
                            <td><?php echo $list['departemen']?></td>
                            <td><a href="<?php echo base_url()?>assets/upload/turnitin/<?php echo $list['turnitin']?>" target="_blank"><img src="<?php echo base_url()?>assets/img/pdf.png" width="20px" height="auto"></a></td>
                           <!-- <td><?//php echo $list['gelombang']?></td>-->
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

<script>
    $(function () {
        // datatable ribet, gk jadi via clientside
        $('#select_departemen').on('change', function (e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            // refresh halaman + get
            var url = UpdateQueryString("dept", valueSelected)
            window.location = url;
        });
    })
</script>