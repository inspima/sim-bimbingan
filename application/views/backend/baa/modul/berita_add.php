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
        <?php echo form_open('dashboardb/modul/berita/save');?>
            <div class="box-body">
                <div class="form-group">
                    <label>Berita</label>
                    <?php echo formtext('hidden', 'hand', 'center19', 'required') ?>
                    <textarea name="isi_berita" class="form-control" rows="3" placeholder=""></textarea>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="id_kategori[]" class="form-control select2" multiple="multiple" data-placeholder="Select a State"
                        style="width: 100%;">
                        <?php foreach($kategori as $list){?>
                        <option value="<?php echo $list['id_kategori']?>"><?php echo $list['kategori']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
                <a class="btn btn-sm btn-warning" href="<?= base_url()?>dashboardb/modul/berita"><i class="fa fa-close"></i> Batal</a>
            </div>
        <?=form_close()?>
        </div>
        <!-- /.box -->
    </div>
</div>