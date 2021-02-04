<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
	<?php
		$jenjang = $this->session_data['jenjang'];
		if ($jenjang == 1) {
			?>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-file"></i> <span>Sarjana</span>
					<span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
				</a>
				<ul class="treeview-menu">

				</ul>
			</li>

			<?php
		} else if ($jenjang == 2) {
			?>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-file-text-o"></i> <span>Magister</span>
					<span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
				</a>
				<ul class="treeview-menu">

				</ul>
			</li>

			<?php
		} else if ($jenjang == 3) {
			?>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-book"></i> <span>Doktoral</span>
					<span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url() ?>prodi/doktoral/disertasi/kualifikasi"><i class="fa fa-circle-o"></i>Persetujuan</a></li>
					<li><a href="<?php echo base_url() ?>prodi/doktoral/disertasi/cetak_sk"><i class="fa fa-circle-o"></i>Cetak SK</a></li>
				</ul>
			</li>

			<?php
		}
	?>
</ul>
