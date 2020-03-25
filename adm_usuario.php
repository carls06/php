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
    function validarFrmUsuario(){
      var usuario = document.getElementById("nombre_usuario").value;
      var contrasena = document.getElementById("contrasena_usuario").value;
      var error_msg = document.getElementById("error_frmUsuario");

      if(usuario === "" || contrasena === ""){
        error_msg.innerHTML = "* Por favor ingresar todos los parámetros.";
        return false;
      }
    }

    function limpiarFrmUsuario(){
      var id = document.getElementById("id_usuario");
      var usuario = document.getElementById("nombre_usuario");
      var contrasena = document.getElementById("contrasena_usuario");
      var tipo = document.getElementById("tipo_usuario");
      var error_msg = document.getElementById("error_frmUsuario");
      var submitbtn = document.getElementById("subFrmUsuario");     
      var deletebtn = document.getElementById("delFrmUsuario");

      id.value = "";
      usuario.value = "";
      tipo.selectedIndex = 0;
      contrasena.value = "";
      error_msg.innerHTML = "";
      submitbtn.value = "Agregar"
      deletebtn.type = "hidden"; 
    }

    function seleccionarUsuario(id){
      limpiarFrmUsuario();
      var id_usuario = document.getElementById("t_id_usuario"+id).innerHTML;
      var usuario = document.getElementById("t_usuario"+id).innerHTML;
      var contrasena = document.getElementById("t_contrasena"+id).innerHTML;
      var tipo = document.getElementById("t_id_tipo"+id).value;

      document.getElementById("id_usuario").value = id_usuario;
      document.getElementById("nombre_usuario").value = usuario;
      document.getElementById("contrasena_usuario").value = contrasena;
      document.getElementById("tipo_usuario").value = tipo;

      document.getElementById("subFrmUsuario").value = "Editar";
      document.getElementById("delFrmUsuario").type = "submit";
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
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Administración de Usuarios</h3>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Usuario
              </header>
              <div class="panel-body">
                <div class="form">
                  <form class="form-validate form-horizontal" id="frmUsuario" onsubmit="return validarFrmUsuario();" method="post" action="">
                    <input type="hidden" id="id_usuario" name="id_usuario" value="0">
                    <div class="form-group ">
                      <label for="nombre_usuario" class="control-label col-lg-2">Usuario</span></label>
                      <div class="col-lg-10">
                        <input class="form-control" id="nombre_usuario" name="nombre_usuario" type="text"/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="cname" class="control-label col-lg-2">Tipo</span></label>
                      <div class="col-lg-10">
                        <select class="form-control m-bot15" id="tipo_usuario" name="tipo_usuario">
                            <?php
                            $sql = "select * from tipo";
                            //Funcion que retorna el resultado del query
                            $result = $database->executeQuery($sql);

                            //If para revisar si existen registros
                            if ($result->num_rows > 0) {
                              while($row = $result->fetch_assoc()) {
                                //Creo dinamicamente las opciones del input
                                ?>
                                  <option value="<?= $row["id_tipo"] ?>"><?= $row["nombre"] ?></option> 
                                <?php
                              }
                            }
                            ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="contrasena_usuario" class="control-label col-lg-2">Contraseña</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="contrasena_usuario" type="password" name="contrasena_usuario"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <input class="btn btn-primary" type="submit" name="subFrmUsuario" id="subFrmUsuario" value="Agregar">
                        <input class="btn btn-primary" type="hidden" name="delFrmUsuario" id="delFrmUsuario" value="Eliminar">
                        <input class="btn btn-default" type="button" onclick="limpiarFrmUsuario()" value="Cancelar">
                      </div>
                    </div>
                    <div class="col-lg-offset-2 col-lg-10">
                      <p style="color: red" id="error_frmUsuario"></p>
                    </div>
                  </form>
                </div>
                <?php
                if(isset($_POST["subFrmUsuario"]) && $_POST["subFrmUsuario"] == "Agregar"){
                  $usuario = $_POST["nombre_usuario"];
                  $contrasena = $_POST["contrasena_usuario"];
                  $id_tipo = $_POST["tipo_usuario"];

                  $sql = "select * from usuario where usuario = '".$usuario."'";
                  //Funcion que retorna el resultado del query
                  $result = $database->executeQuery($sql);

                  //If para revisar si existen registros
                  if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                      echo "<script>document.getElementById('error_frmUsuario').innerHTML = '* Un usuario con este nombre ya existe.'</script>";
                    }
                  }else{
                    $sql = "insert into usuario values (0, '".$usuario."', '".$contrasena."', CURRENT_DATE(),".$id_tipo.")";
                    if($database->executeNonQuery($sql)){
                      echo "<script>$('#panel').load('adm_usuario.php');</script>";
                    }
                    else{
                      echo "<script>document.getElementById('error_frmUsuario').innerHTML = '* Error al ingresar el usuario.'</script>"; 
                    }
                  }
                }
                else if(isset($_POST["subFrmUsuario"]) && $_POST["subFrmUsuario"] == "Editar"){
                  $id_usuario = $_POST["id_usuario"];
                  $usuario = $_POST["nombre_usuario"];
                  $contrasena = $_POST["contrasena_usuario"];
                  $id_tipo = $_POST["tipo_usuario"];

                  $sql = "select * from usuario where usuario = '".$usuario."'";
                  //Funcion que retorna el resultado del query
                  $result = $database->executeQuery($sql);

                  if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                      echo "<script>document.getElementById('error_frmUsuario').innerHTML = '* Un usuario con este nombre ya existe.'</script>";
                    }
                  }else{
                    $sql = "update usuario set usuario = '".$usuario."', contrasena = '".$contrasena."', id_tipo = '".$id_tipo."' where id_usuario ='".$id_usuario."'";
                    if($database->executeNonQuery($sql)){
                      echo "<script>$('#panel').load('adm_usuario.php');</script>";
                    }
                    else{
                      echo "<script>document.getElementById('error_frmUsuario').innerHTML = '* Error al editar el usuario.'</script>"; 
                    }
                  }
                }
                else if(isset($_POST["delFrmUsuario"]) && $_POST["delFrmUsuario"] == "Eliminar"){
                  $id_usuario = $_POST["id_usuario"];
                  $sql = "delete from usuario where id_usuario ='".$id_usuario."'";
                  if($database->executeNonQuery($sql)){
                    echo "<script>$('#panel').load('adm_usuario.php');</script>";
                  }
                  else{
                    echo "<script>document.getElementById('error_frmUsuario').innerHTML = '* Error al eliminar el usuario.'</script>"; 
                  }
                }
                ?>
              </div>
            </section>
          </div>
          <div class="col-lg-12">
            <section class="panel" id="panel">
              <header class="panel-heading">
                Usuarios
              </header>
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th></i># Id</th>
                    <th><i class="icon_profile"></i> Usuario</th>
                    <td> Contraseña</td>
                    <td> Tipo</td>
                    <th><i class="icon_calendar"></i> Fecha de Creacion</th>
                    <th><i class="icon_cogs"></i> Seleccionar</th>
                  </tr>
                  <?php
                  $sql = "select * from usuario as u 
                          inner join tipo as t
                          on u.id_tipo = t.id_tipo";
                  //Funcion que retorna el resultado del query
                  $result = $database->executeQuery($sql);
                  //If para revisar si existen registros
                  if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                      //Creo dinamicamente las opciones del input
                      ?>
                        <tr>
                          <td id="t_id_usuario<?= $row["id_usuario"] ?>"><?= $row["id_usuario"] ?></td>
                          <td id="t_usuario<?= $row["id_usuario"] ?>"><?= $row["usuario"] ?></td>
                          <td id="t_contrasena<?= $row["id_usuario"] ?>"><?= $row["contrasena"] ?></td>
                          <input type="hidden" id="t_id_tipo<?= $row["id_usuario"] ?>" value="<?= $row['id_tipo'] ?>">
                          <td><?= $row["nombre"] ?></td>
                          <td><?= $row["fecha_creacion"] ?></td>
                          <td>
                            <div class="btn-group">
                              <a class="btn btn-primary" onclick="seleccionarUsuario(<?= $row["id_usuario"] ?>)" href="#"><i class="icon_plus_alt2"></i></a>
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
