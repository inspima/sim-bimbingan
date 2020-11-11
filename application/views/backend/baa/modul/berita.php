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
                    <a class="btn btn-xs btn-primary" href="<?= base_url()?>dashboardb/modul/berita/add">
                    <i class="fa fa-plus"></i> Tambah</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Isi Berita</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach($berita as $list){
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?php echo toindo($list['tanggal_berita'])?></td>
                            <td><?php echo $list['isi_berita']?></td>
                            <td>
                            <?php 
                            $kategori = $this->berita->berita_kategori($list['id_berita']);
                            foreach($kategori as $show){
                                echo $show['kategori'].', ';
                            }
                            ?>
                            </td>
                            <td>
                                <?php 
                                if($list['status'] == '0')
                                {
                                ?>
                                    <?php 
                                    echo form_open('dashboardb/modul/berita/update_status');
                                    echo formtext('hidden', 'hand', 'center19', 'required');
                                    echo formtext('hidden', 'id_berita', $list['id_berita'], 'required');
                                    echo formtext('hidden', 'status', '1', 'required');
                                    ?>
                                    <button type="submit" class="btn btn-xs btn-danger pull-left" style="margin-right:3px;"><i class="fa fa-close"></i> Tidak Aktif</button>
                                    <?php
                                    echo form_close();
                                    ?>
                                <?php
                                }
                                else
                                if($list['status'] == '1')
                                {
                                ?>
                                    <?php 
                                    echo form_open('dashboardb/modul/berita/update_status');
                                    echo formtext('hidden', 'hand', 'center19', 'required');
                                    echo formtext('hidden', 'id_berita', $list['id_berita'], 'required');
                                    echo formtext('hidden', 'status', '0', 'required');
                                    ?>
                                    <button type="submit" class="btn btn-xs btn-success pull-left" style="margin-right:3px;"><i class="fa fa-close"></i> Aktif</button>
                                    <?php
                                    echo form_close();
                                    ?>
                                <?php
                                }
                                ?>
                            </td>
                            <td>                               
                                <a class="btn btn-xs btn-warning pull-left" href="<?= base_url()?>dashboardb/modul/berita/edit/<?= $list['id_berita']?>">
                                <i class="fa fa-edit"></i> Edit</a>
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