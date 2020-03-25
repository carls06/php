<?php  
error_reporting(0);
$carta="";
$nombre ="";

$correo ="";
//$telefono = $_POST['telefono'];
$mensaje = "";
$asunto = "";
if(isset($_POST['submit'])){
// Llamando a los campos
$nombre = $_POST['name'];
$correo = $_POST['email'];
//$telefono = $_POST['telefono'];
$mensaje = $_POST['message'];
$asunto = $_POST['subject'];
}
// Datos para el correo
$destinatario = "gc140244@gmail.com";


$carta = "De: $nombre \n";
$carta .= "Correo: $correo \n";
//$carta .= "Telefono: $telefono \n";
$carta .= "Mensaje: $mensaje";

// Enviando Mensaje
mail($destinatario, $asunto, $carta);


?>