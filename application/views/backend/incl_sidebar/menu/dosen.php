<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="treeview">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span>Home</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url() ?>dashboardd"><i class="fa fa-circle-o"></i> Dashboard</a></li>
        </ul>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span>Proposal Skripsi</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <?php
            $struktural = $this->struktural->read_struktural($this->session_data['username']);
            //print_r($struktural);die();
            if ($struktural) {
                if ($struktural->id_struktur == '5') {//KADEP
                    ?>
                    <li><a href="<?php echo base_url() ?>dashboardd/proposal/kadep_pengajuan"><i class="fa fa-user"></i>(Kadep) Pengajuan</a></li>
                    <li><a href="<?php echo base_url() ?>dashboardd/proposal/kadep_diterima"><i class="fa fa-user"></i>(Kadep) Diterima</a></li>
                    <li><a href="<?php echo base_url() ?>dashboardd/proposal/kadep_selesai"><i class="fa fa-user"></i>(Kadep) Selesai</a></li>
                    <li><a href="<?php echo base_url() ?>dashboardd/proposal/kadep_ditolak"><i class="fa fa-user"></i>(Kadep) Ditolak</a></li>
                    <?php
                } else
                if ($struktural->id_struktur == '6') {//KPS
                    ?>
                    <li><a href="<?php echo base_url() ?>dashboardd/proposal/kps_proposal"><i class="fa fa-user"></i>(KPS) Data Proposal</a></li>
                    <?php
                } else
                if ($struktural->id_struktur == '2') {//Wadek 1
                }
            } else {
                ?>

                <?php
            }
            ?>
            <li><a href="<?php echo base_url() ?>dashboardd/proposal/penguji_pengajuan"><i class="fa fa-circle-o"></i> Pengajuan Penguji</a></li>
            <li><a href="<?php echo base_url() ?>dashboardd/proposal/penguji_approve"><i class="fa fa-circle-o"></i> Penguji</a></li>
        </ul>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span>Skripsi</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <?php
            $struktural = $this->struktural->read_struktural($this->session_data['username']);
//print_r($struktural);die();
            if ($struktural) {
                if ($struktural->id_struktur == '5') {//KADEP
                    ?>
                    <li><a href="<?php echo base_url() ?>dashboardd/skripsi/kadep_blm_skripsi"><i class="fa fa-user"></i>(Kadep) Data Approval Skripsi</a></li>
                    <li><a href="<?php echo base_url() ?>dashboardd/skripsi/kadep_skripsi"><i class="fa fa-user"></i>(Kadep) Data Skripsi</a></li>
                    <?php
                } else
                if ($struktural->id_struktur == '6') {//KPS
                    ?>
                    <li><a href="<?php echo base_url() ?>dashboardd/skripsi/kps_skripsi"><i class="fa fa-user"></i>(KPS) Skripsi</a></li>
                   <!-- <li><a href="<?php echo base_url() ?>dashboardd/skripsi/kps_skripsi_data"><i class="fa fa-user"></i>Data Skripsi</a></li>-->
                    <?php
                } else
                if ($struktural->id_struktur == '2') {//Wadek 1
                }
            } else {
                ?>

                <?php
            }
            ?>
<!--<li><a href="<?php echo base_url() ?>dashboardd/skripsi/pembimbing_pengajuan"><i class="fa fa-circle-o"></i> Pengajuan Pembimbing</a></li>
            --><li><a href="<?php echo base_url() ?>dashboardd/skripsi/pembimbing_approve"><i class="fa fa-circle-o"></i> Bimbingan</a></li>
            <li><a href="<?php echo base_url() ?>dashboardd/skripsi/penguji_pengajuan"><i class="fa fa-circle-o"></i> Pengajuan Penguji</a></li>
            <li><a href="<?php echo base_url() ?>dashboardd/skripsi/penguji_approve"><i class="fa fa-circle-o"></i> Penguji</a></li>
        </ul>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span>Proposal Tesis</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <?php
            $struktural = $this->struktural->read_struktural($this->session_data['username']);
//print_r($struktural);die();
            if ($struktural) {
                if ($struktural->id_struktur == '7') {//SPS
                    ?>
                    <li><a href="<?php echo base_url() ?>dashboardd/proposal_tesis/pengajuan"><i class="fa fa-book"></i>Tesis</a></li>
                    <?php
                } else
                if ($struktural->id_struktur == '8') {//KPS S2
                    ?>
                    <li><a href="<?php echo base_url() ?>dashboardd/proposal_tesis/penjadwalan"><i class="fa fa-user"></i>Set Jadwal Proposal</a></li>
                    <?php
                } else
                if ($struktural->id_struktur == '2') {//Wadek 1
                }
            } else {
                ?>

                <?php
            }
            ?>
            <li><a href="<?php echo base_url() ?>dashboardd/proposal_tesis/penguji"><i class="fa fa-circle-o"></i> Penguji </a></li>
            <li><a href="<?php echo base_url() ?>dashboardd/proposal_tesis/pembimbing"><i class="fa fa-circle-o"></i> Pembimbing</a></li>
        </ul>
    </li>


    <?php
    $struktural = $this->struktural->read_struktural($this->session_data['username']);
//print_r($struktural);die();
    if ($struktural) {
        if ($struktural->id_struktur == '5') {//KADEP
            ?>
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
            <?php
        }
    }
    ?>

    <?php
    $struktural = $this->struktural->read_struktural($this->session_data['username']);
    if ($struktural) {
        if ($struktural->id_struktur == '9') {//KPS S3
            ?>
            <li class="header">KPS</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Disertasi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/kualifikasi"><i class="fa fa-circle-o"></i>Kualifikasi</a></li>
                    <li><a href="<?php echo base_url() ?>dashboardd/monitoring/jadwal"><i class="fa fa-circle-o"></i>MPKK</a></li>
                    <li><a href="<?php echo base_url() ?>dashboardd/monitoring/jadwal"><i class="fa fa-circle-o"></i>Proposal</a></li>
                    <li><a href="<?php echo base_url() ?>dashboardd/monitoring/jadwal"><i class="fa fa-circle-o"></i>MPKD</a></li>
                    <li><a href="<?php echo base_url() ?>dashboardd/monitoring/jadwal"><i class="fa fa-circle-o"></i>Kelayakan</a></li>
                    <li><a href="<?php echo base_url() ?>dashboardd/monitoring/jadwal"><i class="fa fa-circle-o"></i>Ujian</a></li>

                </ul>
            </li>
            <li class="header">PERMINTAAN</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Disertasi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url() ?>dosen/disertasi/kualifikasi/penguji"><i class="fa fa-circle-o"></i>Penguji</a></li>

                </ul>
            </li>
            <?php
        }
    } else {
        ?>
        <li class="header">PERMINTAAN</li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-book"></i> <span>Disertasi</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?php echo base_url() ?>dosen/disertasi/kualifikasi/penguji"><i class="fa fa-circle-o"></i>Penguji</a></li>

            </ul>
        </li>
        <?php
    }
    ?>
</ul>