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
        <?php echo form_open('dashboardb/master/gelombang/update');?>
            <div class="box-body">
                <div class="form-group">
                    <label>Semester</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <?php echo formtext('hidden', 'id_gelombang', $gelombang->id_gelombang, 'required') ?>
                    <select name="id_semester" class="form-control select2" style="width: 100%;" required>
                        <option value="<?php echo $gelombang->id_semester?>"><?php echo $gelombang->semester?></option>
                        <?php 
                        foreach($semester as $list){
                        ?>
                        <option value="<?php echo $list['id_semester']?>"><?php echo $list['semester']?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Gelombang</label>
                    <?php echo formtext('text', 'gelombang', $gelombang->gelombang, 'required') ?>
                </div>
                <div class="form-group">
                    <label>No SK</label>
                    <?php echo formtext('text', 'no_sk', $gelombang->no_sk, 'required') ?>
                </div>
                <div class="form-group">
                    <label>Tanggal SK</label>
                    <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="tgl_sk" value="<?php echo toindo($gelombang->tgl_sk)?>" class="form-control pull-right" id="datepicker" data-date-format="dd/mm/yyyy">
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn btn-sm btn-warning" href="<?= base_url()?>dashboardb/master/gelombang"><i class="fa fa-close"></i> Batal</a>
            </div>
        <?=form_close()?>
        </div>
        <!-- /.box -->
    </div>
</div>