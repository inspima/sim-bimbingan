<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <?php 
        $sebagai = $this->session_data['sebagai'];
        $role    = $this->session_data['role'];
        
        if($sebagai == '1') // dosen
        {
            $this->load->view('backend/incl_sidebar/menu/dosen');
        }
        else
        if($sebagai == '2') // tendik
        {
            if($role == '1') // Admin
            {
                $this->load->view('backend/incl_sidebar/menu/administrator');
            }
            else
            if($role == '2') // BAA
            {
                $this->load->view('backend/incl_sidebar/menu/baa');
            }
        }
        else
        if($sebagai == '3') // mahasiswa
        {
            if(($role != 5)&&($role != 6)) // S1
            {
                $this->load->view('backend/incl_sidebar/menu/mahasiswa');
            }
            else if($role == 5) // S2
            {
                $this->load->view('backend/incl_sidebar/menu/mahasiswa_s2');
            }
            else if($role == 6) // S3
            {
                $this->load->view('backend/incl_sidebar/menu/mahasiswa_s3');
            }
        }
            
        ?>
    </section>
    <!-- /.sidebar -->
  </aside>