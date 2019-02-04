<?php

/**
 * Incluimos el modelo para poder acceder a su clase y a los métodos que implementa
 */
require_once 'modelos/modelo.php';
require_once'vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

/**
 * Clase controlador que será la encargada de obtener, para cada tarea, los datos
 * necesarios de la base de datos, y posteriormente, tras su proceso de elaboración,
 * enviarlos a la vista para su visualización
 */
class controlador {

  // El el atributo $modelo es de la 'clase modelo' y será a través del que podremos 
  // acceder a los datos y las operaciones de la base de datos desde el controlador
  private $modelo;
  //$mensajes se utiliza para almacenar los mensajes generados en las tareas, 
  //que serán posteriormente transmitidos a la vista para su visualización
  private $mensajes;

  /**
   * Constructor que crea automáticamente un objeto modelo en el controlador e
   * inicializa los mensajes a vacío
   */
  public function __construct() {
    $this->modelo = new modelo();
    $this->mensajes = [];
  }

  /**
   * Método que envía al usuario a la página de inicio del sitio y le asigna 
   * el título de manera dinámica
   */
  public function header() {
    $parametros = [
        "tituloventana" => "header"
    ];
    //Mostramos la página de inicio 
    include_once 'vistas/includes/headerlogin.php';
  }
  public function index() {
    $parametros = [
        "tituloventana" => "Acceder"
    ];
    $this->header();
    //Mostramos la página de inicio 
    include_once 'vistas/Login.php';
  }
  public function login(){
  require_once 'vistas/includes/headerlogin.php';
  require_once 'vistas/Login.php';
  }
  public function inicio(){
      $parametros = [
        "tituloventana" => "Moodle"
        ];
    //Mostramos la página de inicio 
    require_once 'vistas/includes/header.php';
    require_once 'vistas/inicio.php';
  }

  public function login_enviar(){
  if($_POST)
  {
      $nombre = $_POST["nombre"];
      $password = sha1($_POST["contrasena"]);
      
      $resultado = $this->modelo->existeUsuario($nombre);
      if($resultado != false)
      {
          if($resultado["activo"] == "1"){
            if($resultado["password"] == $password )
            {
                $_SESSION["login"] = $resultado;
                $_SESSION["usuario"] = $nombre;
                $_SESSION["rol"] = $resultado["rol"];
                $_SESSION["id"] = $resultado["idUsuarios"];
                header('Location: index.php?action=inicio');
            }
            else
            {
                $_SESSION["error"] = "Usuario o contraseña incorrecta";
                header('Location: index.php?action=login');
            }
          }else{
              $_SESSION["error"] = "El usuario no esta activado";
                header('Location: index.php?action=login');
          }
      }else{
          $_SESSION["error"] = "Usuario o contraseña incorrecta";
              header('Location: index.php?action=login');
      }
  }
  }
  
  public function logout() {
      $nombre = $_SESSION["usuario"];
      $rol = $_SESSION["rol"];
      $resultado = $this->modelo->verificarlogs($nombre, $rol, "Cierre Sesion");
      session_destroy();
      header('Location: index.php?action=login');
  }
  public function verlogs(){
      $parametros = [
        "tituloventana" => "Moodle",
        "registros" => NULL,
        "paginas" => NULL,
        "datos" => NULL,
        "mensajes" => []
    ];
        //Establecemos el número de registroa a mostrar por página,por defecto 5
    $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:5;
    //Establecemos el la página que vamos a mostrar, por página,por defecto la 1
    $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
    // Realizamos la consulta y almacenmos los resultados en la variable $resultModelo
    $resultModelo = $this->modelo->verlogs($regsxpag, $pagina);
    // Si la consulta se realizó correctamente transferimos los datos obtenidos
    // de la consulta del modelo ($resultModelo["datos"]) a nuestro array parámetros
    // ($parametros["datos"]), que será el que le pasaremos a la vista para visualizarlos
    if ($resultModelo["correcto"]) :
      $parametros["datos"] = $resultModelo["datos"];
      $parametros["registros"] = $resultModelo["registros"];
      $parametros["paginas"] = $resultModelo["paginas"];
      //Definimos el mensaje para el alert de la vista de que todo fue correctamente
      $this->mensajes[] = [
          "tipo" => "success",
          "mensaje" => "El listado se realizó correctamente"
      ];
    else :
      //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
      $this->mensajes[] = [
          "tipo" => "danger",
          "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
      ];
    endif;
    //Asignanis al campo 'mensajes' del array de parámetros el valor del atributo 
    //'mensaje', que recoge cómo finalizó la operación:
    $parametros["mensajes"] = $this->mensajes;
    // Incluimos la vista en la que visualizaremos los datos o un mensaje de error
    include_once 'vistas/includes/header.php';
    include_once 'vistas/includes/navbar.php';
    include_once 'vistas/logs.php';
  }
  
