<!DOCTYPE html>
<html>
<?php $this->load->view('backend/incl_sidebar/head')?>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <?php $this->load->view('backend/incl_sidebar/header')?>
  <?php $this->load->view('backend/incl_sidebar/sidebar')?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <p style="font-size:18px;">
        <?php echo $title?>
      </p>
      
    </section>

    <!-- Main content -->
    <section class="content">
      <?php $this->load->view($section)?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('backend/incl_sidebar/footer')?>

</div>
<!-- ./wrapper -->

<?php $this->load->view('backend/incl_sidebar/script')?>
</body>
</html>
