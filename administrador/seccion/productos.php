<?php include("../template/cabecera.php"); ?>


<?php
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";

$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("../config/bd.php");

//Este comando para Verificar que si se esta ejecutando el Submit
//echo $txtID."<br>";
//echo $txtnombre."<br>";
//echo $txtImagen."<br>";
//echo $accion."<br>";

switch($accion){
        case "Agregar":
          $sentenciaSQL=$conexion->prepare("INSERT INTO libros( nombre, imagen) VALUES (:nombre, :imagen);");
          $sentenciaSQL->bindParam(':nombre',$txtNombre);

          $fecha= new DateTime();
          $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

          $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

          if($tmpImagen!=""){

                      move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
          }

          $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
          $sentenciaSQL->execute();
          header("Location:productos.php");
          break;

        case "Modificar":
            //echo "Presionado Boton Modificar";
            $sentenciaSQL=$conexion->prepare("UPDATE libros SET nombre = :nombre WHERE id=:id");
            $sentenciaSQL->bindParam(':nombre',$txtNombre);
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();

            if ($txtImagen!="") {

                $fecha= new DateTime();
                $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
                $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
                move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

                $sentenciaSQL=$conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
                $sentenciaSQL->bindParam(':id',$txtID);
                $sentenciaSQL->execute();
                $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

                if(isset($libro['imagen']) &&($libro['imagen']!="imagen.jpg") ){

                  if(file_exists("../../img/".$libro["imagen"])){

                    unlink("../../img/".$libro["imagen"]);
                  }

                }

                $sentenciaSQL=$conexion->prepare("UPDATE libros SET imagen = :imagen WHERE id=:id");
                $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->execute();
            }
            header("Location:productos.php");
            break;
            
        case "Cancelar":
             //echo "Presionado Boton Cancelar.";
             header("Location:productos.php");
              break;
        case "Seleccionar":
             //echo "Presionado Boton Seleccionar.";
             $sentenciaSQL=$conexion->prepare("SELECT * FROM libros WHERE id=:id");
             $sentenciaSQL->bindParam(':id',$txtID);
             $sentenciaSQL->execute();
             $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

            $txtNombre=$libro['nombre'];
            $txtImagen=$libro['imagen'];

             break;
        case "Borrar":
             //echo "Presionado Boton Borrar.";

             $sentenciaSQL=$conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
             $sentenciaSQL->bindParam(':id',$txtID);
             $sentenciaSQL->execute();
             $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

             if(isset($libro['imagen']) &&($libro['imagen']!="imagen.jpg") ){

                  if(file_exists("../../img/".$libro["imagen"])){

                    unlink("../../img/".$libro["imagen"]);
                  }

             }

             $sentenciaSQL=$conexion->prepare("DELETE FROM libros WHERE id=:id");
             $sentenciaSQL->bindParam(':id',$txtID);
             $sentenciaSQL->execute();
             header("Location:productos.php");
            break;
}
$sentenciaSQL=$conexion->prepare("SELECT * FROM libros");
$sentenciaSQL->execute();
$listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>


  <div class="col-md-5">

  <div class="card">
    <div class="card-header">
      Datos de Libro
    </div>

    <div class="card-body">
    </div>

        <form method="POST" enctype="multipart/form-data" >

          <div class = "form-group">
            <label for="txtID">ID:</label>
            <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID"  placeholder="ID">
          </div>

          <div class = "form-group">
            <label for="txtNombre">Nombre:</label>
            <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre"  placeholder="Nombre del Libro">
          </div>

          <div class = "form-group">
            <label for="txtImagen">Imagen:</label>
            <br/>
            
            <?php if ($txtImagen!="") { ?>
              <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen; ?>" width="50" alt="" srcset="">
            <?php } ?>

            <input type="file" class="form-control"  name="txtImagen" id="txtImagen"  placeholder="Nombre del Libro">
          </div>

          <div class="btn-group" role="group" aria-label="">
              <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disable":""; ?> value="Agregar" class="btn btn-success">Agregar</button>
              <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disable":""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
              <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disable":""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
            </div>
        </form>
  </div>
  </div>


  

  <div class="col-md-7">
    
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Imagen</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($listaLibros as $libro) { ?>
          <tr>
            <td><?php echo $libro['id']; ?> </td>
            <td><?php echo $libro['nombre']; ?> </td>
              <td>

                  <img class="img-thumbnail rounded" src="../../img/<?php echo $libro['imagen']; ?>" width="50" alt="">

                
              </td>
            <td>
              
                        
              <form method="post">
                <input type="hidden" name="txtID" id="ttxID" value="<?php echo $libro['id']; ?>"/>

                <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>

                <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>
              </form>
            </td>

          </tr>
          <?php } ?>
        </tbody>
      </table>

  </div>

<?php include("../template/pie.php");?>
