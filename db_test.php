<?php
require "class/class.database.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
</head>
<body>
    <?php 
        //Objeto para creacion de conexion
        $database = new database();
        //If para probar conexion
        if($database->testConnection()){
            echo "SI";
            $sql = "";
            //Funcion para correr querries (selects)
            $database->executeQuery($sql);
            //Funcion para correr no querries (inserts, updates, etc..)
            $database->executeNonQuery($sql);
        }
        else{
            echo "NO";
        }
        //Funcion para cerrar conexion
        $database->closeConnection();
    ?>
</body>

</html>