<?php 
  require "php/error_handler.php";
  require "class/class.database.php";
  session_start();

  //If para revisar si sesion de usuario existe
  if(isset($_SESSION['usuario'])){
    //Redirecciona a pagina de panel de control
    header("Location: cpanel.php");
    exit();
  }

  $database = new database();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Parroquia Santa Catarina</title>
  <link rel="icon" href="img/logo_vertical_black.png">

  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-grid.css">
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-reboot.css">
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" type="text/css" href="css/style_ingresar.css">

  <style>
    .error_msg{
      color: red;
      text-align: left;
    }
  </style>
  <script>
    function validarFormulario(){
      var usuario = document.getElementById("usuario").value;
      var contrasena = document.getElementById("contrasena").value;
      var error_msg = document.getElementById("error");

      if(usuario === "" || contrasena === ""){
        error_msg.innerHTML = "* Por favor ingresar un usuario y una contraseña.";
        return false;
      }
    }

    function mostrarErrorLogin(){
      var error_msg = document.getElementById("error");      
      error_msg.innerHTML = "* El usuario o contraseña es incorrecta.";
    }
  </script>
</head>
<body class="text-center" id="body">
  <form class="form-signin" action="" method="post" onsubmit="return validarFormulario()">
    <img class="mb-4" src="img/logo_horizontal_black.png" width="100%">
    <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuario" autofocus>
    <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="Contraseña">
    <input class="btn btn-lg btn-primary btn-block" type="submit" name="frmLogin" value="Ingresar">
    <a href="index.php">Regresar</a>
    <p class="error_msg" id="error">
    </p>
  </form>
  <?php
  if(isset($_POST["frmLogin"]) && $_POST["frmLogin"] == "Ingresar"){
    //Variables de usuario y contrasena
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];

    //Linea de SQL para querry
    $sql = "select * from usuario where usuario='".$usuario."' and contrasena='".$contrasena."'";
    //Funcion que retorna el resultado del query
    $result = $database->executeQuery($sql);

    //If para revisar si existen registros
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        //Crea sesion con usuario
        $_SESSION['usuario'] = $row["id_usuario"];
        header("Location: cpanel.php");
        exit();
      }
    }
    else{
      ?>
      <script>mostrarErrorLogin();</script>
      <?php
    }
  
  }
  ?>

  <script src="bootstrap/bootstrap.bundle.js"></script>
  <script src="bootstrap/bootstrap.bundle.min.js"></script>
  <script src="bootstrap/bootstrap.js"></script>
  <script src="bootstrap/bootstrap.min.js"></script>
</body>

</html>
<?php 
$database->closeConnection();
?>
