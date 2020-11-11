<!DOCTYPE html>
<html>
<?php $this->load->view('backend/incl/head')?>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <?php $this->load->view('backend/incl/header')?>
  <div class="content-wrapper" style="background-image: url('https://fh.unair.ac.id/iuris2019/assets/img/bg-home.png');">
    <div class="container">
        <section class="content">
            
            <?php $this->load->view($section)?>
        </section>
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view('backend/incl/footer')?>
</div>
<!-- ./wrapper -->

<?php $this->load->view('backend/incl/script')?>
</body>
</html>
