<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/')?>img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?= base_url('assets/')?>img/joemen-icon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    JoeMen - <?= $this->session->userdata('nama');?>
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

  <script src="<?= base_url('assets/')?>js/plugins/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
  <script src="<?= base_url('assets/')?>js/plugins/chartist.min.js" type="text/javascript"></script>
  <script src="<?= base_url('assets/')?>js/plugins/jasny-bootstrap.min.js" type="text/javascript"></script>
  <script src="<?= base_url('assets/')?>js/plugins/jquery.dataTables.min.js" type="text/javascript"></script>
  <script src="<?= base_url('assets/')?>js/plugins/sweetalert2.js" type="text/javascript"></script>

  <script src="<?= base_url('assets/')?>js/plugins/jquery.validate.min.js" type="text/javascript"></script>
  <script src="<?= base_url('assets/')?>js/plugins/additional-methods.min.js" type="text/javascript"></script>
  <script src="<?= base_url('assets/')?>js/plugins/notEqualTo.js" type="text/javascript"></script>

  <script src="<?= base_url('assets/')?>js/plugins/jquery.autocomplete.min.js" type="text/javascript"></script>
  <script src="<?= base_url('assets/')?>js/material-dashboard.js?v=2.1.0" type="text/javascript"></script>

  <script src="<?= base_url('assets/')?>js/plugins/jquery.bootstrap-wizard.js"></script>
  <script src="<?= base_url('assets/')?>js/plugins/bootstrap-selectpicker.js"></script>
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-background-color="red" data-image="<?= base_url('assets/')?>img/sidebar-sepatu.jpg">
      <div class="logo">
        <a href="javascript:void(0)" class="simple-text logo-mini">
          JM
        </a>
        <a href="javascript:void(0)" class="simple-text logo-normal">
          JoeMen
        </a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="<?= base_url('uploads/admin/').$this->session->userdata('foto');?>" />
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                <?= $this->session->userdata('nama');?>
                <b class="caret"></b>
              </span>
            </a>
            <div class="collapse" id="collapseExample">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <span class="sidebar-mini"> MP </span>
                    <span class="sidebar-normal"> My Profile </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <span class="sidebar-mini"> EP </span>
                    <span class="sidebar-normal"> Edit Profile </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <span class="sidebar-mini"> S </span>
                    <span class="sidebar-normal"> Settings </span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <ul class="nav">
          <li class="nav-item <?php if($this->uri->segment(2) == 'dashboard'){echo 'active';}?>">
            <a class="nav-link" href="<?= base_url('admin-gudang/dashboard')?>">
              <i class="material-icons">dashboard</i>
              <p> Dashboard </p>
            </a>
          </li>
          <li class="nav-item <?php if($this->uri->segment(2) == 'view-stok-barang'){echo 'active';}?>">
            <a class="nav-link" href="<?= base_url('admin-gudang/view-stok-barang')?>">
              <i class="material-icons">assessment</i>
              <p>Stok Barang</p>
            </a>
          </li>
          <li class="nav-item <?php if($this->uri->segment(2) == 'view-pre-order'){echo 'active';}?>">
            <a class="nav-link" href="<?= base_url('admin-gudang/view-pre-order')?>">
              <i class="material-icons">insert_drive_file</i>
              <p> Pre Order</p>
            </a>
          </li>
          <li class="nav-item <?php if($this->uri->segment(2) == 'view-hand-over'){echo 'active';}?>">
            <a class="nav-link" href="<?= base_url('admin-gudang/view-hand-over')?>">
              <i class="material-icons">compare_arrows</i>
              <p>Hand Over</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
              <i class="material-icons">shopping_cart</i>
              <p> Penjualan
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="pagesExamples">
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="../examples/pages/pricing.html">
                    <span class="sidebar-mini"> P </span>
                    <span class="sidebar-normal"> Pricing </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="../examples/pages/rtl.html">
                    <span class="sidebar-mini"> RS </span>
                    <span class="sidebar-normal"> RTL Support </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-minimize">
              <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:void(0)"><?= url_to_breadcrumb($this->uri->segment(2));?></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="#pablo">
                  <i class="material-icons">dashboard</i>
                  <p class="d-lg-none d-md-block">
                    Stats
                  </p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">notifications</i>
                  <span class="notification">5</span>
                  <p class="d-lg-none d-md-block">
                    Some Actions
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Mike John responded to your email</a>
                  <a class="dropdown-item" href="#">You have 5 new tasks</a>
                  <a class="dropdown-item" href="#">You're now friend with Andrew</a>
                  <a class="dropdown-item" href="#">Another Notification</a>
                  <a class="dropdown-item" href="#">Another One</a>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="#">Profile</a>
                  <a class="dropdown-item" href="#">Settings</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?= base_url('Account/logout')?>">Log out</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      
      <div class="content">
        <?php $this->load->view($main_view);?>
      </div>

      <footer class="footer">
        <div class="container-fluid">
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>, JoeMen Indonesia
          </div>
        </div>
      </footer>
    </div>
  </div>  
</body>

</html>