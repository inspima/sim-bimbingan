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
  <div class="col-xs-12 col-md-4">
    <div class="box">
      <!-- /.box-header -->
      <?php echo form_open('dashboardd/monitoring/jadwal/show');?>
      <div class="box-body">
        <div class="form-group">
                <label>Pilih Tanggal:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <?php echo formtext_datepicker('tanggal', '', 'required')?>
                </div>
                <!-- /.input group -->
              </div>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-success"><i class="fa fa-calendar-check-o "></i> Tampil</button>
      </div>
      <?php echo form_close()?>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->

  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?=$boxtitle.' '.$this->input->post('tanggal')?></h3>
        <div class="pull-right">
        
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive">
        <table class="table table-bordered">
          <tr>
            <td>jam/ruangan</td>
            <?php foreach($ruang as $list){?>
            <td><?=$list['ruang'].' '.$list['gedung']?></td>
            <?php } ?>
          </tr> 
          <?php foreach($jam as $show){?>
          <tr>
            <td><?=$show['jam']?></td>
            <?php foreach($ruang as $list){?>
            <td>
              <?php 
              $id_jam = $show['id_jam'];
              $id_ruang = $list['id_ruang'];
              $ada = $this->jadwal->read_tanggal($tanggal,$id_jam, $id_ruang);
              if($ada)
              {
              
                echo $ada->nama.'('.$ada->nim.')';
                echo '<br>penguji:<br>';
                $jenis_ujian = $ada->jenis_ujian;
                if($jenis_ujian == '1')
                {
                  $penguji = $this->jadwal->read_penguji_proposal($ada->id_skripsi);
                }
                else
                if($jenis_ujian == '2')
                {
                  $penguji = $this->jadwal->read_penguji_skripsi($ada->id_skripsi);
                }
                else
                if($jenis_ujian == '3')
                {
                  $penguji = $this->jadwal->read_penguji_thesis($ada->id_skripsi);
                }

                $no = 1;
                foreach($penguji as $peng){
                  if($peng['tim'] == '2')
                  {
                    $tim = 'Anggota';
                  }
                  else
                  if($peng['tim'] == '1')
                  {
                    $tim = 'Ketua';
                  }

                  if($peng['status'] == '1')
                  {
                    $clrs = 'red';
                  }
                  else
                  if($peng['status'] == '2')
                  {
                    $clrs = 'black';
                  }

                  echo '<p style="color:'.$clrs.';line-height: 14px;">'.$no.'. '.$peng['nama'].' ('.$tim.')<br>';
                $no++;
                }
              }
              else
              if(!$ada)
              {
                
              }
              ?>

            </td>
            <?php }?>
          </tr> 
          <?php } ?>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

