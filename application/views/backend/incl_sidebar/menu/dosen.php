<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li><a href="<?php echo base_url() ?>dashboardd"><i class="fa fa-dashboard"></i> Dashboard</a></li>

    <?php
    $struktural = $this->struktural->read_struktural($this->session_data['username']);
    if ($struktural) {
        if ($struktural->id_struktur == '2') {//WADEK 1
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
        } else if ($struktural->id_struktur == '5') {//KADEP
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
                    <li><a href="<?php echo base_url() ?>dashboardd/proposal/kadep_pengajuan"><i class="fa fa-user"></i>Proposal Pengajuan</a></li>
                    <li><a href="<?php echo base_url() ?>dashboardd/proposal/kadep_diterima"><i class="fa fa-user"></i>Proposal Diterima</a></li>
                    <li><a href="<?php echo base_url() ?>dashboardd/proposal/kadep_selesai"><i class="fa fa-user"></i>Proposal Selesai</a></li>
                    <li><a href="<?php echo base_url() ?>dashboardd/proposal/kadep_ditolak"><i class="fa fa-user"></i>Proposal Ditolak</a></li>
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
        } else if ($struktural->id_struktur == '7') {//WADEK 1
            ?>
            <li class="header">FITUR SPS</li>
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
                    <li><a href="<?php echo base_url() ?>dashboardd/proposal_tesis/pengajuan"><i class="fa fa-book"></i>Proposal Pengajuan</a></li>

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
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/kualifikasi"><i class="fa fa-circle-o"></i>Kualifikasi</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/mpkk"><i class="fa fa-circle-o"></i>MKPKK</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/proposal"><i class="fa fa-circle-o"></i>Proposal</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/mkpd"><i class="fa fa-circle-o"></i>MPKD</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/kelauakan"><i class="fa fa-circle-o"></i>Kelayakan</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/tertutup"><i class="fa fa-circle-o"></i>Ujian Tertutup</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/terbuka"><i class="fa fa-circle-o"></i>Ujian Terbuka</a></li>
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
        } else if ($struktural->id_struktur == '8') {//KPS S2
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
                    <li><a href="<?php echo base_url() ?>dashboardd/proposal_tesis/penjadwalan"><i class="fa fa-user"></i>Set Jadwal Proposal</a></li>
                </ul>
            </li>
            <?php
        } else if ($struktural->id_struktur == '9') {//KPS S3
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
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/kualifikasi"><i class="fa fa-circle-o"></i>Kualifikasi</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/mpkk"><i class="fa fa-circle-o"></i>MKPKK</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/proposal"><i class="fa fa-circle-o"></i>Proposal</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/mkpd"><i class="fa fa-circle-o"></i>MPKD</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/kelauakan"><i class="fa fa-circle-o"></i>Kelayakan</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/tertutup"><i class="fa fa-circle-o"></i>Ujian Tertutup</a></li>
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/terbuka"><i class="fa fa-circle-o"></i>Ujian Terbuka</a></li>
                </ul>
            </li>
            <?php
        }
    }
    ?>
    <li class="header">PERMINTAAN</li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-file"></i> <span>Skripsi</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url() ?>dashboardd/proposal/penguji_pengajuan"><i class="fa fa-circle-o"></i> Pengajuan Penguji Proposal</a></li>
            <li><a href="<?php echo base_url() ?>dashboardd/proposal/penguji_approve"><i class="fa fa-circle-o"></i> Penguji Proposal</a></li>
            <li><a href="<?php echo base_url() ?>dashboardd/skripsi/pembimbing_approve"><i class="fa fa-circle-o"></i> Bimbingan</a></li>
            <li><a href="<?php echo base_url() ?>dashboardd/skripsi/penguji_pengajuan"><i class="fa fa-circle-o"></i> Pengajuan Penguji Skripsi</a></li>
            <li><a href="<?php echo base_url() ?>dashboardd/skripsi/penguji_approve"><i class="fa fa-circle-o"></i> Penguji Skripsi</a></li>

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
            <li><a href="<?php echo base_url() ?>dashboardd/proposal_tesis/penguji"><i class="fa fa-circle-o"></i> Penguji Proposal</a></li>
            <li><a href="<?php echo base_url() ?>dashboardd/proposal_tesis/pembimbing"><i class="fa fa-circle-o"></i> Pembimbing</a></li>

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
            <li><a href="<?php echo base_url() ?>dosen/disertasi/permintaan/penguji"><i class="fa fa-circle-o"></i>Penguji</a></li>
            <li><a href="<?php echo base_url() ?>dosen/disertasi/permintaan/promotor"><i class="fa fa-circle-o"></i>Promotor/Ko-Promotor</a></li>
        </ul>
    </li>
    <?php ?>
</ul>