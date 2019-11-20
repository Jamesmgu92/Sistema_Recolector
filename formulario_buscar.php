<?php 

    include_once("libreria2.php");

    $objCrud                = new Crud();
    $objCrud->tablas        = "usuario";
    $objCrud->expresion     = "*";

if(isset($_REQUEST["btnBusquedad"])){

    $vrtipoBusqueda = htmlspecialchars($_REQUEST['lstBusquedad']);
    $vrtexBusqueda  = htmlspecialchars($_REQUEST['txtBusquedad']);

    switch ($vrtipoBusqueda){

        case 'd':
        $objCrud->condicion = "documento like '%$vrtexBusqueda%'";
        break;

    }

}

$objCrud->ordenamiento = "apellido ASC, nombre ASC";
$vrcanUsuarios         =$objCrud->read();

if($vrcanUsuarios==0){

    echo "No hay usuarios para consultar <br>";
    die();
}
$arregloUsuarios = $objCrud->filas;

?>


<table>
    <form name ="frmBusquedad" id="frmBusquedad" method= "post"  action='<?php echo $_SERVER["PHP_SELF"] ;?>'>

    <tr>
        <td colpsan="2">Buscar por :</td>
        <td colspsan="2">
        <select name="lstBusquedad" id="lstBusquedad">
            <option value="d">documento </option>
            <option value="a">apellidos </option>
        </select>
        </td>
    <td colpsan ="4">
        <input type="text"  name="txtBusquedad" id="txtBusquedad" size="100"/>
    </td>
    <td colpsan ="3">
        <button type="btnBusquedad"  name="btnBusquedad" id="bntBusqueda" value="Buscar"/> Buscar
        </button>

        
    </td>
    </tr>
    </form>

    <tr>
    <th>Numero </th>
    <th>Doc. Identidad </th>
    <th>Apellidos </th>
    <th>Nombre </th>
    <th>Correo </th>
    <th>Telefono </th>

    <th colpsan ="2">Acciones </th>
    </tr>


    <?php

    $vrno=1;

    foreach($arregloUsuarios as $valor){


        $vrusuId             =$valor["id_usuario"];
        $vrusuDocidentidad   =$valor["documento"];
        $vrusuApellidos      =$valor["apellido"];
        $vrusuNombre         =$valor["nombre"];
        $vrusuCorreo         =$valor["correo"];
        $vrusuTelefono       =$valor["telefono"];

        echo"<tr>";
        echo"<td>$vrusuId</td>";
        echo"<td>$vrusuDocidentidad</td>";
        echo"<td>$vrusuApellidos</td>";
        echo"<td>$vrusuNombre</td>";
        echo"<td>$vrusuCorreo</td>";
        echo"<td>$vrusuTelefono</td>";
        
        echo "<td><a href='xxxx.php?documento=$vrusuDocidentidad'></a></td>'";
        echo "<td><a href='xxxx.php?documento=$vrusuDocidentidad'></a></td>'";
        echo "</tr>";
    

    }

    ?>