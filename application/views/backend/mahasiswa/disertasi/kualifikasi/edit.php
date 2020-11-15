<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $subtitle?></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <?php echo form_open('dashboardm/modul/proposal/update');?>
            <div class="box-body">
                <div class="form-group">
                    <label>Departemen</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_skripsi', $proposal->id_skripsi, 'required') ?>
                    <select name="id_departemen" class="form-control select2" style="width: 100%;" required>
                        <option value="<?php echo $proposal->id_departemen?>"><?php echo $proposal->departemen?></option>
                        <?php 
                        foreach($departemen as $list){
                        ?>
                        <option value="<?php echo $list['id_departemen']?>"><?php echo $list['departemen']?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Judul</label>
                    <?php $judul = $this->proposal->read_judul($proposal->id_skripsi);?>
                    <textarea class="form-control" name="judul" required><?php echo $judul->judul?></textarea>
                </div>
            
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn btn-sm btn-warning" href="<?= base_url()?>dashboardm/modul/proposal"><i class="fa fa-close"></i> Batal</a>
            </div>
        <?=form_close()?>
        </div>
        <!-- /.box -->
    </div>
</div>

<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Update File</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <?php echo form_open_multipart('dashboardm/modul/proposal/update_file');?>
            <div class="box-body">
                <div class="form-group">
                    <label>Ubah File BAB 1 (format file .pdf maks 2mb)</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_skripsi', $proposal->id_skripsi, 'required') ?>
                    <input type="file" name="berkas_proposal" class="form-control" required>
                </div>            
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-upload"></i> Upload</button>
            </div>
        <?=form_close()?>
        </div>
        <!-- /.box -->
    </div>
</div>