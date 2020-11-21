<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Biodata</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <td>Nama</td>
                        <td style="width: 10px">:</th>
                        <td><?php echo $biodata->nama ?></th>
                    </tr>
                    <tr>
                        <td>NIM</td>
                        <td style="width: 10px">:</th>
                        <td><?php echo $biodata->nim ?></th>
                    </tr>
                    <?php if ($biodata->id_jenjang != NULL) { ?>
                        <tr>
                            <td>Program Studi</td>
                            <td style="width: 10px">:</th>
                            <td><?php echo $biodata->nm_jenjang . " " . $biodata->nm_prodi ?></th>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td>Alamat</td>
                        <td style="width: 10px">:</th>
                        <td><?php echo $biodata->alamat ?></th>
                    </tr>
                    <tr>
                        <td>Telp</td>
                        <td style="width: 10px">:</th>
                        <td><?php echo $biodata->telp ?></th>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td style="width: 10px">:</th>
                        <td><?php echo $biodata->email ?></th>
                    </tr>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>


<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Pengumuman</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pengumuman</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($berita as $list) {
                            ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $list['isi_berita'] ?></td>
                                <td><?= $list['tanggal_berita'] ?></td>                                 
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

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Alur Pengajuan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <ul class="timeline">
                    <!-- timeline time label -->
                    <li class="time-label">
                        <span class="bg-navy">
                            <i class="fa fa-circle-o"></i> MULAI
                        </span>
                    </li>
                    <!-- /.timeline-label -->
                    <li class="time-label">
                        <span class="bg-aqua">
                            PROPOSAL
                        </span>
                    </li>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    <li>
                        <i class="fa fa-arrow-down"></i>

                        <div class="timeline-item">

                            <h3 class="timeline-header"><a href="#">Proses 1</a> melakukan apa saja</h3>

                            <div class="timeline-body">
                                Harap Mengisi apa saja yang perlu dilakukan apa saja
                            </div>
                        </div>
                    </li>
                    <!-- END timeline item -->
                    <!-- timeline item -->
                    <li>
                        <i class="fa fa-arrow-down"></i>

                        <div class="timeline-item">

                            <h3 class="timeline-header"><a href="#">Proses 1</a> melakukan apa saja</h3>

                            <div class="timeline-body">
                                Harap Mengisi apa saja yang perlu dilakukan apa saja
                            </div>
                        </div>
                    </li>
                    <!-- END timeline item -->
                    <!-- timeline item -->
                    <li>
                        <i class="fa fa-arrow-down"></i>

                        <div class="timeline-item">

                            <h3 class="timeline-header"><a href="#">Proses 1</a> melakukan apa saja</h3>

                            <div class="timeline-body">
                                Harap Mengisi apa saja yang perlu dilakukan apa saja
                            </div>
                        </div>
                    </li>
                    <!-- END timeline item -->
                    <!-- timeline item -->
                    <li>
                        <i class="fa fa-arrow-down"></i>

                        <div class="timeline-item">

                            <h3 class="timeline-header"><a href="#">Proses 1</a> melakukan apa saja</h3>

                            <div class="timeline-body">
                                Harap Mengisi apa saja yang perlu dilakukan apa saja
                            </div>
                        </div>
                    </li>
                    <!-- END timeline item -->
                    <!-- timeline time label -->
                    <li class="time-label">
                        <span class="bg-blue-active">
                            SKRIPSI
                        </span>
                    </li>
                    <!-- /.timeline-label -->
                    <!-- timeline item -->
                    <li>
                        <i class="fa fa-arrow-down"></i>

                        <div class="timeline-item">

                            <h3 class="timeline-header"><a href="#">Proses 1</a> melakukan apa saja</h3>

                            <div class="timeline-body">
                                Harap Mengisi apa saja yang perlu dilakukan apa saja
                            </div>
                        </div>
                    </li>
                    <!-- END timeline item -->
                    <!-- timeline item -->
                    <li>
                        <i class="fa fa-arrow-down"></i>

                        <div class="timeline-item">

                            <h3 class="timeline-header"><a href="#">Proses 1</a> melakukan apa saja</h3>

                            <div class="timeline-body">
                                Harap Mengisi apa saja yang perlu dilakukan apa saja
                            </div>
                        </div>
                    </li>
                    <!-- END timeline item -->

                    <!-- timeline time label -->
                    <li class="time-label">
                        <span class="bg-green-active">
                            <i class="fa fa-check"></i> SELESAI
                        </span>
                    </li>
                    <!-- /.timeline-label -->
                </ul>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>