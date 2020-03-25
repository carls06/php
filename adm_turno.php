<?php 
  require "php/error_handler.php";
  require "class/class.database.php";
  session_start();
  $database = new database();
  //If para revisar si sesion de usuario existe
  if(!isset($_SESSION['usuario'])){
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
  <link href="css/bootstrap-datepicker.css" rel="stylesheet" />
  <!-- font icon -->
  <link href="css_cpanel/elegant-icons-style.css" rel="stylesheet" />
  <link href="css_cpanel/font-awesome.min.css" rel="stylesheet" />
  <!-- Custom styles -->
  <link href="css_cpanel/style.css" rel="stylesheet">
  <link href="css_cpanel/style-responsive.css" rel="stylesheet" />
  <script>
    function validarFrmTurno(){
      var usuario = document.getElementById("id_usuario").value;
      var fecha = document.getElementById("dp1").value;
      var hora_inicial = document.getElementById("hora_incial").value;
      var hora_final = document.getElementById("hora_final").value;
      var error_msg = document.getElementById("error_frmUsuario");

      if(usuario === "" || fecha === "" || hora_inicial === "" || hora_final === ""){
        error_msg.innerHTML = "* Por favor ingresar todos los parámetros.";
        return false;
      }
    }

    function limpiarFrmTurno(){
      var usuario = document.getElementById("usuario");
      var fecha = document.getElementById("dp1");
      var hora_incial = document.getElementById("hora_incial");
      var hora_final = document.getElementById("hora_final");
      var error_msg = document.getElementById("error_frmTurno");
      var submitbtn = document.getElementById("subFrmTurno");
      var deletebtn = document.getElementById("delFrmTurno");

      fecha.value = "";
      usuario.selectedIndex = 0;
      hora_incial.value = "";
      hora_final.value = "";
      submitbtn.value = "Agregar"
      deletebtn.type = "hidden"; 
    }

    function seleccionarTurno(id, idUser){
      limpiarFrmTurno();

      var id_turno = document.getElementById("t_id_turno"+id).innerHTML;
      var usuario = idUser;
      var fecha = document.getElementById("t_fecha"+id).innerHTML;
      var hora_inicial = document.getElementById("t_hora_inicial"+id).innerHTML;
      var hora_final = document.getElementById("t_hora_final"+id).innerHTML;
      
      document.getElementById("id_turno_h").value = id_turno;
      document.getElementById("usuario").value = usuario;
      document.getElementById("dp1").value = fecha;
      document.getElementById("hora_incial").value = hora_inicial;
      document.getElementById("hora_final").value = hora_final;

      document.getElementById("subFrmTurno").value = "Editar";
      document.getElementById("delFrmTurno").type = "submit";
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
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Administración de Turnos</h3>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
          <div class="col-lg-12">
            <section class="panel">
              <header class="panel-heading">
                Turno
              </header>
              <div class="panel-body">
                <div class="form">
                  <form class="form-validate form-horizontal" id="frmUsuario" onsubmit="return validarFrmTurno();" method="post" action="">
                    <input type="hidden" id="id_usuario" name="id_usuario" value="0">
                    <div class="form-group ">
                      <label for="usuario" class="control-label col-lg-2">Usuario</span></label>
                      <div class="col-lg-10">
                        <select class="form-control m-bot15" id="usuario" name="usuario">
                            <?php
                            $sql = "select * from usuario";
                            //Funcion que retorna el resultado del query
                            $result = $database->executeQuery($sql);

                            //If para revisar si existen registros
                            if ($result->num_rows > 0) {
                              while($row = $result->fetch_assoc()) {
                                //Creo dinamicamente las opciones del input
                                ?>
                                  <option value="<?= $row["id_usuario"] ?>"><?= $row["usuario"] ?></option> 
                                <?php
                              }
                            }
                            ?>
                        </select>
                      </div>
                    </div>
                    <input class="form-control " style="display: none" id="id_turno_h" type="text" name="id_turno_h" hidden readonly/>
                    <div class="form-group ">
                      <label for="cname" class="control-label col-lg-2">Fecha</span></label>
                      <div class="col-lg-10">
                        <input id="dp1" name="dp1"type="date" value="28-10-2013" size="16" class="form-control">
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="hora_incial" class="control-label col-lg-2">Hora incial</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="hora_incial" type="time" name="hora_incial"/>
                      </div>
                    </div>
                    <div class="form-group ">
                      <label for="hora_final" class="control-label col-lg-2">Hora final</span></label>
                      <div class="col-lg-10">
                        <input class="form-control " id="hora_final" type="time" name="hora_final"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                        <input class="btn btn-primary" type="submit" name="subFrmTurno" id="subFrmTurno" value="Agregar">
                        <input class="btn btn-primary" type="hidden" name="delFrmTurno" id="delFrmTurno" value="Eliminar">
                        <input class="btn btn-default" type="button" onclick="limpiarFrmTurno()" value="Cancelar">
                      </div>
                    </div>
                    <div class="col-lg-offset-2 col-lg-10">
                      <p style="color: red" id="error_frmUsuario"></p>
                    </div>
                  </form>
                </div>


                <?php
                if(isset($_POST["subFrmTurno"]) && $_POST["subFrmTurno"] == "Agregar"){
                  $id_turno = $_POST["id_turno_h"];
                  $id_usuario = $_POST["usuario"];
                  $fecha = $_POST["dp1"];
                  $fecha = strtotime($fecha);
                  $fecha = date('Y-m-d',$fecha);
                  $hora_incial = $_POST["hora_incial"];
                  $hora_final = $_POST["hora_final"];
                  $sql = "insert into turno values (0, '".$id_usuario."', '".$fecha."', '".$hora_incial."', '".$hora_final."')";
                    if($database->executeNonQuery($sql)){
                      echo "<script>$('#panel').load('adm_turnos.php');</script>";
                    }
                    else{
                      echo "<script>document.getElementById('error_frmTurno').innerHTML = '* Error al ingresar el turno.'</script>"; 
                    }
                }
                else if(isset($_POST["subFrmTurno"]) && $_POST["subFrmTurno"] == "Editar"){
                  $id_turno = $_POST["id_turno_h"];
                  $fecha = $_POST["dp1"];
                  $fecha = strtotime($fecha);
                  $fecha = date('Y-m-d',$fecha);
                  $hora_incial = $_POST["hora_incial"];
                  $hora_final = $_POST["hora_final"];
                  echo $id_turno;                 
                  $sql = "update turno set fecha = '".$fecha."', hora_inicial = '".$hora_incial."', hora_final = '".$hora_final."' where id_turno ='".$id_turno."'";
                  if($database->executeNonQuery($sql)){
                    echo "<script>$('#panel').load('adm_turnos.php');</script>";
                  }
                  else{
                    echo "<script>document.getElementById('error_frmTurno').innerHTML = '* Error al editar el turno.'</script>"; 
                  }  
                }
                else if(isset($_POST["delFrmTurno"]) && $_POST["delFrmTurno"] == "Eliminar"){
                  $id_turno = $_POST["id_turno_h"];
                  $sql = "delete from turno where id_turno ='".$id_turno."'";
                  if($database->executeNonQuery($sql)){
                    echo "<script>$('#panel').load('adm_turnos.php');</script>";
                  }
                  else{
                    echo "<script>document.getElementById('error_frmTurno').innerHTML = '* Error al eliminar el turno.'</script>"; 
                  }
                }

                ?>
              </div>


            </section>
          </div>
          <div class="col-lg-12">
            <section class="panel" id="panel">
              <header class="panel-heading">
                Turnos
              </header>
              <table class="table table-striped table-advance table-hover">
                <tbody>
                  <tr>
                    <th></i># Id</th>
                    <th><i class="icon_profile"></i> Usuario</th>
                    <td><i class="icon_calendar"></i> Fecha</td>
                    <td> Hora inicial</td>
                    <th> Hora final</th>
                    <th><i class="icon_cogs"></i> Seleccionar</th>
                  </tr>
                  <?php
                  $sql = "select T.id_turno, T.id_usuario, U.usuario, T.fecha, T.hora_inicial, T.hora_final
                          from turno T
                          inner join usuario U on T.id_usuario = U.id_usuario";
                  //Funcion que retorna el resultado del query
                  $result = $database->executeQuery($sql);
                  //If para revisar si existen registros
                  if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                      //Creo dinamicamente las opciones del input
                      ?>
                        <tr>
                          <td id="t_id_turno<?= $row["id_turno"] ?>"><?= $row["id_turno"] ?></td>
                          <td id="t_id_usuario<?= $row["id_turno"] ?>"><?= $row["usuario"] ?></td>
                          <td id="t_fecha<?= $row["id_turno"]?>"><?= $row["fecha"]?></td>
                          <td id="t_hora_inicial<?= $row["id_turno"] ?>"><?= $row["hora_inicial"] ?></td>
                          <td id="t_hora_final<?= $row["id_turno"] ?>"><?= $row["hora_final"] ?></td>
                          <td>
                            <div class="btn-group">
                            <a class="btn btn-primary" onclick="seleccionarTurno(<?= $row['id_turno'] ?>, <?= $row['id_usuario'] ?>)" href="#"><i class="icon_plus_alt2"></i></a>
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
  <script src="js/daterangepicker.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>


</body>

</html>
<?php 
$database->closeConnection();
?>
