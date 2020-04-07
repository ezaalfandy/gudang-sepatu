<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/')?>img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?= base_url('assets/')?>img/joemen-icon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Joman - <?= $this->session->userdata('nama');?>
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
    name='viewport' />
  <link rel="stylesheet" type="text/css"
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700" />

  <link href="<?= base_url('assets/')?>iconfont/material-icons.css" rel="stylesheet" />
  <link href="<?= base_url('assets/')?>css/material-dashboard.css?v=2.1.0" rel="stylesheet" />
  <link href="<?= base_url('assets/')?>css/custom.css" rel="stylesheet" />
  
  <script src="<?= base_url('assets/')?>js/core/jquery.min.js" type="text/javascript"></script>
  <script src="<?= base_url('assets/')?>js/core/popper.min.js" type="text/javascript"></script>
  <script src="<?= base_url('assets/')?>js/plugins/arrive.min.js" type="text/javascript"></script>
  <script src="<?= base_url('assets/')?>js/core/bootstrap-material-design.min.js" type="text/javascript"></script>

</head>

<body class="off-canvas-sidebar">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
    <div class="container">
      <div class="navbar-wrapper">
        <a class="navbar-brand" href="#pablo">JoeMen</a>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="wrapper wrapper-full-page">
    <div class="page-header error-page header-filter" filter-color="black" style="background-image: url('<?= base_url('assets/')?>img/login.jpg');">
      <div class="content-center">
        <div class="row">
          <div class="col-md-12">
            <h1 class="title">404</h1>
            <h2>Halaman Tidak Ditemukan :(</h2>
            <h4><a href="<?= base_url()?>" class="h4">Kembali ke halaman utama</a></h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>