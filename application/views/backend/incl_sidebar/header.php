<header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>IU</b>R</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>IURIS</b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?php echo base_url() ?>assets/img/avatar.png" class="user-image" alt="User Image">
                        <span><?php echo $this->session_data['nama'] ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo base_url() ?>assets/img/avatar.png" class="img-circle" alt="User Image">
                            <p>
                                <?php echo $this->session_data['nama'] ?>
                                <small>
                                    <?php echo $this->session_data['username'] ?>
                                </small>
                                <small> 
                                    <?php
                                    if ($this->session_data['sebagai'] == '1'):
                                        echo "Dosen";
                                    elseif ($this->session_data['sebagai'] == '2'):
                                        echo "Tendik";
                                    else:
                                        echo "Mahasiswa";
                                    endif;
                                    ?>
                                </small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo base_url() ?>profile" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo base_url() ?>logout" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </nav>
</header>
