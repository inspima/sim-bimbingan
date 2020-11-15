<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $subtitle?></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <?php echo form_open_multipart('dashboardm/magister/proposal_tesis/save');?>
            <div class="box-body">
                <!--<div class="form-group">
                    <label>Departemen</label>-->
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_gelombang', $gelombang->id_gelombang, 'required') ?>
                    <!--<select name="id_departemen" class="form-control select2" style="width: 100%;" required>
                        <option value="">Pilih</option>
                        <?php 
                        foreach($departemen as $list){
                        ?>
                        <option value="<?php echo $list['id_departemen']?>"><?php echo $list['departemen']?></option>
                        <?php
                        }
                     
                     
                        ?>
                    </select>-->
                </div>
                <input type="hidden" value="1" name="id_departemen">
                <div class="form-group">
                    <label>Judul Proposal</label>
                    <textarea class="form-control" name="judul" required></textarea>
                </div>
                <p>
                 &nbsp;
                </p>
                <div class="form-group">
                    <label>Upload BAB 1 (format file .pdf maks 10mb)</label>
                    <input type="file" name="berkas_proposal" class="form-control" required>
                </div>
            
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn btn-sm btn-warning" href="<?= base_url()?>dashboardm/magister/proposal_tesis"><i class="fa fa-close"></i> Batal</a>
            </div>
        <?=form_close()?>
        </div>
        <!-- /.box -->
    </div>
</div>