    /**
   * Método que obtiene de la base de datos el listado de usuarios y envía dicha
   * infomación a la vista correspondiente para su visualización
   */
  public function listado() {
      $parametros = [
        "tituloventana" => "Moodle",
        "registros" => NULL,
        "paginas" => NULL,
        "datos" => NULL,
        "mensajes" => []
    ];
        //Establecemos el número de registroa a mostrar por página,por defecto 5
    $regsxpag = (isset($_GET['regsxpag']))? (int)$_GET['regsxpag']:5;
    //Establecemos el la página que vamos a mostrar, por página,por defecto la 1
    $pagina = (isset($_GET['pagina']))? (int)$_GET['pagina']:1;
    // Realizamos la consulta y almacenmos los resultados en la variable $resultModelo
    $resultModelo = $this->modelo->listado($regsxpag, $pagina);
    // Si la consulta se realizó correctamente transferimos los datos obtenidos
    // de la consulta del modelo ($resultModelo["datos"]) a nuestro array parámetros
    // ($parametros["datos"]), que será el que le pasaremos a la vista para visualizarlos
    if ($resultModelo["correcto"]) :
      $parametros["datos"] = $resultModelo["datos"];
      $parametros["registros"] = $resultModelo["registros"];
      $parametros["paginas"] = $resultModelo["paginas"];
      //Definimos el mensaje para el alert de la vista de que todo fue correctamente
      $this->mensajes[] = [
          "tipo" => "success",
          "mensaje" => "El listado se realizó correctamente"
      ];
    else :
      //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
      $this->mensajes[] = [
          "tipo" => "danger",
          "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})"
      ];
    endif;
    //Asignanis al campo 'mensajes' del array de parámetros el valor del atributo 
    //'mensaje', que recoge cómo finalizó la operación:
    $parametros["mensajes"] = $this->mensajes;
    // Incluimos la vista en la que visualizaremos los datos o un mensaje de error
    include_once 'vistas/listado.php';
  }

