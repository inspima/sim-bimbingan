<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="treeview">
        <a href="#">
            <i class="fa fa-users"></i> <span>Mahasiswa</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url() ?>baa/utility/registrasi/sarjana"><i class="fa fa-chevron-circle-right"></i> Verifikasi Registrasi</a></li>
            <li><a href="<?php echo base_url() ?>baa/utility/pencarian"><i class="fa fa-chevron-circle-right"></i> Pencarian Mahasiswa</a></li>
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
			<li><a href="<?php echo base_url() ?>baa/master/ruang"><i class="fa fa-chevron-circle-right"></i> Ruang</a></li>
			<li><a href="<?php echo base_url() ?>baa/master/jam"><i class="fa fa-chevron-circle-right"></i> Jam</a></li>
            <li><a href="<?php echo base_url() ?>dashboardb/master/semester"><i class="fa fa-chevron-circle-right"></i> Semester</a></li>
			<li><a href="<?php echo base_url() ?>baa/master/pekan"><i class="fa fa-chevron-circle-right"></i> Pekan</a></li>
            <li><a href="<?php echo base_url() ?>dashboardb/master/gelombang"><i class="fa fa-chevron-circle-right"></i> Gelombang</a></li>
            <li><a href="<?php echo base_url() ?>baa/master/dosen"><i class="fa fa-chevron-circle-right"></i> Dosen</a></li>
            <li><a href="<?php echo base_url() ?>dashboardb/master/mahasiswa"><i class="fa fa-chevron-circle-right"></i> Mahasiswa</a></li>

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
            <li><a href="<?php echo base_url() ?>dashboardb/modul/berita"><i class="fa fa-chevron-circle-right"></i> Berita</a></li>

        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-file"></i> <span>Sarjana</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url() ?>baa/sarjanah/proposal/index"><i class="fa fa-chevron-circle-right"></i>Proposal</a></li>
            <li><a href="<?php echo base_url() ?>baa/sarjanah/skripsi/index"><i class="fa fa-chevron-circle-right"></i>Skripsi</a></li>

        </ul>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-th-list"></i> <span>Report</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url() ?>backend/baa/report/ujian"><i class="fa fa-chevron-circle-right"></i>Report Ujian S1</a></li>
            <li><a href="<?php echo base_url() ?>backend/baa/report/bimbingan"><i class="fa fa-chevron-circle-right"></i>Report Bimbingan S1</a></li>
            <li><a href="<?php echo base_url() ?>backend/baa/report/ujian/master"><i class="fa fa-chevron-circle-right"></i>Report Ujian S2</a></li>
            <li><a href="<?php echo base_url() ?>backend/baa/report/bimbingan/master"><i class="fa fa-chevron-circle-right"></i>Report Bimbingan S2</a></li>
			<li><a href="<?php echo base_url() ?>laporan/dosen/skripsi"><i class="fa fa-chevron-circle-right"></i>Dosen</a></li>
			<li><a href="<?php echo base_url() ?>laporan/mahasiswa/skripsi"><i class="fa fa-chevron-circle-right"></i>Mahasiswa</a></li>
        </ul>
    </li>
</ul>
