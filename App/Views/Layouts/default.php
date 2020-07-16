<?php
use System\Session\Session;
use App\Models\ConfigPdv;
use App\Config\ConfigPerfil;

$configPdv = new ConfigPdv();
$configPdv = $configPdv->configPdv(Session::get('idEmpresa'));
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <base href="<?php echo BASEURL;?>">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link rel="shortcut icon" href="public/img/favicon.png" />
  <title>
    <?php
      if ($this->getTitle()) {
        echo $this->getTitle() . " | ";
      }
    ?>
    Zig Money
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />

  <!-- CSS Files -->

  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL;?>/public/assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL;?>/public/assets/css/paper-dashboard.css?v=2.0.0')}}">
  <link rel="stylesheet" type="text/css" href="<?php echo BASEURL;?>/public/css/bootstrap.min.css.map">


  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

  <style>
  .disabled:hover {
    cursor:no-drop!important;
  }
  .perfil {
    border-radius:50%;
    width: 40px;
    height: 40px;
    object-fit: cover;
    object-position: center;
  }
  .currentRouteFromMenu {
    background:#3b3b3a;
    border-radius:10px;
  }
  .tabela-ajustada tr td {
    padding-top:2px!important;
    padding-bottom:2px!important;
    font-size:12px!important;
  }
  .tabela-ajustada th {
    font-size:13px!important;
  }
  .table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
    background-color:#fffcf5;
  }
  .active {
    color:#0a9850!important;
  }
  .legendaPerfil {
    font-size:12px;!important;
    background:#f4f3ef;
    border-radius:10px;
    border:1px solid #dddddd;
    padding:5px;
  }
  </style>
</head>

<body class="">
  <div class="wrapper">
    <div class="sidebar" data-color="black" data-active-color="danger">

      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          <div class="logo-image-small">

          </div>
        </a>
        <a href="<?php echo BASEURL;?>/pdvDiferencial" class="simple-text logo-normal">
          <span style="color:#00cc66;">&nbsp;&nbsp;&nbsp;
            <i class="fas fa-dollar-sign"></i> <b style="opacity:0.70">TONIE</b>
          </span>
          <!--<span>Zig</span>
          <span>Money</span>-->
        </a>
      </div>

      <!--Carrega o menu lateral da aplicação-->
      <?php require_once('menuLeft.php');?>

    </div>

      <div class="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
          <div class="container-fluid">

            <div class="navbar-wrapper">
              <div class="navbar-toggle">
                <button type="button" class="navbar-toggler">
                  <span class="navbar-toggler-bar bar1"></span>
                  <span class="navbar-toggler-bar bar2"></span>
                  <span class="navbar-toggler-bar bar3"></span>
                </button>
              </div>
              <a class="navbar-brand" href="<?php echo BASEURL;?>/usuario"
                style="text-transform:lowercase!important;">

                <?php $imagemPerfil = Session::get('imagem');?>
                <?php if ($imagemPerfil != false):?>
                  <img class="perfil" src="<?php echo BASEURL .'/'. Session::get('imagem')?>">
                <?php else:?>
                  <i class="fas fa-user" style="font-size:30px;"></i>
                <?php endif;?>

                <i style="text-transform: capitalize;">
                  <?php echo Session::get('nomeUsuario');?>
                  <small style="font-size:11px;" class="legendaPerfil">
                    <i class="fas fa-circle" style="color:#00cc99;font-size:8px"></i>
                    <?php echo Session::get('legendaPerfil');?>
                  </small>
                </i>
              </a>
            </div>

            <div class="collapse navbar-collapse justify-content-end" id="navigation">
              <ul class="navbar-nav">
                  <li class="nav-item btn-rotate dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="nc-icon nc-settings-gear-65"></i>

                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <!--<a class="dropdown-item" href="#">Meus dados</a>-->

                    <a class="dropdown-item" href="<?php echo BASEURL;?>/usuario">
                      <i class="fas fa-users"></i> Usuários
                    </a>

                    <!--Modulo Empresas-->
                    <?php if (Session::get('idPerfil') == 1):?>
                      <a class="dropdown-item" href="<?php echo BASEURL;?>/empresa">
                        <i class="fas fa-store"></i> Empresas
                      </a>
                    <?php endif;?>

                    <?php if (Session::get('idPerfil') != ConfigPerfil::vendedor()):?>
                      <a class="dropdown-item" href="<?php echo BASEURL;?>/configuracao">
                        <i class="fas fa-cogs"></i> Configurações
                      </a>
                    <?php endif;?>

                    <?php if (Session::get('idPerfil') != ConfigPerfil::vendedor()):?>
                      <a class="dropdown-item" href="<?php echo BASEURL; ?>/logs">
                        <i class="fas fa-file-signature"></i> Logs de acessos
                      </a>
                    <?php endif;?>

                    <a class="dropdown-item" href="login/logout">
                      <i class="fas fa-sign-out-alt"></i> Sair do Sistema
                    </a>

                  </div>
                </li>
              </ul>
            </div>

          </div>
        </nav>
        <!-- End Navbar -->

        <div class="content">
          <!--Include the content into the layout-->
          <?php $this->viewRender();?>
        </div>

    </div>
  </div>
</div>


  <div id="modal-validacao" class="modal fade bd-example-modal-lg" role="dialog"
  style="background: rgba(00, 00, 00, 0.6);">
      <div class="modal-dialog" data-backdrop="static">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <!--<h4 class="modal-title"></h4>-->
              </div>

              <div class="modal-body">
                  <div id="modal-body-content">
                      <p id="p-modal-validation"></p>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <script src="<?php echo BASEURL;?>/public/assets/js/core/jquery.min.js"></script>
  <script src="<?php echo BASEURL;?>/public/assets/js/core/popper.min.js"></script>
  <script src="<?php echo BASEURL;?>/public/assets/js/core/bootstrap.min.js"></script>
  <script src="<?php echo BASEURL;?>/public/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="<?php echo BASEURL;?>/public/js/helpers.js"></script>
  <script src="<?php echo BASEURL;?>/public/js/mask.js"></script>
  <script src="<?php echo BASEURL;?>/public/assets/js/paper-dashboard.min.js"></script>

  <script>
    $(function() {
        jQuery('.campo-moeda')
        .maskMoney({
          prefix:'R$ ',
          allowNegative: false,
          thousands:'.', decimal:',',
          affixesStay: false
        });


        $("#menu").click(function() {
          $(".collapse").toggle();
        })
    });
  </script>

</body>

</html>

<!--
  Layout
  https://demos.creative-tim.com/bs3/paper-dashboard/dashboard.html?_ga=2.109253573.1911018205.1590242535-1802779238.1590242535#
-->
