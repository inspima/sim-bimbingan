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
                            <th>Berkas Proposal</th>
                            <th>Departemen</th>
                            <th>Gelombang</th>
                            <th>Jadwal</th>
                            <th>Penguji</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div class="form-group">
                            <label>Gelombang</label>
                            <?php echo form_open('dashboardd/proposal/kps_proposal/gelombang')?>
                            <select name="id_gelombang" class="form-control select2" style="width: 100%;" required>
                               <option value="<?php echo $gelombang_berjalan->id_gelombang?>"><?php echo $gelombang_berjalan->gelombang.' '.$gelombang_berjalan->semester?></option>
                                <?php 
                                foreach($gelombang as $list){
                                ?>
                                 <option value="<?php echo $list['id_gelombang']?>"><?php echo $list['gelombang'].' '.$list['semester']?></option>
                                <?php
                                }
                                ?>
                            </select>  
                            
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Pilih</button>
                            <?php echo form_close()?>   
                        </div>
                        <?php 
                        $no = 1;
                        foreach($proposal as $list){
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?=$list['nama']?><br><strong><?=$list['nim']?></strong></td>
                            <td><?php 
                            $judul = $this->proposal->read_judul($list['id_skripsi']);
                            echo $judul->judul;
                            ?></td>                            
                            <td>
                                <a href="<?php echo base_url()?>assets/upload/proposal/<?php echo $list['berkas_proposal']?>" target="_blank"><img src="<?php echo base_url()?>assets/img/pdf.png" width="20px" height="auto"></a>
                            </td>
                            <td><?php echo $list['departemen']?></td>
                            <td><?=$list['gelombang'].' ('.$list['semester'].')'?></td>
                            <td>
                            <?php 
                            $ujian = $this->proposal->read_ujian($list['id_skripsi']);
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
                            $penguji = $this->proposal->read_penguji($list['id_skripsi']);
                            $num = 1;
                            foreach($penguji as $show)
                            {
                                if($show['status'] == '1')
                                {
                                ?>
                                <p style="color:red">
                                <?php
                                echo $num.'. '.$show['nama'].'<br>';    
                                ?>
                                </p>
                                <?php
                                }
                                else
                                {
                                echo $num.'. '.$show['nama'].'<br>';    
                                }
                                $num++;
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
    </div>
    <!-- /.col -->
</div>