  /**
   * Método de la clase controlador que realiza la eliminación de un usuario a 
   * través del campo id
   */
  public function deluser() {
    // verificamos que hemos recibido los parámetros desde la vista de listado 
    if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
      $id = $_GET["id"];
      //Realizamos la operación de suprimir el usuario con el id=$id
      $resultModelo = $this->modelo->deluser($id);
      //Analizamos el valor devuelto por el modelo para definir el mensaje a 
      //mostrar en la vista listado
      if ($resultModelo["correcto"]) :
            $nombre = $_SESSION["usuario"];
            $rol = $_SESSION["rol"];
            $resultado = $this->modelo->verificarlogs($nombre, $rol, "Elimino usuario");
        $this->mensajes[] = [
            "tipo" => "success",
            "mensaje" => "Se eliminó correctamente el usuario $id"
        ];
      else :
        $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "La eliminación del usuario no se realizó correctamente!! :( <br/>({$resultModelo["error"]})"
        ];
      endif;
    } else { //Si no recibimos el valor del parámetro $id generamos el mensaje indicativo:
      $this->mensajes[] = [
          "tipo" => "danger",
          "mensaje" => "No se pudo acceder al id del usuario a eliminar!! :("
      ];
    }
    //Relizamos el listado de los usuarios
    $this->listado();
  }
    /**
   * Método de la clase controlador que realiza la introduccion de un usuario a 
   * la base de datos
   */
  public function adduser() {
    // Array asociativo que almacenará los mensajes de error que se generen por cada campo
    $errores = array();
// Si se ha pulsado el botón guardar...
    if (isset($_POST) && !empty($_POST) && isset($_POST['submit'])) { // y hermos recibido las variables del formulario y éstas no están vacías...
      $nombre = $_POST['txtnombre'];
      $nickname = $_POST['txtnick'];
      $password = sha1($_POST['txtpass']);
      $email = $_POST['txtemail'];
      /* Realizamos la carga de la imagen en el servidor */
//       Comprobamos que el campo tmp_name tiene un valor asignado para asegurar que hemos
//       recibido la imagen correctamente
//       Definimos la variable $imagen que almacenará el nombre de imagen 
//       que almacenará la Base de Datos inicializada a NULL
      $imagen = NULL;

      if (isset($_FILES["imagen"]) && (!empty($_FILES["imagen"]["tmp_name"]))) {
        // Verificamos la carga de la imagen
        // Comprobamos si existe el directorio fotos, y si no, lo creamos
        if (!is_dir("fotos")) {
          $dir = mkdir("fotos", 0777, true);
        } else {
          $dir = true;
        }
        // Ya verificado que la carpeta uploads existe movemos el fichero seleccionado a dicha carpeta
        if ($dir) {
          //Para asegurarnos que el nombre va a ser único...
          $nombrefichimg = time() . "-" . $_FILES["imagen"]["name"];
          // Movemos el fichero de la carpeta temportal a la nuestra
          $movfichimg = move_uploaded_file($_FILES["imagen"]["tmp_name"], "fotos/" . $nombrefichimg);
          $imagen = $nombrefichimg;
          // Verficamos que la carga se ha realizado correctamente
          if ($movfichimg) {
            $imagencargada = true;
          } else {
            $imagencargada = false;
            $this->mensajes[] = [
                "tipo" => "danger",
                "mensaje" => "Error: La imagen no se cargó correctamente! :("
            ];
            $errores["imagen"] = "Error: La imagen no se cargó correctamente! :(";
          }
        }
      }
      // Si no se han producido errores realizamos el registro del usuario
      if (count($errores) == 0) {
            $nombre = $_SESSION["usuario"];
            $rol = $_SESSION["rol"];
            $resultado = $this->modelo->verificarlogs($nombre, $rol, "Añadió usuario");
        $resultModelo = $this->modelo->adduser([
            'nombre' => $nombre,
            'nickname' => $nickname,
            "password" => $password,
            'email' => $email,
            'imagen' => $imagen
        ]);
        if ($resultModelo["correcto"]) :
          $this->mensajes[] = [
              "tipo" => "success",
              "mensaje" => "El usuarios se registró correctamente!! :)"
          ];
        else :
          $this->mensajes[] = [
              "tipo" => "danger",
              "mensaje" => "El usuario no pudo registrarse!! :( <br />({$resultModelo["error"]})"
          ];
        endif;
      } else {
        $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "Datos de registro de usuario erróneos!! :("
        ];
      }
    }

    $parametros = [
        "tituloventana" => "Base de Datos con PHP y PDO",
        "datos" => [
            "txtnombre" => isset($nombre) ? $nombre : "",
            "txtnick" => isset($nickname) ? $nickname : "",
            "txtpass" => isset($password) ? $password : "",
            "txtemail" => isset($email) ? $email : "",
            "imagen" => isset($imagen) ? $imagen : ""
        ],
        "mensajes" => $this->mensajes
    ];
    //Visualizamos la vista asociada al registro de usuarios
    include_once 'vistas/adduser.php';
  
  }

  /**
   * Método de la clase controlador que permite actualizar los datos del usuario
   * cuyo id coincide con el que se pasa como parámetro desde la vista de listado
   * a través de GET
   */
  public function actuser() {
// Array asociativo que almacenará los mensajes de error que se generen por cada campo
    $errores = array();
// Inicializamos valores de los campos de texto
    $nif = "";
    $valnombre = "";
    $valemail = "";
    $valimagen = "";
    $valapellido1 = "";
    $valapellido2 = "";

// Si se ha pulsado el botón actualizar...
    if (isset($_POST['submit'])) { //Realizamos la actualización con los datos existentes en los campos
      $nuevonif  = $_POST["NIF"];
      $id = $_POST['id']; //Lo recibimos por el campo oculto
      $nuevonombre = $_POST['nombre'];
      $nuevoemail  = $_POST['email'];
      $nuevoapellido1 = $_POST['apellido1'];
      $nuevoapellido2 = $_POST['apellido2'];
      $nuevaimagen = "";

      // Definimos la variable $imagen que almacenará el nombre de imagen 
      // que almacenará la Base de Datos inicializada a NULL
      $imagen = NULL;

      if (isset($_FILES["imagen"]) && (!empty($_FILES["imagen"]["tmp_name"]))) {
        // Verificamos la carga de la imagen
        // Comprobamos si existe el directorio fotos, y si no, lo creamos
        if (!is_dir("fotos")) {
          $dir = mkdir("fotos", 0777, true);
        } else {
          $dir = true;
        }
        // Ya verificado que la carpeta fotos existe movemos el fichero seleccionado a dicha carpeta
        if ($dir) {
          //Para asegurarnos que el nombre va a ser único...
          $nombrefichimg = time() . "-" . $_FILES["imagen"]["name"];
          // Movemos el fichero de la carpeta temportal a la nuestra
          $movfichimg = move_uploaded_file($_FILES["imagen"]["tmp_name"], "fotos/" . $nombrefichimg);
          $imagen = $nombrefichimg;
          // Verficamos que la carga se ha realizado correctamente
          if ($movfichimg) {
            $imagencargada = true;
          } else {
            //Si no pudo moverse a la carpeta destino generamos un mensaje que se le
            //mostrará al usuario en la vista actuser
            $imagencargada = false;
            $errores["imagen"] = "Error: La imagen no se cargó correctamente! :(";
            $this->mensajes[] = [
                "tipo" => "danger",
                "mensaje" => "Error: La imagen no se cargó correctamente! :("
            ];
          }
        }
      }
      $nuevaimagen = $imagen;

      if (count($errores) == 0) {
            $nombre = $_SESSION["usuario"];
            $rol = $_SESSION["rol"];
            $resultado = $this->modelo->verificarlogs($nombre, $rol, "Edito usuario");
        //Ejecutamos la instrucción de actualización a la que le pasamos los valores
        $resultModelo = $this->modelo->actuser([
            'id' => $id,
            'NIF' => $nuevonif,
            'nombre' => $nuevonombre,
            'apellido1' => $nuevoapellido1,
            'apellido2' => $nuevoapellido2,
            'imagen' => $nuevaimagen,
            'email' => $nuevoemail
                ]);
        //Analizamos cómo finalizó la operación de registro y generamos un mensaje
        //indicativo del estado correspondiente
        if ($resultModelo["correcto"]) :
          $this->mensajes[] = [
              "tipo" => "success",
              "mensaje" => "El usuario se actualizó correctamente!! :)"
          ];
        else :
          $this->mensajes[] = [
              "tipo" => "danger",
              "mensaje" => "El usuario no pudo actualizarse!! :( <br/>({$resultModelo["error"]})"
          ];
        endif;
      } else {
        $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "Datos de registro de usuario erróneos!! :("
        ];
      }

      // Obtenemos los valores para mostrarlos en los campos del formulario
      $nif = $nuevonif;
      $valnombre = $nuevonombre;
      $valapellido1 = $nuevoapellido1;
      $valapellido2 = $nuevoapellido2;
      $valemail  = $nuevoemail;
      $valimagen = $nuevaimagen;
    } else { //Estamos rellenando los campos con los valores recibidos del listado
      if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
        $id = $_GET['id'];
        //Ejecutamos la consulta para obtener los datos del usuario #id
        $resultModelo = $this->modelo->listausuario($id);
        //Analizamos si la consulta se realiz´correctamente o no y generamos un
        //mensaje indicativo
        if ($resultModelo["correcto"]) :
          $this->mensajes[] = [
              "tipo" => "success",
              "mensaje" => "Los datos del usuario se obtuvieron correctamente!! :)"
          ];
          $nif = $resultModelo["datos"]["NIF"];
          $valnombre = $resultModelo["datos"]["nombre"];
          $valapellido1 = $resultModelo["datos"]["apellido1"];
          $valapellido2 = $resultModelo['datos']["apellido2"];
          $valemail  = $resultModelo["datos"]["email"];
          $valimagen = $resultModelo["datos"]["imagen"];
        else :
          $this->mensajes[] = [
              "tipo" => "danger",
              "mensaje" => "No se pudieron obtener los datos de usuario!! :( <br/>({$resultModelo["error"]})"
          ];
        endif;
      }
    }
    //Preparamos un array con todos los valores que tendremos que rellenar en
    //la vista adduser: título de la página y campos del formulario
    $parametros = [
        "tituloventana" => "Moodle",
        "datos" => [
            "NIF" => $nif,
            "nombre" => $valnombre,
            "apellido1" => $valapellido1,
            "apellido2" => $valapellido2,
            "email"  => $valemail,
            "imagen" => $valimagen
        ],
        "mensajes" => $this->mensajes
    ];
    //Mostramos la vista actuser
    include_once 'vistas/actuser.php';
  }
  public function editarperfil() {
  // Array asociativo que almacenará los mensajes de error que se generen por cada campo
    $errores = array();
// Inicializamos valores de los campos de texto
    $nif = "";
    $valnombre = "";
    $valemail = "";
    $valimagen = "";
    $valapellido1 = "";
    $valapellido2 = "";

// Si se ha pulsado el botón actualizar...
    if (isset($_POST['submit'])) { //Realizamos la actualización con los datos existentes en los campos
      $nuevonif  = $_POST["NIF"];
      $id = $_POST['id']; //Lo recibimos por el campo oculto
      $nuevonombre = $_POST['nombre'];
      $nuevoemail  = $_POST['email'];
      $nuevoapellido1 = $_POST['apellido1'];
      $nuevoapellido2 = $_POST['apellido2'];
      $nuevaimagen = "";

      // Definimos la variable $imagen que almacenará el nombre de imagen 
      // que almacenará la Base de Datos inicializada a NULL
      $imagen = NULL;

      if (isset($_FILES["imagen"]) && (!empty($_FILES["imagen"]["tmp_name"]))) {
        // Verificamos la carga de la imagen
        // Comprobamos si existe el directorio fotos, y si no, lo creamos
        if (!is_dir("fotos")) {
          $dir = mkdir("fotos", 0777, true);
        } else {
          $dir = true;
        }
        // Ya verificado que la carpeta fotos existe movemos el fichero seleccionado a dicha carpeta
        if ($dir) {
          //Para asegurarnos que el nombre va a ser único...
          $nombrefichimg = time() . "-" . $_FILES["imagen"]["name"];
          // Movemos el fichero de la carpeta temportal a la nuestra
          $movfichimg = move_uploaded_file($_FILES["imagen"]["tmp_name"], "fotos/" . $nombrefichimg);
          $imagen = $nombrefichimg;
          // Verficamos que la carga se ha realizado correctamente
          if ($movfichimg) {
            $imagencargada = true;
          } else {
            //Si no pudo moverse a la carpeta destino generamos un mensaje que se le
            //mostrará al usuario en la vista actuser
            $imagencargada = false;
            $errores["imagen"] = "Error: La imagen no se cargó correctamente! :(";
            $this->mensajes[] = [
                "tipo" => "danger",
                "mensaje" => "Error: La imagen no se cargó correctamente! :("
            ];
          }
        }
      }
      $nuevaimagen = $imagen;

      if (count($errores) == 0) {
            $nombre = $_SESSION["usuario"];
            $rol = $_SESSION["rol"];
            $resultado = $this->modelo->verificarlogs($nombre, $rol, "Edito usuario");
        //Ejecutamos la instrucción de actualización a la que le pasamos los valores
        $resultModelo = $this->modelo->actuser([
            'id' => $id,
            'NIF' => $nuevonif,
            'nombre' => $nuevonombre,
            'apellido1' => $nuevoapellido1,
            'apellido2' => $nuevoapellido2,
            'imagen' => $nuevaimagen,
            'email' => $nuevoemail
                ]);
        //Analizamos cómo finalizó la operación de registro y generamos un mensaje
        //indicativo del estado correspondiente
        if ($resultModelo["correcto"]) :
          $this->mensajes[] = [
              "tipo" => "success",
              "mensaje" => "El usuario se actualizó correctamente!! :)"
          ];
        else :
          $this->mensajes[] = [
              "tipo" => "danger",
              "mensaje" => "El usuario no pudo actualizarse!! :( <br/>({$resultModelo["error"]})"
          ];
        endif;
      } else {
        $this->mensajes[] = [
            "tipo" => "danger",
            "mensaje" => "Datos de registro de usuario erróneos!! :("
        ];
      }

      // Obtenemos los valores para mostrarlos en los campos del formulario
      $nif = $nuevonif;
      $valnombre = $nuevonombre;
      $valapellido1 = $nuevoapellido1;
      $valapellido2 = $nuevoapellido2;
      $valemail  = $nuevoemail;
      $valimagen = $nuevaimagen;
    } else { //Estamos rellenando los campos con los valores recibidos del listado
      if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
        $id = $_GET['id'];
        //Ejecutamos la consulta para obtener los datos del usuario #id
        $resultModelo = $this->modelo->listausuario($id);
        //Analizamos si la consulta se realiz´correctamente o no y generamos un
        //mensaje indicativo
        if ($resultModelo["correcto"]) :
          $this->mensajes[] = [
              "tipo" => "success",
              "mensaje" => "Los datos del usuario se obtuvieron correctamente!! :)"
          ];
          $nif = $resultModelo["datos"]["NIF"];
          $valnombre = $resultModelo["datos"]["nombre"];
          $valapellido1 = $resultModelo["datos"]["apellido1"];
          $valapellido2 = $resultModelo['datos']["apellido2"];
          $valemail  = $resultModelo["datos"]["email"];
          $valimagen = $resultModelo["datos"]["imagen"];
        else :
          $this->mensajes[] = [
              "tipo" => "danger",
              "mensaje" => "No se pudieron obtener los datos de usuario!! :( <br/>({$resultModelo["error"]})"
          ];
        endif;
      }
    }
    //Preparamos un array con todos los valores que tendremos que rellenar en
    //la vista adduser: título de la página y campos del formulario
    $parametros = [
        "tituloventana" => "Moodle",
        "datos" => [
            "NIF" => $nif,
            "nombre" => $valnombre,
            "apellido1" => $valapellido1,
            "apellido2" => $valapellido2,
            "email"  => $valemail,
            "imagen" => $valimagen
        ],
        "mensajes" => $this->mensajes
    ];
    include_once 'vistas/editarperfil.php';

  }
  public function activar() {
       if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
        $id = $_GET['id'];
        
        //Ejecutamos la consulta para obtener los datos del usuario #id
        $resultModelo = $this->modelo->activar($id);
        //Analizamos si la consulta se realiz´correctamente o no y generamos un
        //mensaje indicativo
        if ($resultModelo["correcto"]) :
            $nombre = $_SESSION["usuario"];
            $rol = $_SESSION["rol"];
            $resultado = $this->modelo->verificarlogs($nombre, $rol, "Alta usuario");
          $this->mensajes[] = [
              "tipo" => "success",
              "mensaje" => "Usuario dado de alta correctamente!! :)"
          ];
        else :
          $this->mensajes[] = [
              "tipo" => "danger",
              "mensaje" => "No se pudieron obtener los datos de usuario!! :( <br/>({$resultModelo["error"]})"
          ];
        endif;
      }
      $this->listado();
  }
  public function desactivar() {
       if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
        $id = $_GET['id'];
        
        //Ejecutamos la consulta para obtener los datos del usuario #id
        $resultModelo = $this->modelo->desactivar($id);
        //Analizamos si la consulta se realiz´correctamente o no y generamos un
        //mensaje indicativo
        if ($resultModelo["correcto"]) :
            $nombre = $_SESSION["usuario"];
            $rol = $_SESSION["rol"];
            $resultado = $this->modelo->verificarlogs($nombre, $rol, "Baja usuario");
          $this->mensajes[] = [
              "tipo" => "success",
              "mensaje" => "Usuario dado de baja correctamente!! :)"
          ];
        else :
          $this->mensajes[] = [
              "tipo" => "danger",
              "mensaje" => "No se pudieron obtener los datos de usuario!! :( <br/>({$resultModelo["error"]})"
          ];
        endif;
      }
      $this->listado();
  }
  public function exportarpdf(){
      ob_start();
      
      $resultModelo = $this->modelo->listadoaexportar();
      $parametros["datos"] = $resultModelo["datos"];
      //require_once 'vistas/listadoaexportar.php';
      $html = ob_clean();
      $html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
      $html2pdf->writeHTML("<h1 align='center'>Listado de usuarios</h1><br><hr>");
      $tabla = '<table align="center" border="1">
          <tr>
          <th>Imagen</th>
          <th>NIF</th>
          <th>Nombre</th>
          <!-- <th>Contraseña</th>-->
          <th>Apellidos</th>
          <th>Rol</th>
          <th>Telefono de contacto</th>
          <th>Departamento</th>
          <th>Web</th>
          <th>Activo</th>
          
        </tr>';
      foreach($parametros['datos'] as $d){
         $tabla .= '<tr>'
                 . '<td><img src="fotos/'.$d['imagen'].'" width="40" /></td>'
                 . '<td>'.$d["NIF"].'</td>'
                 . '<td>'.$d["nombre"].'</td>'
                 . '<td>'.$d["apellido1"].' '.$d["apellido2"].'</td>'
                 . '<td>'.$d["rol"].'</td>'
                 . '<td>'.$d["telefonomov"].'</td>'
                 . '<td>'.$d["departamento"].'</td>'
                 
                ;
         if(($d["paginaweb"] || $d["direccionblog"] || $d["twitter"]) != NULL):
            $tabla.= '<td>'.$d["paginaweb"].' '.$d["direccionblog"].' '.$d["twitter"].'</td>';
            else:
            $tabla .= '<td>----</td>';
            endif;
          if ($d["activo"] == "1"):
                 $tabla .= '<td>Activo</td>';
                    else :
                $tabla .='<td>No activado</td>';
                 endif;
          $tabla .= '</tr>';
      }
      $tabla .= '</table>';
      $html2pdf->writeHTML($tabla);
      $html2pdf->output('listado.pdf');
  }
  public function exportarlogs(){
      ob_start();
      
      $resultModelo = $this->modelo->exportarlogs();
      $parametros["datos"] = $resultModelo["datos"];
      //require_once 'vistas/listadoaexportar.php';
      $html = ob_clean();
      $html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
      $html2pdf->writeHTML("<h1 align='center'>Listado de usuarios</h1><br><hr>");
      $tabla = '<table border="1">
          <tr>
          <th>Nombre</th>
          <th>Fecha</th>
          <th>Rol</th>
          <th>Acción</th>          
        </tr>';
      foreach($parametros['datos'] as $d){
         $tabla .= '<tr>'
                 .'<td>'. $d['nombre'].' </td>'
                 .'<td>'. $d['fecha'].'</td>'
                 . '<td>'. $d['rol'].'</td>'
                 . '<td>'. $d['accion'].'</td>';
         $tabla .= '</tr>';
      }
      $tabla .= '</table>';
      $html2pdf->writeHTML($tabla);
      $html2pdf->output('logs.pdf');
  }
  
}
