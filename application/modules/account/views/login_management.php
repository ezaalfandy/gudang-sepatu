<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/')?>img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?= base_url('assets/')?>img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
      Warehouse - Login
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700" />
  
  <link href="<?= base_url('assets/')?>iconfont/material-icons.css" rel="stylesheet" />
  <link href="<?= base_url('assets/')?>css/material-dashboard.css?v=2.1.0" rel="stylesheet" />
  <link href="<?= base_url('assets/')?>demo/demo.css" rel="stylesheet" />
</head>

<body class="off-canvas-sidebar">

  <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
    <div class="container">
      <div class="navbar-wrapper">
        <a class="navbar-brand">Login Page</a>
      </div>
    </div>
  </nav>

  <div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('<?= base_url('assets/')?>img/login.jpg'); background-size: cover; background-position: top center;">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" method="post" action="<?= base_url('account/login_management')?>">
              <div class="card card-hidden card-login">
                <div class="card-header card-header-rose text-center">
                  <h4 class="card-title">Welcome Leader !</h4>
                </div>
                <div class="card-body">
                  <?php
                    if($this->session->flashdata('message') !== null)
        {
                      echo '
                      <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>
                          <b> Ups - </b> '.$this->session->flashdata('message').'</span>
                      </div>
                      ';
                    }
                  ?>
                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">face</i>
                        </span>
                      </div>
                      <input type="text" class="form-control" placeholder="Username" name="username" required>
                    </div>
                  </span>
                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">lock_outline</i>
                        </span>
                      </div>
                      <input type="password" class="form-control" placeholder="Password" name="password" required>
                    </div>
                  </span>
                </div>
                <div class="card-footer justify-content-center">
                  <button type="submit" class="btn btn-rose btn-link btn-lg">Login</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container">
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>, Joeman Indonesia.
          </div>
        </div>
      </footer>
    </div>
  </div>

  <script src="<?= base_url('assets/')?>js/core/jquery.min.js"></script>
  <script src="<?= base_url('assets/')?>js/core/popper.min.js"></script>
  <script src="<?= base_url('assets/')?>js/core/bootstrap-material-design.min.js"></script>
  <script src="<?= base_url('assets/')?>js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="<?= base_url('assets/')?>js/material-dashboard.js?v=2.1.0" type="text/javascript"></script>
  <script>
    $(document).ready(function() {
      md.checkFullPageBackgroundImage();
      setTimeout(function() {
        // after 1000 ms we add the class animated to the login/register card
        $('.card').removeClass('card-hidden');
      }, 700);
    });
  </script>
</body>

</html>