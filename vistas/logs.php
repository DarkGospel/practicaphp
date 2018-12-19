<html>
   
  <body class="cuerpo">
    <div class="container centrar">
      <a href="index.php?action=inicio">Inicio</a>
      <div class="container cuerpo text-center centrar">	
        <p><h2><img class="alineadoTextoImagen" src="images/user.png" width="50px"/>Listar Acciones</h2> </p>
      </div>
      <!--Mostramos los mensajes que se hayan generado al realizar el listado-->
      <?php foreach ($parametros["mensajes"] as $mensaje) : ?> 
        <div class="alert alert-<?= $mensaje["tipo"] ?>"><?= $mensaje["mensaje"] ?></div>
      <?php endforeach; ?>
      <!--Creamos la tabla que utilizaremos para el listado:-->  
      <table class="table table-striped">
        <tr>
          <th>Nombre</th>
          <!-- <th>Contraseña</th>-->
          <th>Fecha</th>
          <th>Rol</th>
          <!-- Añadimos una columna para las operaciones que podremos realizar con cada registro -->
          <th>Acción</th>
        </tr>
        <!--Los datos a listar están almacenados en $parametros["datos"], que lo recibimos del controlador-->
        <?php foreach ($parametros["datos"] as $d) : ?>
          <!--Mostramos cada registro en una fila de la tabla-->
          <tr>  
            <td><?= $d["nombre"] ?></td>
            <td><?= $d["fecha"] ?></td>
            <td><?= $d["rol"] ?></td>
            <td><?= $d["accion"] ?></td>
            </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </body>
</html>

