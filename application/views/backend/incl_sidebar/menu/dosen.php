<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li><a href="<?php echo base_url() ?>dashboardd"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
    <?php
    $struktural = $this->struktural->read_struktural($this->session_data['username']);
    if ($struktural) {
        if ($struktural->id_struktur == STRUKTUR_WADEK_1) {//WADEK 1
            ?>
            <li class="header">FITUR WADEK 1</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file"></i> <span>Skripsi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file-o"></i> <span>Tesis</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Disertasi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                </ul>
            </li>
            <?php
        } else if ($struktural->id_struktur == STRUKTUR_KETUA_BAGIAN) {//KETUA BAGIAN
            ?>
            <li class="header">FITUR KADEP</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Monitoring</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a target="_blank" href="<?php echo base_url() ?>dashboard/jadwal_kalender"><i class="fa fa-user"></i>Jadwal</a></li>
                    <li><a href="<?php echo base_url() ?>dashboardd/monitoring/pembimbing"><i class="fa fa-user"></i>Pembimbing</a></li>

                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file"></i> <span>Skripsi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
					<li><a href="<?php echo base_url() ?>dosen/sarjana/kadep/proposal/pengajuan"><i class="fa fa-user"></i>Proposal</a></li>
                    <li><a href="<?php echo base_url() ?>dashboardd/skripsi/kadep_blm_skripsi"><i class="fa fa-user"></i>Skripsi</a></li>
                </ul>
            </li>
            <!-- <li class="treeview">
                <a href="#">
                    <i class="fa fa-file-o"></i> <span>Tesis</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php //echo base_url() ?>dosen/tesis/judul/index_kabag"><i class="fa fa-chevron-circle-right"></i> Judul</a></li>
                    <li><a href="<?php //echo base_url() ?>dosen/tesis/proposal/index_kabag"><i class="fa fa-chevron-circle-right"></i> Proposal</a></li>
                    <li><a href="<?php //echo base_url() ?>dosen/tesis/mkpt/index_kabag"><i class="fa fa-chevron-circle-right"></i> MKPT</a></li>
                    <li><a href="<?php //echo base_url() ?>dosen/tesis/ujian/index_kabag"><i class="fa fa-chevron-circle-right"></i> Tesis</a></li>
                </ul>
            </li> -->
            <?php
        } else if ($struktural->id_struktur == STRUKTUR_SPS) {//SPS
            ?>
            <li class="header">FITUR SPS</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file-o"></i> <span>Tesis</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url() ?>dosen/tesis/judul"><i class="fa fa-chevron-circle-right"></i> Judul</a></li>
                    <!-- <li><a href="<?php //echo base_url() ?>dosen/tesis/proposal"><i class="fa fa-chevron-circle-right"></i> Proposal</a></li>
                    <li><a href="<?php //echo base_url() ?>dosen/tesis/mkpt"><i class="fa fa-chevron-circle-right"></i> MKPT</a></li>
                    <li><a href="<?php //echo base_url() ?>dosen/tesis/ujian"><i class="fa fa-chevron-circle-right"></i> Tesis</a></li> -->
                </ul>
                <!--
                <ul class="treeview-menu">
                    <li><a href="<?php //echo base_url() ?>dashboardd/proposal_tesis/pengajuan"><i class="fa fa-book"></i>Proposal Pengajuan</a></li>

                </ul>
                -->
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Disertasi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/kualifikasi"><i class="fa fa-chevron-circle-right"></i> Persetujuan</a></li>
                </ul>
            </li>
            <?php
        } else if ($struktural->id_struktur == '6') {//KPS S1
            ?>
            <li class="header">FITUR KPS S1</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-line-chart"></i> <span>Laporan</span>
					<span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url() ?>laporan/dosen/skripsi"><i class="fa fa-chevron-circle-right"></i>Dosen</a></li>
					<li><a href="<?php echo base_url() ?>laporan/mahasiswa/skripsi"><i class="fa fa-chevron-circle-right"></i>Mahasiswa</a></li>

				</ul>
			</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file"></i> <span>Skripsi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url() ?>dashboardd/proposal/kps_proposal"><i class="fa fa-chevron-circle-right"></i>Proposal</a></li>
                    <li><a href="<?php echo base_url() ?>dashboardd/skripsi/kps_skripsi"><i class="fa fa-chevron-circle-right"></i>Skripsi</a></li>
                </ul>
            </li>
            <?php
        } else if ($struktural->id_struktur == STRUKTUR_KPS_S2) {//KPS S2
            ?>
            <li class="header">FITUR KPS S2</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-line-chart"></i> <span>Laporan</span>
					<span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url() ?>laporan/dosen/tesis"><i class="fa fa-chevron-circle-right"></i>Dosen</a></li>
					<li><a href="<?php echo base_url() ?>laporan/mahasiswa/tesis"><i class="fa fa-chevron-circle-right"></i>Mahasiswa</a></li>

				</ul>
			</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file-o"></i> <span>Tesis</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <!--
                    <li><a href="<?php //echo base_url() ?>dashboardd/proposal_tesis/penjadwalan"><i class="fa fa-user"></i>Set Jadwal Proposal</a></li>
                    -->
                    <li><a href="<?php echo base_url() ?>dosen/tesis/judul/index_kps"><i class="fa fa-chevron-circle-right"></i> Judul</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/tesis/proposal/penjadwalan"><i class="fa fa-chevron-circle-right"></i>Proposal</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/tesis/ujian/penjadwalan"><i class="fa fa-chevron-circle-right"></i>Tesis</a></li>
                </ul>
            </li>
            <?php
        } else if ($struktural->id_struktur == STRUKTUR_KPS_S3) {//KPS S3
            ?>
            <li class="header">FITUR KPS S3</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-line-chart"></i> <span>Laporan</span>
					<span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url() ?>laporan/dosen/disertasi"><i class="fa fa-chevron-circle-right"></i>Dosen</a></li>
					<li><a href="<?php echo base_url() ?>laporan/mahasiswa/disertasi"><i class="fa fa-chevron-circle-right"></i>Mahasiswa</a></li>

				</ul>
			</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Disertasi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/kualifikasi"><i class="fa fa-chevron-circle-right"></i> Persetujuan</a></li>
                </ul>
            </li>
            <?php
        }
    }
    ?>
    <li class="header">AKTIVITAS</li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-file"></i> <span>Skripsi</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
			<li><a href="<?php echo base_url() ?>dashboardd/skripsi/pembimbing_approve"><i class="fa fa-chevron-circle-right"></i> Pembimbing</a></li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-chevron-circle-right"></i> <span>Penguji</span>
					<span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url() ?>dosen/sarjana/proposal/penguji_pengajuan"><i class="fa fa-chevron-circle-right"></i> Proposal</a></li>
					<li><a href="<?php echo base_url() ?>dosen/sarjana/skripsi/penguji_pengajuan"><i class="fa fa-chevron-circle-right"></i> Skripsi</a></li>
				</ul>
			</li>

        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-file-o"></i> <span>Tesis</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <!--<li><a href="<?php //echo base_url() ?>dashboardd/proposal_tesis/penguji"><i class="fa fa-chevron-circle-right"></i> Penguji Proposal</a></li>-->
            <!-- <li><a href="<?php //echo base_url() ?>dashboardd/proposal_tesis/pembimbing"><i class="fa fa-chevron-circle-right"></i> Pembimbing</a></li> -->
            <li><a href="<?php echo base_url() ?>dosen/tesis/permintaan/pembimbing"><i class="fa fa-chevron-circle-right"></i> Pembimbing</a></li>
            <!--
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file-o"></i> <span>Pembimbing</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php //echo base_url() ?>dosen/tesis/permintaan/pembimbing"><i class="fa fa-chevron-circle-right"></i> Pembimbing Proposal</a></li>
                    <li><a href="<?php //echo base_url() ?>dosen/tesis/ujian/pembimbing"><i class="fa fa-chevron-circle-right"></i> Pembimbing Tesis</a></li>
                </ul>
            </li>
            -->
            <li><a href="<?php echo base_url() ?>dosen/tesis/mkpt/pengampu"><i class="fa fa-chevron-circle-right"></i> Pengampu MKPT</a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-chevron-circle-right"></i> <span>Penguji</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url() ?>dosen/tesis/proposal/penguji"><i class="fa fa-chevron-circle-right"></i> Penguji Proposal</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/tesis/ujian/penguji"><i class="fa fa-chevron-circle-right"></i> Penguji Tesis</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-book"></i> <span>Disertasi</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url() ?>dosen/disertasi/permintaan/penasehat"><i class="fa fa-chevron-circle-right"></i>Penasehat Akademik</a></li>
            <li><a href="<?php echo base_url() ?>dosen/disertasi/permintaan/penguji"><i class="fa fa-chevron-circle-right"></i>Penguji</a></li>
            <li><a href="<?php echo base_url() ?>dosen/disertasi/permintaan/promotor"><i class="fa fa-chevron-circle-right"></i>Promotor/Ko-Promotor</a></li>
			<li><a href="<?php echo base_url() ?>dosen/disertasi/penilaian"><i class="fa fa-chevron-circle-right"></i>Penilaian MK</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-file-pdf-o"></i> <span>Dokumen</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url() ?>dosen/dokumen/berita_acara"><i class="fa fa-chevron-circle-right"></i>Berita Acara</a></li>
<!--            <li><a href="--><?php //echo base_url() ?><!--dosen/dokumen/undangan"><i class="fa fa-chevron-circle-right"></i>Undangan</a></li>-->
<!--            <li><a href="#"><i class="fa fa-chevron-circle-right"></i>Surat Tugas</a></li>-->
        </ul>
    </li>
</ul>
