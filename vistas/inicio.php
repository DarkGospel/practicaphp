<!DOCTYPE html>
<html>
    <?php require_once 'includes/header.php'; 
    require_once 'includes/navbar.php';?>
  <body class="inicio">
    <div class="container centrar">
        <a href="index.php?action=listado" class="col-md-4"> <img src="images/listar.png" id="imglistar"/></a>   
      <?php if($_SESSION["login"]["rol"] == "Administrador"): ?>
      <a href="index.php?action=adduser" class="col-md-4"> <img src="images/addusuario.png" id="imglistar"/></a>
      <?php endif;?>
      <a href="index.php?action=verlogs" class="col-md-4"> <img src="images/logs.png" id="imglistar"/></a>
      
    </div>
  </body>
</html>
