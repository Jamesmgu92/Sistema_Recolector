<?php

    include ("libreria2.php");
    $objConexion    = new conexion();
    $idconexion     = $objConexion->conectar();
    $objCrud        = new crud();


?>


<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Formulario Actualizar Usuario</title>
	<link rel="stylesheet" href="css/fondo.css">
</head>
<body>
			<br>
			<div>
					<a href="index.php">Inicio</a>
			</div>
			
			<div>
				<center>	
				<h2>Formulario para eliminar usuario</h2>
				</center>
			</div>
			
			
				<center>
				<form class="form form-row" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<input class="" type="text" name="busqueda" placeholder="Escriba aquí el  número de documento">
					<input class="" type="submit" name="buscar" value="Buscar">
				</form>

                <?php
                
                    if (isset ($_POST['buscar'])) {

                        $id_busqueda        = $_POST['busqueda'];
                        $objCrud->tablas    = "usuario";
                        $objCrud->expresion ="*";
                        $objCrud->condicion = "id_usuario = '$id_busqueda'";
                        $objCrud->read($idconexion);
                        $ardatos            = $objCrud->filas;
                        
                        /*echo "<pre>";
                         print_r($ardatos);
                        echo "</pre>";*/

                        $id        = $ardatos[0]['id_usuario'];
                        $perfil    = $ardatos[0]['id_perfil'];
                        $documento = $ardatos[0]['documento'];
                        $telefono  = $ardatos[0]['telefono'];
                        $nombre    = $ardatos[0]['nombre'];
                        $apellido  = $ardatos[0]['apellido'];
                        $correo    = $ardatos[0]['correo'];
                        $estado    = $ardatos[0]['estado'];

                    

                ?>

				<!-- Formulario 2 -->

				<table class="">
					<thead>
						<th>No</th>
						<th>Perfil</th>
						<th>Documento</th>
						<th>Telefono</th>
						<th>Nombre</th>
						<th>Apellido</th>
                        <th>Correo</th>
                        <th>Estado</th>
					</thead>
					<tbody>
						
                        <td><?php echo $id;?></td>
                        <td><?php echo $perfil;?></td>
                        <td><?php echo $documento;?></td>
                        <td><?php echo $telefono;?></td>
                        <td><?php echo $nombre;?></td>
                        <td><?php echo $apellido;?></td>
                        <td><?php echo $correo;?></td>
                        <td><?php echo $estado;?></td>

					</tbody>
					
				</table>
                <button type="submit" name="btneliminar" id="btneliminar" value="elimninar"> Eliminar usuario
                </button>
				</center>
			</div>
			
            <?php
                    }
            ?>

            <?php

            if(isset($_REQUEST["btneliminar"])){

                $objCrud1 = new crud();
                $objCrud1->tablas = "usuario";
                $objCrud1->condicion = "id_usuario = '$id_busqueda'";
                $objCrud1->delete($idconexion);

                echo "<pre>";
                     print_r($objCrud1->condicion);
                echo "</pre>";


            }

            ?>

            </div>
            
        
				
		</div>	
	</div>
	
</body>
</html>