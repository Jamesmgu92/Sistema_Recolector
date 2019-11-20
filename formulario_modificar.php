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
				<h2>Formulario para actualizar usuario</h2>
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
				<select class="" id="form_actualizar" onchange= "mostrar_opciones()">
						<option value="d">No Actualizar</option>
						<option value="c">Actualizar</option>						
					</select>
				</center>
			</div>
			
			<div class="col-lg-1">
				&nbsp;
			</div>
			<div class="" id="opciones" style="display: none;">
				<div class="">
					<div class="">
						<div class="">
                        <form class="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        
							<label>No:</label>
							<input class="" type="text" name="Doc_id" value="<?php echo $id; ?>">
							<label>Perfil</label>
							<input class="" type="text" name="Usu_perfil" value="<?php echo $perfil; ?>">
							<label>Documento</label>
							<input class="" type="text" name="Usu_documento" value="<?php echo $documento; ?>">
							<label>Telefono</label>
							<input class="" type="text" name="Usu_telefono" value="<?php echo $telefono; ?>">
							<label>Nombre</label>
							<input class="" type="text" name="Usu_nombre" value="<?php echo $nombre; ?>">
							<label>Apellido</label>
							<input class="" type="text" name="Usu_apellido" value="<?php echo $apellido; ?>">
							<label>Correo</label>
                            <input class="" type="text" name="Usu_correo" value="<?php echo $correo; ?>">
                            <label>Estado</label>
							<input class="" type="text" name="Usu_Estado" value="<?php echo $estado; ?>">
							
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<center>
						<input class="" type="submit" name="Actualizar" value="Actualizar usuario">
					</form>
					</center>
				</div>

            </div>
            
                    <?php }?>
				
		</div>	
	</div>
	
            <?php
            
            //llamaral metodo update para guardar y modificar datos

            if (isset($_POST["Actualizar"])) {

                $vrusuid        = htmlspecialchars($_POST["Doc_id"]);
                $vrusuperfil    = htmlspecialchars($_POST["Usu_perfil"]);
                $vrusudocumento = htmlspecialchars($_POST["Usu_documento"]);
                $vrusutelefono  = htmlspecialchars($_POST["Usu_telefono"]);
                $vrusunombre    = htmlspecialchars($_POST["Usu_nombre"]);
                $vrusuapellido  = htmlspecialchars($_POST["Usu_apellido"]);
                $vrusucorreo    = htmlspecialchars($_POST["Usu_correo"]);
                $vrusuestado    = htmlspecialchars($_POST["Usu_Estado"]);

                $objCrud            = new crud();
                $objCrud->tablas    = "usuario";
                $objCrud->expresion = "id_usuario = '$vrusuid', id_perfil = '$vrusuperfil', documento = '$vrusudocumento', telefono = '$vrusutelefono', nombre = '$vrusunombre', apellido = '$vrusuapellido', correo = '$vrusucorreo', estado = '$vrusuestado'";
                /*$objCrud->expresion = "'$vrusuid'";*/
                $objCrud->condicion = "id_usuario='$vrusuid'";
                $objCrud->update($idconexion);

                
            }
            
			?>
			
			<script type = "text/javascript">
			function mostrar_opciones() {

				var vractualizar= document.getElementById('form_actualizar').value;
				var opciones = document.getElementById('opciones');

				if (vractualizar == "c") {
					opciones.style.display="inline";
				}else{
					opciones.style.display="none";
				}
				
			}
			</script>
	
</body>
</html>