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
  <script>
    function validarFrmVisita(){
      var informacion = document.getElementById("info_visita").value;
      var error_msg = document.getElementById("error_frmVisita");

      if(informacion == ""){
        error_msg.innerHTML = "* Por favor ingresar información en relación a la visita.";
        return false;
      }
    }

    function limpiarFrmVisita(){
      var id = document.getElementById("id_visita");
      var informacion = document.getElementById("info_visita");
      var submitbtn = document.getElementById("subFrmVisita");     
      var deletebtn = document.getElementById("delFrmVisita");
      var error_msg = document.getElementById("error_frmVisita");

      id.value = "";
      informacion.value = "";
      error_msg.innerHTML = "";
      submitbtn.value = "Agregar"
      deletebtn.type = "hidden"; 
      
    }

    function seleccionarVisita(id){
      limpiarFrmVisita();
      var id_visita = document.getElementById("t_id_visita"+id).innerHTML;
      var comentario = document.getElementById("t_comentario"+id).innerHTML;

      document.getElementById("id_visita").value = id_visita;
      document.getElementById("info_visita").value = comentario;

      document.getElementById("subFrmVisita").value = "Editar";
      document.getElementById("delFrmVisita").type = "submit";
    }
  </script>
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
                    /*header("Location: ingresar.php");
                    exit();*/
                    echo "<script>window.location.href = 'ingresar.php';</script>";
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
            <?php
              $sql = "select * from expediente where id_expediente = '".$_GET['expediente']."'";
              $result = $database->executeQuery($sql);

              //If para revisar si existen registros
              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  ?>
                  <h3 class="page-header"><i class="fa fa fa-bars"></i> Visitas || Expediente: <?= $row["nombres"] ?> <?= $row["apellidos"] ?></h3>
                  <?php
                }
              }
            ?>

          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Expediente
              </header>
              <div class="panel-body">
                <div class="form">
                  <?php
                  $sql = "select * from expediente where id_expediente = '".$_GET["expediente"]."'";
                  //Funcion que retorna el resultado del query
                  $result = $database->executeQuery($sql);
                  //If para revisar si existen registros
                  if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                    ?>
                  <form class="form-validate form-horizontal">
                    <input type="hidden" id="id_expediente" name="id_expediente" value="0">
                    <div class="form-group ">
                      <label for="nombre_usuario" class="control-label col-lg-2">Nombres</span></label>
                      <div class="col-lg-10">
                        <input class="form-control" readonly name="nombres_expediente" type="text" value="<?= $row["nombres"] ?>" />
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="nombre_usuario" class="control-label col-lg-2">Apellidos</span></label>
                      <div class="col-lg-10">
                        <input class="form-control" readonly name="apellidos_expediente" type="text" value="<?= $row["apellidos"] ?>"/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="nombre_usuario" class="control-label col-lg-2">Edad</span></label>
                      <div class="col-lg-10">
                        <input class="form-control" readonly name="edad_expediente" type="number" value="<?= $row["edad"] ?>"/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="contrasena_usuario" class="control-label col-lg-2">Comentario</span></label>
                      <div class="col-lg-10">
                        <textarea class="form-control" readonly name="comentario_expediente" rows="4"><?= $row["comentario"] ?></textarea>
                      </div>
                    </div>
                  </form>
                  <?php
                    }
                  }
                  ?>
                </div>
              </div>
            </section>
            <section class="panel">
              <header class="panel-heading">
                Visita
              </header>
              <div class="panel-body">
                <div class="form">
                  <form class="form-validate form-horizontal" id="frmVisita" onsubmit="return validarFrmVisita();" method="post" action="">
                    <input type="hidden" id="id_visita" name="id_visita" value="0">
                    <div class="form-group ">
                      <label for="contrasena_usuario" class="control-label col-lg-2">Información de Visita</span></label>
                      <div class="col-lg-10">
                        <textarea class="form-control" id="info_visita" name="info_visita" rows="8" maxlength="5000"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <input class="btn btn-primary" type="submit" name="subFrmVisita" id="subFrmVisita" value="Agregar">
                        <input class="btn btn-primary" type="hidden" name="delFrmVisita" id="delFrmVisita" value="Eliminar">
                        <input class="btn btn-default" type="button" onclick="limpiarFrmVisita()" value="Cancelar">
                      </div>
                    </div>
                    <div class="col-lg-offset-2 col-lg-10">
                      <p style="color: red" id="error_frmVisita"></p>
                    </div>
                  </form>
                </div>
                <?php
                if(isset($_POST["subFrmVisita"]) && $_POST["subFrmVisita"] == "Agregar"){
                  
                  $comentario = $_POST["info_visita"];
                  $id_usuario = $_SESSION["usuario"];
                  $id_expediente = $_GET["expediente"];

                  $sql = "insert into visita values(0,CURRENT_DATE(),'".$comentario."','".$id_expediente."','".$id_expediente."')";
                  if($database->executeNonQuery($sql)){
                    echo "<script>$('#panel').load('adm_visita.php');</script>";
                  }
                  else{
                    echo "<script>document.getElementById('error_frmVisita').innerHTML = '* Error al ingresar la visita.'</script>"; 
                  }
                }
                else if(isset($_POST["subFrmVisita"]) && $_POST["subFrmVisita"] == "Editar"){
                  $id_visita = $_POST["id_visita"];
                  $comentario = $_POST["info_visita"];

                  //UPDATE `visita` SET `comentario` = 'bnhjkhhhhh' WHERE `visita`.`id_visita` = 1;
                  $sql = "update visita set comentario = '".$comentario."' where id_visita = '".$id_visita."'";
                  if($database->executeNonQuery($sql)){
                    echo "<script>$('#panel').load('adm_visita.php');</script>";
                  }
                  else{
                    echo "<script>document.getElementById('error_frmVisita').innerHTML = '* Error al editar la visita.'</script>"; 
                  }
                }
                else if(isset($_POST["delFrmVisita"]) && $_POST["delFrmVisita"] == "Eliminar"){
                  $id_visita = $_POST["id_visita"];
                  $sql = "delete from visita where id_visita = '".$id_visita."'";
                  if($database->executeNonQuery($sql)){
                    echo "<script>$('#panel').load('adm_visita.php');</script>";
                  }
                  else{
                    echo "<script>document.getElementById('error_frmVisita').innerHTML = '* Error al eliminar la visita.'</script>"; 
                  }
                }
                ?>
              </div>
            </section>
          </div>
          <div class="col-lg-12">
            <section class="panel" id="panel">
              <header class="panel-heading">
                Visitas
              </header>
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th></i># Id</th>
                    <th><i class="icon_calendar"></i> Fecha de Visita</th>
                    <th><i class="icon_profile"></i> Creador</th>
                    <th>Comentario</th>
                    <th><i class="icon_cogs"></i> Seleccionar</th>
                  </tr>
                  <?php
                  $sql = "select * from visita as v
                          inner join usuario as u
                          on u.id_usuario = v.id_usuario
                          where v.id_expediente = '".$_GET['expediente']."'";
                  //Funcion que retorna el resultado del query
                  $result = $database->executeQuery($sql);
                  //If para revisar si existen registros
                  if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                      //Creo dinamicamente las opciones del input
                      ?>
                        <tr>
                          <td id="t_id_visita<?= $row["id_visita"] ?>"><?= $row["id_visita"] ?></td>
                          <td><?= $row["fecha"] ?></td>
                          <td id="t_usuario<?= $row["id_visita"] ?>"><?= $row["usuario"] ?></td>
                          <td id="t_comentario<?= $row["id_visita"] ?>"><?= $row["comentario"] ?></td>
                          <td>
                            <div class="btn-group">
                              <a class="btn btn-primary" onclick="seleccionarVisita(<?= $row["id_visita"] ?>)" href="#"><i class="icon_plus_alt2"></i></a>
                            </div>
                          </td>
                        </tr>
                      <?php
                    }
                  }
                  ?>
                </tbody>
              </table>
            </section>
          </div>
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
