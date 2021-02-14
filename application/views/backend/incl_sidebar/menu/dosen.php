<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li><a href="<?php echo base_url() ?>dashboardd"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
	<li class="treeview">
		<a href="#">
			<i class="fa fa-bar-chart"></i> <span>Laporan</span>
			<span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
		</a>
		<ul class="treeview-menu">
			<li><a href=""><i class="fa fa-circle-o"></i>Bimbingan</a></li>
			<li><a href=""><i class="fa fa-circle-o"></i>Penguji</a></li>
		</ul>
	</li>
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
                    <li><a href="<?php echo base_url() ?>dashboardd/monitoring/jadwal"><i class="fa fa-user"></i>Jadwal</a></li>
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
                    <li><a href="<?php echo base_url() ?>dashboardd/skripsi/kadep_blm_skripsi"><i class="fa fa-user"></i>Skripsi Persetujuan</a></li>
                    <li><a href="<?php echo base_url() ?>dashboardd/skripsi/kadep_skripsi"><i class="fa fa-user"></i>Data Skripsi</a></li>
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
                    <li><a href="<?php echo base_url() ?>dosen/tesis/judul/index_kabag"><i class="fa fa-circle-o"></i> Judul</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/tesis/proposal/index_kabag"><i class="fa fa-circle-o"></i> Proposal</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/tesis/mkpt/index_kabag"><i class="fa fa-circle-o"></i> MKPT</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/tesis/ujian/index_kabag"><i class="fa fa-circle-o"></i> Tesis</a></li>
                </ul>
            </li>
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
                    <li><a href="<?php echo base_url() ?>dosen/tesis/judul"><i class="fa fa-circle-o"></i> Judul</a></li>
                    <!-- <li><a href="<?php //echo base_url() ?>dosen/tesis/proposal"><i class="fa fa-circle-o"></i> Proposal</a></li>
                    <li><a href="<?php //echo base_url() ?>dosen/tesis/mkpt"><i class="fa fa-circle-o"></i> MKPT</a></li>
                    <li><a href="<?php //echo base_url() ?>dosen/tesis/ujian"><i class="fa fa-circle-o"></i> Tesis</a></li> -->
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
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/kualifikasi"><i class="fa fa-circle-o"></i> Persetujuan</a></li>
                </ul>
            </li>
            <?php
        } else if ($struktural->id_struktur == '6') {//KPS S1
            ?>
            <li class="header">FITUR KPS S1</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file"></i> <span>Skripsi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url() ?>dashboardd/proposal/kps_proposal"><i class="fa fa-user"></i>Data Proposal</a></li>
                    <li><a href="<?php echo base_url() ?>dashboardd/skripsi/kps_skripsi"><i class="fa fa-user"></i>Data Skripsi</a></li>
                </ul>
            </li>
            <?php
        } else if ($struktural->id_struktur == STRUKTUR_KPS_S2) {//KPS S2
            ?>
            <li class="header">FITUR KPS S2</li>
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
                    <li><a href="<?php echo base_url() ?>dosen/tesis/judul/index_kps"><i class="fa fa-circle-o"></i> Judul</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/tesis/proposal/penjadwalan"><i class="fa fa-user"></i>Proposal</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/tesis/ujian/penjadwalan"><i class="fa fa-user"></i>Tesis</a></li>
                </ul>
            </li>
            <?php
        } else if ($struktural->id_struktur == STRUKTUR_KPS_S3) {//KPS S3
            ?>
            <li class="header">FITUR KPS S3</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Disertasi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/kualifikasi"><i class="fa fa-circle-o"></i> Persetujuan</a></li>
                </ul>
            </li>
            <?php
        }
    }
    ?>
    <li class="header">PERMINTAAN & PERSETUJUAN</li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-file"></i> <span>Skripsi</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
			<li><a href="<?php echo base_url() ?>dosen/sarjana/proposal/penguji_pengajuan"><i class="fa fa-circle-o"></i> Penguji Proposal</a></li>
			<li><a href="<?php echo base_url() ?>dashboardd/skripsi/pembimbing_approve"><i class="fa fa-circle-o"></i> Pembimbing</a></li>
			<li><a href="<?php echo base_url() ?>dosen/sarjana/skripsi/penguji_pengajuan"><i class="fa fa-circle-o"></i> Penguji Skripsi</a></li>
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
            <!--<li><a href="<?php //echo base_url() ?>dashboardd/proposal_tesis/penguji"><i class="fa fa-circle-o"></i> Penguji Proposal</a></li>-->
            <!-- <li><a href="<?php //echo base_url() ?>dashboardd/proposal_tesis/pembimbing"><i class="fa fa-circle-o"></i> Pembimbing</a></li> -->
            <li><a href="<?php echo base_url() ?>dosen/tesis/permintaan/pembimbing"><i class="fa fa-circle-o"></i> Pembimbing</a></li>
            <!--
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file-o"></i> <span>Pembimbing</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php //echo base_url() ?>dosen/tesis/permintaan/pembimbing"><i class="fa fa-circle-o"></i> Pembimbing Proposal</a></li>
                    <li><a href="<?php //echo base_url() ?>dosen/tesis/ujian/pembimbing"><i class="fa fa-circle-o"></i> Pembimbing Tesis</a></li>
                </ul>
            </li>
            -->
            <li><a href="<?php echo base_url() ?>dosen/tesis/mkpt/pengampu"><i class="fa fa-circle-o"></i> Pengampu MKPT</a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file-o"></i> <span>Penguji</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url() ?>dosen/tesis/proposal/penguji"><i class="fa fa-circle-o"></i> Penguji Proposal</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/tesis/ujian/penguji"><i class="fa fa-circle-o"></i> Penguji Tesis</a></li>
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
            <li><a href="<?php echo base_url() ?>dosen/disertasi/permintaan/penasehat"><i class="fa fa-circle-o"></i>Penasehat Akademik</a></li>
            <li><a href="<?php echo base_url() ?>dosen/disertasi/permintaan/penguji"><i class="fa fa-circle-o"></i>Penguji</a></li>
            <li><a href="<?php echo base_url() ?>dosen/disertasi/permintaan/promotor"><i class="fa fa-circle-o"></i>Promotor/Ko-Promotor</a></li>
        </ul>
    </li>
	<li class="treeview">
		<a href="#">
			<i class="fa fa-pencil"></i> <span>Penilaian</span>
			<span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
		</a>
		<ul class="treeview-menu">
			<li><a href="<?php echo base_url() ?>dosen/disertasi/penilaian"><i class="fa fa-circle-o"></i>MK Doktoral</a></li>
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
            <li><a href="<?php echo base_url() ?>dosen/dokumen/berita_acara"><i class="fa fa-circle-o"></i>Berita Acara</a></li>
            <li><a href="<?php echo base_url() ?>dosen/dokumen/undangan"><i class="fa fa-circle-o"></i>Undangan</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Surat Tugas</a></li>
        </ul>
    </li>
</ul>
