<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
    <li class="treeview">
        <a href="#">
            <i class="fa fa-list-alt"></i> <span>Master</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url()?>dashboarda/master/user"><i class="fa fa-circle-o"></i> User</a></li>
            <li><a href="<?php echo base_url()?>dashboarda/master/struktural"><i class="fa fa-circle-o"></i> Struktural</a></li>
        </ul>
    </li>
	<li class="treeview">
		<a href="#">
			<i class="fa fa-cogs"></i> <span>Utility</span>
			<span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
		</a>
		<ul class="treeview-menu">
			<li><a href="<?php echo base_url()?>dashboarda/utility/database/backup"><i class="fa fa-circle-o"></i> Database Backup</a></li>
		</ul>
	</li>
</ul>
