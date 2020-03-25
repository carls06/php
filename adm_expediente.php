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
    function validarFrmExpediente(){
      var nombres = document.getElementById("nombres_expediente").value;
      var apellidos = document.getElementById("apellidos_expediente").value;
      var edad = document.getElementById("edad_expediente").value;
      var comentario = document.getElementById("comentario_expediente").value;
      var error_msg = document.getElementById("error_frmExpediente");

      var return_value = true;

      if(nombres === "" || apellidos === "" || edad === ""){
        error_msg.innerHTML = "* Por favor ingresar todos los parámetros.";
        return_value = false;
      }
      
      if(edad < 0){
      	error_msg.innerHTML+= "<br>* La edad tiene que ser mayor o igual a 0.";
      	return_value = false;
      }

      return return_value;
    }

    function limpiarFrmExpediente(){
      var id = document.getElementById("id_expediente");
      var nombres = document.getElementById("nombres_expediente");
      var apellidos = document.getElementById("apellidos_expediente");
      var edad = document.getElementById("edad_expediente");
      var comentario = document.getElementById("comentario_expediente");
      var error_msg = document.getElementById("error_frmExpediente");
      var submitbtn = document.getElementById("subFrmExpediente");     
      var deletebtn = document.getElementById("delFrmExpediente");
      var abrir_expedientebtn = document.getElementById("btnAbrirExpediente");
      

      id.value = "";
      nombres.value = "";
      apellidos.value = "";
      edad.value = "0";
      comentario.value = "";
      error_msg.innerHTML = "";
      submitbtn.value = "Agregar"
      deletebtn.type = "hidden"; 
      abrir_expedientebtn.type = "hidden";
    }

    function seleccionarUsuario(id){
      limpiarFrmExpediente();
      var id_expediente = document.getElementById("t_id_expediente"+id).innerHTML;
      var nombres = document.getElementById("t_nombres"+id).innerHTML;
      var apellidos = document.getElementById("t_apellidos"+id).innerHTML;
      var edad = document.getElementById("t_edad"+id).innerHTML;
      var comentario = document.getElementById("t_comentario"+id).value;

      document.getElementById("id_expediente").value = id_expediente;
      document.getElementById("nombres_expediente").value = nombres;
      document.getElementById("apellidos_expediente").value = apellidos;
      document.getElementById("edad_expediente").value = edad;
      document.getElementById("comentario_expediente").value = comentario;

      document.getElementById("subFrmExpediente").value = "Editar";
      document.getElementById("delFrmExpediente").type = "submit";
      document.getElementById("btnAbrirExpediente").type ="button"
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
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Administración de Expedientes</h3>
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
                  <form class="form-validate form-horizontal" id="frmExpediente" onsubmit="return validarFrmExpediente();" method="post" action="">
                    <input type="hidden" id="id_expediente" name="id_expediente" value="0">
                    <div class="form-group ">
                      <label for="nombre_usuario" class="control-label col-lg-2">Nombres</span></label>
                      <div class="col-lg-10">
                        <input class="form-control" id="nombres_expediente" name="nombres_expediente" type="text"/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="nombre_usuario" class="control-label col-lg-2">Apellidos</span></label>
                      <div class="col-lg-10">
                        <input class="form-control" id="apellidos_expediente" name="apellidos_expediente" type="text"/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="nombre_usuario" class="control-label col-lg-2">Edad</span></label>
                      <div class="col-lg-10">
                        <input class="form-control" id="edad_expediente" name="edad_expediente" type="number" value="0"/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="contrasena_usuario" class="control-label col-lg-2">Comentario</span></label>
                      <div class="col-lg-10">
                      	<textarea class="form-control" id="comentario_expediente" name="comentario_expediente" rows="4" maxlength="1000"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                      	<input class="btn btn-success" type="hidden" name="btnAbrirExpediente" id="btnAbrirExpediente" onclick="window.location.href = 'adm_visita.php?expediente='+document.getElementById('id_expediente').value;" value="Abrir Expediente">
                        <input class="btn btn-primary" type="submit" name="subFrmExpediente" id="subFrmExpediente" value="Agregar">
                        <input class="btn btn-danger" type="hidden" name="delFrmExpediente" id="delFrmExpediente" value="Eliminar">
                        <input class="btn btn-default" type="button" onclick="limpiarFrmExpediente()" value="Cancelar">
                      </div>
                    </div>
                    <div class="col-lg-offset-2 col-lg-10">
                      <p style="color: red" id="error_frmExpediente"></p>
                    </div>
                  </form>
                </div>
                <?php
                if(isset($_POST["subFrmExpediente"]) && $_POST["subFrmExpediente"] == "Agregar"){
                  $nombres = $_POST["nombres_expediente"];
                  $apellidos = $_POST["apellidos_expediente"];
                  $edad = $_POST["edad_expediente"];
                  $comentario = $_POST["comentario_expediente"];

	              $sql = "insert into expediente values (0,'".$nombres."','".$apellidos."','".$edad."',CURRENT_DATE(),'".$comentario."')";
    	          if($database->executeNonQuery($sql)){
                  	echo "<script>$('#panel').load('adm_expediente.php');</script>";
                  }
                  else{
                  	echo "<script>document.getElementById('error_frmExpediente').innerHTML = '* Error al ingresar el expediente.'</script>"; 
                  }
                  
                }
                else if(isset($_POST["subFrmExpediente"]) && $_POST["subFrmExpediente"] == "Editar"){
                  $id_expediente = $_POST["id_expediente"];
                  $nombres = $_POST["nombres_expediente"];
                  $apellidos = $_POST["apellidos_expediente"];
                  $edad = $_POST["edad_expediente"];
                  $comentario = $_POST["comentario_expediente"];

                  $sql = "update expediente set nombres = '".$nombres."', apellidos = '".$apellidos."', edad = '".$edad."', comentario = '".$comentario."' where id_expediente = '".$id_expediente."'";

                  //$sql = "update usuario set usuario = '".$usuario."', contrasena = '".$contrasena."', id_tipo = '".$id_tipo."' where id_usuario ='".$id_usuario."'";
                  if($database->executeNonQuery($sql)){
                    echo "<script>$('#panel').load('adm_expediente.php');</script>";
                  }
                  else{
                    echo "<script>document.getElementById('error_frmExpediente').innerHTML = '* Error al editar el expediente.'</script>"; 
                  }
                }
                else if(isset($_POST["delFrmExpediente"]) && $_POST["delFrmExpediente"] == "Eliminar"){
                  $id_expediente = $_POST["id_expediente"];
                  $sql = "delete from expediente where id_expediente = '".$id_expediente."'";
                  if($database->executeNonQuery($sql)){
                    echo "<script>$('#panel').load('adm_expediente.php');</script>";
                  }
                  else{
                    echo "<script>document.getElementById('error_frmUsuario').innerHTML = '* Error al eliminar el expediente.'</script>"; 
                  }
                }
                ?>
              </div>
            </section>
          </div>
          <div class="col-lg-12">
            <section class="panel" id="panel">
              <header class="panel-heading">
                Expedientes
              </header>
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th></i># Id</th>
                    <th><i class="icon_profile"></i> Nombres</th>
                    <td> Apellidos</td>
                    <td> Edad</td>
                    <th><i class="icon_calendar"></i> Fecha de Creacion</th>
                    <th><i class="icon_cogs"></i> Seleccionar</th>
                  </tr>
                  <?php
                  $sql = "select * from expediente";
                  //Funcion que retorna el resultado del query
                  $result = $database->executeQuery($sql);
                  //If para revisar si existen registros
                  if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                      //Creo dinamicamente las opciones del input
                      ?>
                        <tr>
                          <td id="t_id_expediente<?= $row["id_expediente"] ?>"><?= $row["id_expediente"] ?></td>
                          <td id="t_nombres<?= $row["id_expediente"] ?>"><?= $row["nombres"] ?></td>
                          <td id="t_apellidos<?= $row["id_expediente"] ?>"><?= $row["apellidos"] ?></td>
                          <td id="t_edad<?= $row["id_expediente"] ?>"><?= $row["edad"] ?></td>
                          <td><?= $row["fecha_creacion"] ?></td>
                          <input type="hidden" id="t_comentario<?= $row["id_expediente"] ?>" value="<?= $row["comentario"] ?>">
                          <td>
                            <div class="btn-group">
                              <a class="btn btn-primary" onclick="seleccionarUsuario(<?= $row["id_expediente"] ?>)" href="#"><i class="icon_plus_alt2"></i></a>
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
