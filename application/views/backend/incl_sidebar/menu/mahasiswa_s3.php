<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li>
        <a href="<?php echo base_url() ?>dashboardm">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-book"></i> <span>Disertasi</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url() ?>mahasiswa/disertasi/kualifikasi"><i class="fa fa-circle-o"></i> Kualifikasi</a></li>
            <li><a href="<?php echo base_url() ?>mahasiswa/disertasi/proposal"><i class="fa fa-circle-o"></i> Proposal</a></li>
            <li><a href="<?php echo base_url() ?>mahasiswa/disertasi/ma"><i class="fa fa-circle-o"></i> MKPKK/MKPD</a></li>
            <li><a href="<?php echo base_url() ?>mahasiswa/disertasi/ujian"><i class="fa fa-circle-o"></i> Ujian</a></li>
        </ul>
    </li>
</ul>