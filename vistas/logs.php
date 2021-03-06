<html>
   
  <body class="cuerpo">
    <div class="container centrar">
      <a href="index.php?action=inicio">Inicio</a>
      <div class="container cuerpo text-center centrar">	
        <p><h2><img class="alineadoTextoImagen" src="images/user.png" width="50px"/>Listar Acciones<a href="index.php?action=exportarlogs"><img class="alineadoTextoImagen" src="images/PDF.png" width="40px"
    height="40px"/></a></h2> </p>
      </div>
      <!--Menu desplegable-->
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
              <span class="icon-user"></span> Registros por página: <span class="caret"></span></button>
            
            <ul class="dropdown-menu">
              <li><a href="index.php?action=verlogs&regsxpag=5"> <i class="icon-fixed-width icon-th"></i> 5</a></li>
              <li><a href="index.php?action=verlogs&regsxpag=10"> <i class="icon-fixed-width icon-th"> </i> 10</a></li>
              <li><a href="index.php?action=verlogs&regsxpag=15"> <i class="icon-fixed-width icon-th"></i> 15</a></li>
              <li><a href="index.php?action=verlogs&regsxpag=20"><i class="icon-fixed-width icon-th"></i> 20</a></li>
            </ul>
        </div>
      <!---->
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
        <?php //Verificamos que existen registros a mostrar
                if($parametros['registros']>=1):  
                  foreach($parametros['datos'] as $reg): 
              ?>
              <tr>
                <td> <?php echo $reg['nombre']?> </td>
                <td> <?php echo $reg['fecha']?>    </td>
                <td> <?php echo $reg['rol']?>     </td>
                <td> <?php echo $reg['accion']?>  </td>
              </tr> 
              <?php 
                  endforeach; 
                else:  
              ?>
              <td colspan="4"> No existen registros para mostrar... :( </td>
              <?php endif; ?>
      </table>
    </div>
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
            <li class="page-item"><a class="page-link" href="index.php?action=verlogs&pagina=<?php echo $pagina-1; ?>&regsxpag=<?= $regsxpag ?>"> &laquo;</a></li>
         <?php  
          endif;
          //Mostramos como activos el botón de la página actual
          for($i=1;$i<=$parametros["paginas"];$i++){
            if($pagina==$i){
              echo '<li class="page-item active"> 
                <a class="page-link" href="index.php?action=verlogs&pagina=' . $i . '&regsxpag=' . $regsxpag . '">'. $i .'</a></li>';
             }else {
              echo '<li class="page-item"> 
                <a class="page-link" href="index.php?action=verlogs&pagina=' . $i . '&regsxpag=' . $regsxpag . '">'. $i .'</a></li>';
            }
          }
         //Comprobamos si estamos en la última página. Si es así, deshabilitamos el botón 'siguiente'
          if($pagina==$parametros["paginas"]): ?>  
             <li class="page-item disabled"><a class="page-link" href="#">&raquo;</a></li>
          <?php else: ?>
            <li class="page-item"><a class="page-link" href="index.php?action=verlogs&pagina=<?php echo $pagina+1; ?>&regsxpag=<?= $regsxpag ?>"> &raquo; </a></li>
          <?php endif; ?>    
      </ul>         
    </nav>
    <?php endif;  //if($totalregistros>=1): ?>
        
  </body>
</html>

