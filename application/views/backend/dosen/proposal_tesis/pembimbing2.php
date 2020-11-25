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
    <!-- left column -->
    <div class="col-md-4">
        <!-- general form elements -->
        <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $subtitle?></h3>
            <div class="pull-right">
                <a class="btn btn-xs btn-warning" href="<?= base_url()?>dashboardd/proposal_tesis/pembimbing"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <label>NIM</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_skripsi', $proposal->id_skripsi, 'required') ?>
                    <input type="text" name="nim" class="form-control" value="<?php echo $proposal->nim?>" readonly>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?php echo $proposal->nama?>" readonly>
                </div>
                <div class="form-group">
                    <label>Judul</label>
                    <?php 
                            $judul = $this->pembimbing->read_judul($proposal->id_skripsi);
                            ?>
                    <textarea class="form-control" name="judul" readonly><?php echo $judul->judul?></textarea>
                </div>
                <div class="form-group">
                    <label>Berkas Proposal</label>
                    <p><a href="<?php echo base_url()?>assets/upload/proposal/<?php echo $proposal->berkas_proposal?>" target="_blank"><img src="<?php echo base_url()?>assets/img/pdf.png" width="50px" height="auto"></a></p>
                </div>
                
                
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    
    <!--left column -->

<div class="col-md-8">
        <!-- general form elements -->
        <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Usulan Dosen Pembimbing Anggota</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <?php echo form_open('dashboardd/proposal_tesis/penjadwalan/pembimbing_save');?>
            <div class="box-body table-responsive">
                <div class="form-group">
                    <label>Usulan pembimbing </label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_skripsi', $proposal->id_skripsi, 'required') ?>
                    <select name="nip" class="form-control select2" style="width: 100%;" required>
                        <option value="">- Pilih -</option>
                        <?php 
                        foreach($mdosen as $list){
                        ?>
                        <option value="<?php echo $list['nip']?>"><?php echo $list['nama']?></option>
                        <?php
                        }
                        ?>
                    </select>     
                </div>
                <div class="form-group">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama</th>
                        <th>Opsi</th>
                    </tr>
                    <?php
                    $pembimbing = $this->pembimbing->read_pembimbing($proposal->id_skripsi);
                    foreach($pembimbing as $listpembimbing){
                    ?>
                    <tr>
                        <td><?php echo $listpembimbing['nama']?></td>
                        <td>
                        <?php echo form_open('dashboardd/proposal/kadep_diterima/pembimbing_delete')?>
                        <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                        <?php echo formtext('hidden', 'id_skripsi', $proposal->id_skripsi, 'required') ?>
                        <?php //echo formtext('hidden', 'id_ujian', $id_ujian, 'required') ?>
                        <?php echo formtext('hidden', 'id_pembimbing', $listpembimbing['id_pembimbing'], 'required') ?>
                        <?php if($listpembimbing['nip'] != $this->session_data['username']) {?>
                        <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                        <?php } ?>
                        <?php echo form_close()?>
                        </td>
                    </tr>
                    <?php 
                    }
                    ?>
                    </table>
                </div>           
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>    
                
            </div>
        <?php echo form_close()?>
        </div>
        <!-- /.box -->
</div>
        <!-- left column -->
  

</div>


<div class="row">

</div>