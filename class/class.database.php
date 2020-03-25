<?php
class database {
  // Atributos
  private $a_servername = "localhost";
  private $a_username = "root@localhost";
  private $a_password = "";
  private $a_database = "db_santacatarina";
  private $a_connection;

  //Constructor de objeto
  function __construct() {
    $this->createConnection();
  }

  //Metodos de getters y setters
  function get_servername() {return $this->a_servername;}
  function get_username() {return $this->a_username;}
  function get_password() {return $this->a_password;}
  function get_database() {return $this->a_database;}
  function get_connection() {return $this->a_connection;}
  
  //Metodo para crear conexion
  function createConnection(){
    $servername = $this->get_servername();
    $username = $this->get_username();
    $password = $this->get_password();
    $database = $this->get_database();

    //Creacion de conexion
    $connection = new mysqli($servername, $username, $password, $database);
    //Se modifica conexion para formato utf-8 para aceptar tilder y otros simbolos
    mysqli_set_charset($connection, "utf8");

    //Revisa conexion y el atributo a_connection es null si la conexion NO es exitosa
    if ($connection->connect_error) {
        $this->a_connection = null;
    }
    else{
      //El atributo a_connection es igual a la conexion creada si la conexion fue exitosa
      $this->a_connection = $connection;
    }
  }

  //Metodo para probar conexion
  function testConnection(){
    $connection = $this->get_connection();

    // Prueba conexion y retorna false si NO es valida
    if ($connection->connect_error) {
        return false;
    }

    //Retorna true si la conexion es valida
    return true;
  }

  //Metodo para cerrar conexion
  function closeConnection(){
    $connection = $this->get_connection();
    if($connection != null){
      $connection->close();
    }
  }

  //Metodo para correr un Querries y No Querries
  function executeQuery($p_sql){
    $connection = $this->get_connection();
    $result = $connection->query($p_sql);

    return $result;
  }

  function executeNonQuery($p_sql){
    $connection = $this->get_connection();
    if ($connection->query($p_sql) === TRUE) {
        return true;
    } else {
        return false;
    }
  }
}
?>