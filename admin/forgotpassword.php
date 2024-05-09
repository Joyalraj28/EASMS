<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
 <style>

   .page-header{
      text-shadow: 3px 2px black;
   }

   .headerlogin{
    
    background-image: <?php echo validate_image($_settings->info('logo')) ?>;
    height: 50px;
    margin: 20px;
    display: flex;
    flex-direction: row;
    justify-content: start;

   }

   .headerlogin > img{
    width: 50px;
   }

   .headerlogin > p{
    margin: 10px;
    font-weight: bold;
   }

   

 </style>
<body class="hold-transition login-page" style="<?php echo "background-image: url(".validate_image($_settings->info('login_bg')).");" ?>">

<!-- <div id="preloader"></div> -->
  <script>
    start_loader()
  </script>


</div>
<div class="login-box">

  <!-- /.login-logo -->
  <div class="card card-primary">
  <div class="headerlogin">
  <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="logo">
  <p><?php echo "Forgot Password"//$_settings->info('title') ?></p>
  </div>
    <div class="card-body">
      <form id="login-frm" action="" method="post">
    
       <div class="input-group mb-3">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
          <input type="text" class="form-control" name="username" placeholder="Username">
        </div>


        <div class="input-group mb-3">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <div class="row justify-content-between">
          <div class="col">
            <a href="<?php echo base_url ?>">Go Back</a>
          </div>
          <!-- /.col -->
          <div class="col text-right">
            <button type="submit" class="btn btn-primary btn-flat btn-sm">Reset</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->
      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->

<!-- /.login-box -->


<!-- jQuery -->
<!-- <script src="plugins/jquery/jquery.min.js"></script> -->
<!-- Bootstrap 4 -->
<!-- <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
<!-- AdminLTE App -->
<!-- <script src="dist/js/adminlte.min.js"></script> -->

<script>
  $(document).ready(function(){
     end_loader();
  })
</script>

</body>
</html>