<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
	<?php
		$id_jenjang = $this->session_data['id_jenjang'];
		if ($id_jenjang == JENJANG_S1) {
			?>
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
					<i class="fa fa-file"></i> <span>Sarjana</span>
					<span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
				</a>
				<ul class="treeview-menu">

				</ul>
			</li>

			<?php
		} else if ($id_jenjang == JENJANG_S2) {
			?>
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
					<i class="fa fa-users"></i> <span>Mahasiswa</span>
					<span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url() ?>baa/utility/registrasi/master_mkn"><i class="fa fa-chevron-circle-right"></i> Verifikasi Registrasi</a></li>
					<li><a href="<?php echo base_url() ?>baa/utility/pencarian"><i class="fa fa-chevron-circle-right"></i> Pencarian Mahasiswa</a></li>
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
					<li><a href="<?php echo base_url() ?>prodi/tesis/ujian"><i class="fa fa-chevron-circle-right"></i> Persetujuan Tesis</a></li>
					<li><a href="<?php echo base_url() ?>prodi/magister/tesis/judul"><i class="fa fa-chevron-circle-right"></i> Dokumen Tesis</a></li>
				</ul>
			</li>

			<?php
		} else if ($id_jenjang == JENJANG_S3) {
			?>
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
					<i class="fa fa-users"></i> <span>Mahasiswa</span>
					<span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url() ?>baa/utility/registrasi/doktor"><i class="fa fa-chevron-circle-right"></i> Verifikasi Registrasi</a></li>
					<li><a href="<?php echo base_url() ?>baa/utility/pencarian"><i class="fa fa-chevron-circle-right"></i> Pencarian Mahasiswa</a></li>
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
					<li><a href="<?php echo base_url() ?>prodi/doktoral/disertasi/kualifikasi"><i class="fa fa-chevron-circle-right"></i>Disertasi</a></li>
				</ul>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-dashboard"></i> <span>Master</span>
					<span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url() ?>prodi/doktoral/master/mkpkk"><i class="fa fa-user"></i>MKPKK</a></li>

				</ul>
			</li>
			<?php
		}
	?>
</ul>
