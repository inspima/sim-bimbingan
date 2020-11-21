<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="treeview">
        <a href="#">
            <i class="fa fa-group"></i> <span>Registrasi</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url() ?>baa/modul/registrasi"><i class="fa fa-circle-o"></i> Verifikasi</a></li>

        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-list-alt"></i> <span>Master</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url() ?>dashboardb/master/semester"><i class="fa fa-circle-o"></i> Semester</a></li>
            <li><a href="<?php echo base_url() ?>dashboardb/master/gelombang"><i class="fa fa-circle-o"></i> Gelombang</a></li>
            <li><a href="<?php echo base_url() ?>dashboardb/master/dosen"><i class="fa fa-circle-o"></i> Dosen</a></li>
            <li><a href="<?php echo base_url() ?>dashboardb/master/mahasiswa"><i class="fa fa-circle-o"></i> Mahasiswa</a></li>

        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-th-large"></i> <span>Modul</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url() ?>dashboardb/modul/berita"><i class="fa fa-circle-o"></i> Berita</a></li>

        </ul>
    </li>
    <!--    
    <li class="treeview">
            <a href="#">
                <i class="fa fa-file-o"></i> <span>Proposal</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?php echo base_url() ?>dashboardb/proposal/proposal_pengajuan"><i class="fa fa-circle-o"></i>Proposal (Pengajuan)</a></li>
                <li><a href="<?php echo base_url() ?>dashboardb/proposal/proposal_diterima"><i class="fa fa-circle-o"></i>Proposal (Diterima)</a></li>
                <li><a href="<?php echo base_url() ?>dashboardb/proposal/proposal_selesai"><i class="fa fa-circle-o"></i>Proposal (Selesai)</a></li>
                <li><a href="<?php echo base_url() ?>dashboardb/proposal/proposal_ditolak"><i class="fa fa-circle-o"></i>Proposal (Ditolak)</a></li>
    
                <li><a href="<?php echo base_url() ?>dashboardb/proposal/penguji_pengajuan"><i class="fa fa-circle-o"></i>Penguji (Belum Approve)</a></li>
    
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
                <li><a href="<?php echo base_url() ?>dashboardb/skripsi/skripsi_belum_daftar"><i class="fa fa-circle-o"></i>Skripsi (Belum Daftar)</a></li>
                <li><a href="<?php echo base_url() ?>dashboardb/skripsi/skripsi_pengajuan"><i class="fa fa-circle-o"></i>Skripsi (Pengajuan)</a></li>
                <li><a href="<?php echo base_url() ?>dashboardb/skripsi/skripsi_diterima"><i class="fa fa-circle-o"></i>Skripsi (Diterima)</a></li>
                <li><a href="<?php echo base_url() ?>dashboardb/skripsi/skripsi_ujian"><i class="fa fa-circle-o"></i>Skripsi (Ujian)</a></li>
                <li><a href="<?php echo base_url() ?>dashboardb/skripsi/skripsi_penguji_pengajuan"><i class="fa fa-circle-o"></i>Penguji Skripsi (Belum Approve)</a></li>
    
            </ul>
        </li>
    -->
    <li class="treeview">
        <a href="#">
            <i class="fa fa-file"></i> <span>Sarjana</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url() ?>sarjanah/proposal/index"><i class="fa fa-circle-o"></i>Proposal</a></li>
            <li><a href="<?php echo base_url() ?>sarjanah/skripsi/index"><i class="fa fa-circle-o"></i>Skripsi</a></li>

        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-file-text-o"></i> <span>Magister</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url() ?>dashboardb/thesis/thesis"><i class="fa fa-circle-o"></i>Thesis</a></li>


        </ul>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-book"></i> <span>Doktoral</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url() ?>baa/doktoral/disertasi/kualifikasi"><i class="fa fa-circle-o"></i>Kualifikasi</a></li>
            <li><a href="<?php echo base_url() ?>baa/doktoral/disertasi/proposal"><i class="fa fa-circle-o"></i>Proposal</a></li>
            <li><a href="<?php echo base_url() ?>baa/doktoral/disertasi/kelayakan"><i class="fa fa-circle-o"></i>Kelayakan</a></li>
            <li><a href="<?php echo base_url() ?>baa/doktoral/disertasi/tertutup"><i class="fa fa-circle-o"></i>Ujian Tertutup</a></li>
            <li><a href="<?php echo base_url() ?>baa/doktoral/disertasi/terbuka"><i class="fa fa-circle-o"></i>Ujian Terbuka</a></li>
        </ul>
    </li>
</ul>