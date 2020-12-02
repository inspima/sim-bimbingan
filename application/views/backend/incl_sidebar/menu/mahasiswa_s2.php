<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li><a href="<?php echo base_url() ?>dashboardm"><i class="fa fa-dashboard"></i> Dashboard</a></li>      
    <!--    <li class="treeview">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>Proposal Tesis</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
            <li><a href="<?php echo base_url() ?>dashboardm/magister/proposal_tesis"><i class="fa fa-circle-o"></i> Proposal</a></li>        
            </ul>
        </li>-->
    <li class="treeview">
        <a href="#">
            <i class="fa fa-file-o"></i> <span>Tesis</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
                        <!--<li><a href="<?php //echo base_url() ?>dashboardm/magister/tesis"><i class="fa fa-circle-o"></i> Tesis</a></li>--> 
            <li><a href="<?php echo base_url() ?>mahasiswa/tesis/proposal"><i class="fa fa-circle-o"></i> Proposal</a></li>
            <li><a href="<?php echo base_url() ?>mahasiswa/tesis/ujian"><i class="fa fa-circle-o"></i> Tesis</a></li>
        </ul>
    </li>
</ul>