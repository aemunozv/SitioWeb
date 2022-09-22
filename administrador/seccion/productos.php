<?php include("../template/cabecera.php"); ?>
<?php

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtnombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";

$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

//Este comando para Verificar que si se esta ejecutando el Submit
echo $txtID."<br>";
echo $txtnombre."<br>";
echo $txtImagen."<br>";
echo $accion."<br>";

$host="localhost";
$bd="localhost";
$usuario="localhost";
$contrasenia="localhost";

switch($accion){

        case "Agregar":
          //INSERT INTO `libros`(`id`, `nombre`, `imagen`) VALUES ('[value-1]','[value-2]','[value-3]')
          echo "Presionado Boton Agregar";
          break;
        case "Modificar":
            echo "Presionado Boton Modificar";
            break;
        case "Cancelar":
              echo "Presionado Boton Cancelar";
              break;
}


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
            <input type="text" class="form-control" name="txtID" id="txtID"  placeholder="ID">
          </div>

          <div class = "form-group">
            <label for="txtnombre">Nombre:</label>
            <input type="text" class="form-control" name="txtNombre" id="txtNombre"  placeholder="Nombre del Libro">
          </div>

          <div class = "form-group">
            <label for="txtnombre">Imagen:</label>
            <input type="file" class="form-control" name="txtImagen" id="txtImagen"  placeholder="Nombre del Libro">
          </div>

          <div class="btn-group" role="group" aria-label="">
              <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
              <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
              <button type="submit" name="accion" value="Cancelar" class="btn btn-info">Cancelar</button>
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
          
          <tr>
            <td>2</td>
            <td>Aprende PHP</td>
            <td>Image.jpg</td>
            <td>Seleccionar | Borrar</td>
          </tr>
         
        </tbody>
      </table>

  </div>

<?php include("../template/pie.php");?>
