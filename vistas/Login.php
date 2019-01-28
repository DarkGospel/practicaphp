<!DOCTYPE html>
<html>
<body>
    <?php if(isset($_SESSION["error"])) :
          echo $_SESSION["error"];
          unset($_SESSION["error"]);
    endif; ?>
<div id="login">
    <form action="index.php?action=login_enviar" method="POST">
  <div class="imgcontainer">
      <img src="images/avatar_doble.jpg" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label for="nombre"><b>Usuario</b></label>
    <input type="text" placeholder="Nombre usuario" name="nombre" required>

    <label for="contrasena"><b>Password</b></label>
    <input type="password" placeholder="Contraseña" name="contrasena" required>
        
    <button type="submit">Acceder</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Recordar usuario
    </label>
  </div>

  <div class="container" style="background-color:#f1f1f1">
      <a href="index.php?action=adduser"><button type="button" class="cancelbtn">Registrarse</button></a>
    </div>
</form>
    </div>
</body>
</html>