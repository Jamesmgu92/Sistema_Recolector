<?php 

    include_once("libreria2.php");

    $objConexion   = new Conexion(); 
    $idconexion    = $objConexion->conectar();
    $objUtilidades = new Utilidades();
    $vridUsuario   = $objUtilidades->consecutivo("usuario","id_usuario",$idconexion);
    
    $vrusuNombre   = "";
    $vrusuApellido = "";
    $vrusuCorreo   = "";
    $vrusuContrasena = "";
   /* echo "<pre>";
    print_r($_REQUEST);
    echo "</pre>";*/

    if(isset($_REQUEST["btnAdicionar"])){

       $vrusuPerfil        = htmlspecialchars($_REQUEST["lstidPerfil"]); 
       $vrusuDocumento     = htmlspecialchars($_REQUEST["txtusuDocumento"]);
       $vrusuTelefono      = htmlspecialchars($_REQUEST["txtusuTelefono"]);
       $vrusuNombre        = htmlspecialchars($_REQUEST["txtusuNombre"]);
       $vrusuApellido      = htmlspecialchars($_REQUEST["txtusuApellido"]);
       $vrusuCorreo        = htmlspecialchars($_REQUEST["txtusuCorreo"]);
       $vrusuContrasena    = htmlspecialchars($_REQUEST["txtusuContrasena"]);
       $vrusuEstado        = 1;

       $objCrud            =  new Crud();
       $objCrud->tablas    = "usuario";
       $objCrud->expresion = "*";
       $objCrud->condicion = "documento='$vrusuDocumento'";
       $vrcanusuarios      = $objCrud->read($idconexion);

       if($vrcanusuarios>0){
         echo "Este documento ya ha sido registrado por otro usuario";
       } else {
         $objCrud1          = new Crud();
         $objCrud1->tablas  = "usuario";
         $objCrud1->campos  = "id_usuario, id_perfil, documento, telefono, nombre, apellido, correo, contrasena";
         $objCrud1->valores ="'$vridUsuario','$vrusuPerfil','$vrusuDocumento','$vrusuTelefono','$vrusuNombre','$vrusuApellido','$vrusuCorreo','$vrusuContrasena'";
         $objCrud1->create();
       }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Formulario registro usuarios</title>
	<script type="text/javascript" src="../js/formularioingresoadmin.js"></script>
</head>
<body>
    
  <div class="modal-registro">
	<form  name="frmingUsuarios" id="frmingUsuarios" method="post"  action='<?php echo $_SERVER["PHP_SELF"]; ?>'>
			<label for="txtidUsuario">Codigo usuario</label>
			<?php echo $vridUsuario; ?>
			<br />
            <label for="lstidPerfil">Perfil</label>
             <select name="lstidPerfil" id="lstidPerfil">
                <option value="">Sin seleccionar</option>
                <?php
                    $objUtilidades->llenar_combo("perfil_usuario","id_perfil,perfil","id_perfil",$idconexion);
                 ?> 
                 
             </select>
            <br />
			<label for="txtusudocumento">Documento</label>
			<input type="number" name="txtusuDocumento" id="txtusuDocumento" value='<?php echo $vrusuDocumento ?>' />
			<br />
			<label for="txtusuTelefono">Telefono</label>
			<input type="number" name="txtusuTelefono" id="txtusuTelefono" value='<?php echo $vrusuTelefono ?>'/>
			<br />
			<label for="txtusuNombre">Nombre</label>
			<input type="text" name="txtusuNombre" id="txtusuNombre" value='<?php echo $vrusuNombre ?>' />
			<br />
			
			<label for="txtusuApellido">Apellido</label>
			<input type="text" name="txtusuApellido" id="txtusuApellido" value='<?php echo $vrusuApellido ?>' />
			<br />
			<label for="txtusuCorreo">Correo</label>
			<input type="email" name="txtusuCorreo" id="txtusuCorreo" value='<?php echo $vrusuCorreo ?>' />
			<br />
			<label for="txtusucontrasena">Contraseña</label>
            <input type="password" name="txtusuContrasena" id="txtusuContrasena" value='<?php echo $vrusuContrasena ?>' />
            <br />
            <!--<input type="hidden" name="btnAuxiliar" id="btnAuxiliar" value="Auxiliar">-->
           <button type="submit" name="btnAdicionar" id="btnAdicionar" value="Adicionar">
                Adicionar
            </button>
			
			<button type="button" name="btnNuevo" id="btnNuevo" value="Nuevo">
				Nuevo
			</button>
	</form>
  </div>
</body>
</html>

