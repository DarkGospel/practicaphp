<!DOCTYPE html>
<html>
  <?php require_once 'includes/header.php';?>
  <?php
  if(!empty($_POST)){
        $nombre = $_POST['txtnombre'];
        $pasword = $_POST['txtpass'];
        $captcha = $_POST['g-recaptcha-response'];
        //$controlpassw = "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#.$($)$-$])[A-Za-z\d$@$!%*?&#.$($)$-$ ]{8,15}$";
        /*if(!empty($_POST['txtpass']) && !preg_match($controlpassw, $_POST['txtpass'])){
            echo '<h3>Error contraseña debil</h3>';
        }else{
            echo '<h3>El usuario ha sido registrado correctamente</h3>';
        }*/
        
        $secret = '6LcvfYIUAAAAAMLKHVwsRJLlKlEQm_EMc7T262CC';
        if(!$captcha){
            echo "Por favor verifica el captcha";
        }
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
        
        //var_dump($response);
        
        $arr = json_decode($response, TRUE);
        
        if($arr['success']){
            echo "<h2></h2>";
        }else{
            echo '<h3>Error al comprobar Captcha </h3>';
        }
        
    }
  ?>
  <body class="cuerpo">
    <div class="centrar">	
      <div class="container centrar">
        <a href="index.php">Inicio</a>
        <div class="container cuerpo text-center centrar">	 
          <p><h2><img class="alineadoTextoImagen" src="images/user.png" width="50px"/>Registro de Usuarios</h2> </p>
        </div>
        <?php foreach ($parametros["mensajes"] as $mensaje) : ?> 
          <div class="alert alert-<?= $mensaje["tipo"] ?>"><?= $mensaje["mensaje"] ?></div>
        <?php endforeach; ?>
        <form action="index.php?action=adduser" method="post" enctype="multipart/form-data">
          <label for="txtnombre">Nombre *
            <input type="text" class="form-control" name="txtnombre" required value="<?= $parametros["datos"]["txtnombre"] ?>"></label>
          <br/>
          <label for="nif">NIF *
            <input type="text" class="form-control" name="nif" required value="<?= $parametros["datos"]["nif"] ?>"></label>
          <br/>
          <label for="txtnick">Nombre usuario *
            <input type="text" class="form-control" name="txtnick" required value="<?= $parametros["datos"]["txtnick"] ?>"></label>
          <br/>
          <label for="txtapellido1">Apellido 1 *
            <input type="text" class="form-control" name="txtapellido1" required value="<?= $parametros["datos"]["txtapellido1"] ?>"></label>
          
          <label for="txtapellido2">Apellido 2 
            <input type="text" class="form-control" name="txtapellido2" value="<?= $parametros["datos"]["txtapellido2"] ?>"></label>
          <br/>          
          <label for="txtemail">Email *
            <input type="email" class="form-control" name="txtemail" value="<?= $parametros["datos"]["txtemail"] ?>"></label>
          <br/>
          <label for="txtpass">Contraseña *
            <input type="password" class="form-control" name="txtpass" required value="<?= $parametros["datos"]["txtpass"] ?>"></label>
          <br/>
          <label for="txtmovil">Telefono Movil *
            <input type="text" class="form-control" name="txtmovil" required value="<?= $parametros["datos"]["txtmovil"] ?>"></label>
          
          <label for="txtfijo">Telefono fijo
            <input type="text" class="form-control" name="txtfijo"  value="<?= $parametros["datos"]["txtfijo"] ?>"></label>
          <br/>
          <label for="txtdepartamento">Departamento *
            <input type="text" class="form-control" name="txtdepartamento" required value="<?= $parametros["datos"]["txtdepartamento"] ?>"></label>
          <br/>
          <label for="txtnick">Nombre usuario *
            <input type="text" class="form-control" name="txtnick" required value="<?= $parametros["datos"]["txtnick"] ?>"></label>
          <br/>
          <label for="imagen">Imagen <input type="file" name="imagen" class="form-control" value="<?= $parametros["datos"]["imagen"] ?>" /></label>
          </br>          
          <div class="container text-center">
            <div class="g-recaptcha" data-sitekey="6LcvfYIUAAAAAF75EL8oyYBFbNbB1RV9oSWB1a9F"></div>
          </div>
          <input type="submit" value="Guardar" name="submit" class="btn btn-success">
        </form>
      </div>
  </body>
</html>