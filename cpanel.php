<?php 
  require "php/error_handler.php";
  require "class/class.database.php";
  session_start();
  $database = new database();
  //If para revisar si sesion de usuario existe
  if(!isset($_SESSION['usuario']) || $_SESSION["usuario"] == null){
    //Redirecciona a pagina de panel de control
    header("Location: ingresar.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Parroquia Santa Catarina</title>
  <link rel="icon" href="img/logo_vertical_black.png">

  <!-- Bootstrap CSS -->
  <link href="css_cpanel/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="css_cpanel/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="css_cpanel/elegant-icons-style.css" rel="stylesheet" />
  <link href="css_cpanel/font-awesome.min.css" rel="stylesheet" />
  <!-- Custom styles -->
  <link href="css_cpanel/style.css" rel="stylesheet">
  <link href="css_cpanel/style-responsive.css" rel="stylesheet" />
</head>

<body>
  <!-- container section start -->
  <section id="container" class="">
    <!--header start-->

    <header class="header dark-bg">
      <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
      </div>

      <!--logo start-->
      <a href="cpanel.php" >
        <img src="img/logo_horizontal_white.png" class="logo" style="height: 57px">
      </a>
      <!--logo end-->
      <div class="top-nav notification-row">
        <!-- notificatoin dropdown start-->
        <ul class="nav pull-right top-menu">
          <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="profile-ava">
                                <img alt="" src="img/avatar1_small.jpg">
                            </span>
                            <?php
                            $usuario = "";
                            //Linea de SQL para querry
                            $sql = "select * from usuario where id_usuario='".$_SESSION["usuario"]."'";
                            //Funcion que retorna el resultado del query
                            $result = $database->executeQuery($sql);

                            //If para revisar si existen registros
                            if ($result->num_rows > 0) {
                              while($row = $result->fetch_assoc()) {
                                //Ingresa el nombre de usuario en variable $usuario
                                $usuario = $row["usuario"];
                              }
                            }
                            ?>
                            <span class="username"><?= $usuario ?></span>
                            <b class="caret"></b>
                        </a>
            <ul class="dropdown-menu extended logout">
              <div class="log-arrow-up"></div>
              <li class="eborder-top">
                <a href="#"><i class="icon_profile"></i> Perfil</a>
              </li>
              <li>
                <form action="" method="post" id="frmLogout">
                  <i class="icon_key_alt"></i> 
                  <input id="subLogout" name="subLogout" type="submit" value="Salir">
                </form>
                <?php
                  if(isset($_POST["subLogout"]) && $_POST["subLogout"] == "Salir"){
                    $_SESSION["usuario"] = null;
                    header("Location: ingresar.php");
                    exit();
                  }
                ?>
              </li>
            </ul>
          </li>
          <!-- user login dropdown end -->
        </ul>
        <!-- notificatoin dropdown end-->
      </div>
    </header>
    <!--header end-->

    <!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
          <li class="">
            <a class="" href="cpanel.php">
                          <i class="icon_house_alt"></i>
                          <span>Inicio</span>
                      </a>
          </li>
          <?php 
          $sql = "select p.nombre_externo, p.nombre_interno from usuario as u inner join tipo as t on t.id_tipo = u.id_tipo inner join tipo_permiso as tp on tp.id_tipo = t.id_tipo inner join permiso as p on p.id_permiso = tp.id_permiso where u.id_usuario = '".$_SESSION["usuario"]."'";
          //Funcion que retorna el resultado del query
          $result = $database->executeQuery($sql);

          //If para revisar si existen registros
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              //Creo dinamicamente el menu
              ?>
                <li class="">
                  <a class="" href="<?= $row['nombre_interno'] ?>.php">
                                <i class="icon_house_alt"></i>
                                <span><?= $row["nombre_externo"] ?></span>
                            </a>
                </li>
              <?php
            }
          }
          ?>
          <!--
          <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_document_alt"></i>
                          <span>Forms</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="form_component.html">Form Elements</a></li>
              <li><a class="" href="form_validation.html">Form Validation</a></li>
            </ul>
          </li>
          <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_desktop"></i>
                          <span>UI Fitures</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="general.html">Components</a></li>
              <li><a class="" href="buttons.html">Buttons</a></li>
              <li><a class="" href="grids.html">Grids</a></li>
            </ul>
          </li>
          <li>
            <a class="" href="widgets.html">
                          <i class="icon_genius"></i>
                          <span>Widgets</span>
                      </a>
          </li>

          <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_table"></i>
                          <span>Tables</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="basic_table.html">Basic Table</a></li>
            </ul>
          </li>-->
          
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Inicio</h3>
          </div>
        </div>
        <!-- page start-->
        <div style="width: 100%;text-align: center;padding-top: 10%">
          <img src="img/logo_vertical_black.png">
        </div>
        <!-- page end-->
      </section>
    </section>
  </section>
  <!-- container section end -->
  <!-- javascripts -->
  <script src="js_cpanel/jquery.js"></script>
  <script src="js_cpanel/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="js_cpanel/jquery.scrollTo.min.js"></script>
  <script src="js_cpanel/jquery.nicescroll.js" type="text/javascript"></script>
  <!--custome script for all page-->
  <script src="js_cpanel/scripts.js"></script>


</body>

</html>
<?php 
$database->closeConnection();
?>
