<html>
    <?php require_once 'includes/header.php'; 
    require_once 'includes/navbar.php';?>
  <body class="cuerpo">
    <div class="container centrar">
      <a href="index.php?action=inicio">Inicio</a>
      <div class="container cuerpo text-center centrar">	
        <p><h2><img class="alineadoTextoImagen" src="images/user.png" width="50px"/>Listar Usuarios
            <a href="index.php?action=exportarpdf"><img class="alineadoTextoImagen" src="images/PDF.png" width="40px"
    height="40px"/></a></h2> </p>
      </div>
      <!--Mostramos los mensajes que se hayan generado al realizar el listado-->
      <?php foreach ($parametros["mensajes"] as $mensaje) : ?> 
        <div class="alert alert-<?= $mensaje["tipo"] ?>"><?= $mensaje["mensaje"] ?></div>
      <?php endforeach; ?>
      <!--Menu desplegable-->
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
              <span class="icon-user"></span> Registros por página: <span class="caret"></span></button>
            
            <ul class="dropdown-menu">
              <li><a href="index.php?action=listado&regsxpag=3"><i class="icon-fixed-width icon-th"></i> 3</a></li>
              <li><a href="index.php?action=listado&regsxpag=15"><i class="icon-fixed-width icon-th"> </i> 5</a></li>
              <li><a href="index.php?action=listado&regsxpag=10"><i class="icon-fixed-width icon-th"></i> 10</a></li>
              <li><a href="index.php?action=listado&regsxpag=20"><i class="icon-fixed-width icon-th"></i> 20</a></li>
            </ul>
        </div>
      <!---->
      <!--Creamos la tabla que utilizaremos para el listado:-->  
      <table class="table table-striped">
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
          <!-- Añadimos una columna para las operaciones que podremos realizar con cada registro -->
          <th>Operaciones</th>
        </tr>
        <!--Los datos a listar están almacenados en $parametros["datos"], que lo recibimos del controlador-->
        <?php //Verificamos que existen registros a mostrar
                if($parametros['registros']>=1):  
                  foreach($parametros['datos'] as $d): 
              ?>
          <!--Mostramos cada registro en una fila de la tabla-->
          <tr>
              <?php if ($d["imagen"] !== NULL) : ?>
              <td><img src="fotos/<?= $d['imagen'] ?>" width="40" /></td>
            <?php else : ?>
              <td>----</td>
            <?php endif; ?>
            <td><?= $d["NIF"]?></td>
            <td><?= $d["nombre"] ?></td>
            <!--<td><?= $d["password"] ?></td>-->
            <td><?= $d["apellido1"] ?> <?= $d["apellido2"] ?></td>
            <!--<td><?= $d["apellido2"] ?></td>-->
            <td><?= $d["rol"]?></td>
            <td><?= $d["telefonomov"]?><?=$d["telefonofijo"]?></td>
            <td><?= $d["departamento"]?></td>
            <?php if(($d["paginaweb"] || $d["direccionblog"] || $d["twitter"]) != NULL):?>
            <td><?= $d["paginaweb"]?><?= $d["direccionblog"]?><?= $d["twitter"]?></td>
            <?php else:?>
            <td>----</td>
                <?php endif;?>
            <?php if ($d["activo"] == "1") :?>
            <td>Activo</td>
            <?php else :?>
            <td>No activado</td>
            <?php endif;?>
            <!--Operaciones-->
            <td>
            <?php if($_SESSION["login"]["rol"] == "Administrador"):?>
                <?php if($d['idUsuarios'] != $_SESSION["login"]["idUsuarios"]):?>
            <!-- Enviamos a actuser.php, mediante GET, el id del registro que deseamos editar o eliminar: -->           
                <a href="index.php?action=actuser&id=<?= $d['idUsuarios'] ?>"><img src="images/editar.png" width="17px" height="17px"></a>
              <!--  <a href="index.php?action=deluser&id=<?= $d['idUsuarios'] ?>"><img src="images/borrar.png" width="17px" height="17px"></a>-->
                <a data-toggle="modal" data-target="#myModal"><img src="images/borrar.png" width="17px" height="17px"></a>
                <?php if($d['activo']== "0"):?>
                <a href="index.php?action=activar&id=<?= $d['idUsuarios'] ?>"> Activar</a>
                <?php else:?>
                <a href="index.php?action=desactivar&id=<?= $d['idUsuarios'] ?>"> Desactivar</a>
                <?php endif;?>
                <?php else:?>
                <p>-------</p>
                <?php endif;?>
            <?php else:?>
                <p>-------</p>
            <?php endif;?>
            </td>
          </tr>
        <?php endforeach; 
            else: ?>
              <td colspan="4"> No existen registros para mostrar... :( </td>
        <?php endif; ?>
           <!-- The Modal para elim-->
                  <div class="modal" id="myModal">
                        <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" align="center">¡ATENCIÓN!</h4>
                                    </div>
                                    <div class="modal-body" align="center">
                                        <strong>Se va a proceder a borrar un usuario</strong> <br><br>
                                        <p>¿Estas seguro?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <div align="center">
                                        <a href="index.php?action=deluser&id=<?= $d['idUsuarios'] ?>" class="btn btn-success">Si</a>
                                        <a href="#" data-dismiss="modal" class="btn btn-danger">No</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                  </div>
      </table>
    </div>
      <!--Enumeración de paginas-->
       <?php //Sólo mostramos los enlaces a páginas si existen registros a mostrar
      if($parametros['registros']>=1):  
    ?>
    <nav aria-label="Page navigation example" class="text-center">
      <ul class="pagination">       
        <?php 
         //Comprobamos si estamos en la primera página. Si es así, deshabilitamos el botón 'anterior'
          if($pagina==1): ?>
            <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
          <?php else: ?>
            <li class="page-item"><a class="page-link" href="index.php?action=listado&pagina=<?php echo $pagina-1; ?>&regsxpag=<?= $regsxpag ?>"> &laquo;</a></li>
         <?php  
          endif;
          //Mostramos como activos el botón de la página actual
          for($i=1;$i<=$parametros["paginas"];$i++){
            if($pagina==$i){
              echo '<li class="page-item active"> 
                <a class="page-link" href="index.php?action=listado&pagina=' . $i . '&regsxpag=' . $regsxpag . '">'. $i .'</a></li>';
             }else {
              echo '<li class="page-item"> 
                <a class="page-link" href="index.php?action=listado&pagina=' . $i . '&regsxpag=' . $regsxpag . '">'. $i .'</a></li>';
            }
          }
         //Comprobamos si estamos en la última página. Si es así, deshabilitamos el botón 'siguiente'
          if($pagina==$parametros["paginas"]): ?>  
             <li class="page-item disabled"><a class="page-link" href="#">&raquo;</a></li>
          <?php else: ?>
            <li class="page-item"><a class="page-link" href="index.php?action=listado&pagina=<?php echo $pagina+1; ?>&regsxpag=<?= $regsxpag ?>"> &raquo; </a></li>
          <?php endif; ?>    
      </ul>         
    </nav>
    <?php endif;  //if($totalregistros>=1): ?>
      <!---->
  </body>
</html>