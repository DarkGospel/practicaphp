<?php

/**
 *   Clase 'modelo' que implementa el modelo de nuestra aplicación en una
 * arquitectura MVC. Se encarga de gestionar el acceso a la base de datos
 * en una capa especializada
 */
class modelo {

  //Atributo que contendrá la referencia a la base de datos 
  private $conexion;
  // Parámetros de conexión a la base de datos 
  private $host = "localhost";
  private $user = "root";
  private $pass = "";
  private $db = "practicaphp";

  /**
   * Constructor de la clase que ejecutará directamente el método 'conectar()'
   */
  public function __construct() {
    $this->conectar();
  }

  /**
   * Método que realiza la conexión a la base de datos de usuarios mediante PDO.
   * Devuelve TRUE si se realizó correctamente y FALSE en caso contrario.
   * @return boolean
   */
  public function conectar() {
    try {
      $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
      $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return TRUE;
    } catch (PDOException $ex) {
      return $ex->getMessage();
    }
  }

  /**
   * Función que nos permite conocer si estamos conectados o no a la base de datos.
   * Devuelve TRUE si se realizó correctamente y FALSE en caso contrario.
   * @return boolean
   */
  public function estaConectado() {
    if ($this->conexion) :
      return TRUE;
    else :
      return FALSE;
    endif;
  }
  /**
   * Funcion que realiza una busqueda del usuario que intenta acceder a la plataforma
   * si el usuario existe entrará en la página de inicio
   * si no existe mostrará el mensaje de que tiene que registrarse   
   * -'correcto': indica si la comprobación se realizó correctamente o no.
   * -'datos': almacena todos los datos obtenidos de la consulta.
   * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
   * @return type
      */
  public function existeUsuario($usuario) {
    try 
    {
        $sql = "SELECT * FROM usuarios WHERE nickname=:nombre";
        $procedimiento = "CALL logs('$usuario', 'administrador', 'inicio sesion')";
        $query = $this->conexion->prepare($sql);
        $query2 = $this->conexion->prepare($procedimiento);
        $query->execute(['nombre' => $usuario]);
        $query2->execute(['nombre' => $usuario,
            'perfil' => "administrador",
            'accion' => "Inicio de sesion"]);
        if(isset($query))
        {
            $resultado = $query->fetch(PDO::FETCH_ASSOC);
        }
        else
        {
            $resultado = false;
        }
    }
    catch(PDOException $ex)
    {
      $resultado = $ex->getMessage();
    }
    return $resultado;
  }
  
public function verlogs(){
    $return = [
        "correcto" => FALSE,
        "datos" => NULL,
        "error" => NULL
    ];
    //Realizamos la consulta...
    try {  //Definimos la instrucción SQL  
      $sql = "SELECT * FROM log";
      // Hacemos directamente la consulta al no tener parámetros
      $resultsquery = $this->conexion->query($sql);
      //Supervisamos si la inserción se realizó correctamente... 
      if ($resultsquery) :
        $return["correcto"] = TRUE;
        $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
      endif; // o no :(
    } catch (PDOException $ex) {
      $return["error"] = $ex->getMessage();
    }

    return $return;
}
  /**
   * Función que realiza el listado de todos los usuarios registrados
   * Devuelve un array asociativo con tres campos:
   * -'correcto': indica si el listado se realizó correctamente o no.
   * -'datos': almacena todos los datos obtenidos de la consulta.
   * -'error': almacena el mensaje asociado a una situación errónea (excepción) 
   * @return type
   */
  public function listado() {
    $return = [
        "correcto" => FALSE,
        "datos" => NULL,
        "error" => NULL
    ];
    //Realizamos la consulta...
    try {  //Definimos la instrucción SQL  
      $sql = "SELECT * FROM usuarios";
      // Hacemos directamente la consulta al no tener parámetros
      $resultsquery = $this->conexion->query($sql);
      //Supervisamos si la inserción se realizó correctamente... 
      if ($resultsquery) :
        $return["correcto"] = TRUE;
        $return["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
      endif; // o no :(
    } catch (PDOException $ex) {
      $return["error"] = $ex->getMessage();
    }

    return $return;
  }

  /**
   * Método que elimina el usuario cuyo id es el que se le pasa como parámetro 
   * @param $id es un valor numérico. Es el campo clave de la tabla
   * @return boolean
   */
  public function deluser($id) {
    // La función devuelve un array con dos valores:'correcto', que indica si la
    // operación se realizó correctamente, y 'mensaje', campo a través del cual le
    // mandamos a la vista el mensaje indicativo del resultado de la operación
    $return = [
        "correcto" => FALSE,
        "error" => NULL
    ];
    //Si hemos recibido el id y es un número realizamos el borrado...
    if ($id && is_numeric($id)) {
      try {
        //Inicializamos la transacción
        $this->conexion->beginTransaction();
        //Definimos la instrucción SQL parametrizada 
        $sql = "DELETE FROM usuarios WHERE id=:id";
        $query = $this->conexion->prepare($sql);
        $query->execute(['id' => $id]);
        //Supervisamos si la eliminación se realizó correctamente... 
        if ($query) {
          $this->conexion->commit();  // commit() confirma los cambios realizados durante la transacción
          $return["correcto"] = TRUE;
        }// o no :(
      } catch (PDOException $ex) {
        $this->conexion->rollback(); // rollback() se revierten los cambios realizados durante la transacción
        $return["error"] = $ex->getMessage();
      }
    } else {
      $return["correcto"] = FALSE;
    }

    return $return;
  }

  /**
   * 
   * @param type $datos
   * @return type
   */
  public function adduser($datos) {
    $return = [
        "correcto" => FALSE,
        "error" => NULL
    ];

    try {
      //Inicializamos la transacción
      $this->conexion->beginTransaction();
      //Definimos la instrucción SQL parametrizada 
      $sql = "INSERT INTO `usuarios`(`idUsuarios`, `NIF`, `nombre`, `apellido1`, `apellido2`, `imagen`, `nickname`, `password`, "
              . "`rol`, `telefonomov`, `telefonofijo`, `email`, `departamento`, `paginaweb`, `direccionblog`, `twitter`,"
              . " `activo`, `Fecha`, `Asignaturas`) "
              . "VALUES (NULL, :nif, :nombre, :apellido1, apellido2, :imagen,:nickname,:password, Profesor,:telefonomovil,:telefonofijo,"
              . ":email, :departamento,:paginaweb,:direccionblog,:twitter,0,SYSDATE(),'')";
      // Preparamos la consulta...
      $query = $this->conexion->prepare($sql);
      // y la ejecutamos indicando los valores que tendría cada parámetro
      $query->execute([
          'nif' => $datos["NIF"],
          'nombre' => $datos["nombre"],
          'apellido1'=> $datos["apellido1"],
          'apellido2'=> $datos["apellido2"],
          'imagen' => $datos["imagen"],
          'nickname' => $datos["nickname"],
          'password' => $datos["password"],
          'telefonomovil' => $datos["telefonomov"],
          'telefonofijo' => $datos["telefonofijo"],
          'email' => $datos["email"],
          'departamento' => $datos["departamento"],
          'paginaweb' => $datos["paginaweb"],
          'direccionblog' => $datos["direccionblog"],
          'twitter' => $datos["twitter"]
      ]); //Supervisamos si la inserción se realizó correctamente... 
      if ($query) {
        $this->conexion->commit(); // commit() confirma los cambios realizados durante la transacción
        $return["correcto"] = TRUE;
      }// o no :(
    } catch (PDOException $ex) {
      $this->conexion->rollback(); // rollback() se revierten los cambios realizados durante la transacción
      $return["error"] = $ex->getMessage();
      //die();
    }

    return $return;
  }

  public function actuser($datos) {
    $return = [
        "correcto" => FALSE,
        "error" => NULL
    ];

    try {
      //Inicializamos la transacción
      $this->conexion->beginTransaction();
      //Definimos la instrucción SQL parametrizada 
      $sql = "UPDATE usuarios SET nombre= :nombre, email= :email, imagen= :imagen WHERE id=:id";
      $query = $this->conexion->prepare($sql);
      $query->execute([
          'id' => $datos["id"],
          'nombre' => $datos["nombre"],
          'email' => $datos["email"],
          'imagen' => $datos["imagen"]
      ]);
      //Supervisamos si la inserción se realizó correctamente... 
      if ($query) {
        $this->conexion->commit();  // commit() confirma los cambios realizados durante la transacción
        $return["correcto"] = TRUE;
      }// o no :(
    } catch (PDOException $ex) {
      $this->conexion->rollback(); // rollback() se revierten los cambios realizados durante la transacción
      $return["error"] = $ex->getMessage();
      //die();
    }

    return $return;
  }

  public function listausuario($id) {
    $return = [
        "correcto" => FALSE,
        "datos" => NULL,
        "error" => NULL
    ];

    if ($id && is_numeric($id)) {
      try {
        $sql = "SELECT * FROM usuarios WHERE id=:id";
        $query = $this->conexion->prepare($sql);
        $query->execute(['id' => $id]);
        //Supervisamos que la consulta se realizó correctamente... 
        if ($query) {
          $return["correcto"] = TRUE;
          $return["datos"] = $query->fetch(PDO::FETCH_ASSOC);
        }// o no :(
      } catch (PDOException $ex) {
        $return["error"] = $ex->getMessage();
        //die();
      }
    }

    return $return;
  }

}