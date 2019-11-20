<?php 

   /*
    Creamos la clase conexion la cual nos permitira establecer una conexion a un servidor de base de datos
    de MySQL
   */
    class Conexion{

    	/*
          Definimos el metodo conectar.
    	*/
        public function conectar() {
        	$servidor    = "localhost";
        	$usuario     = "root";
        	$clave       = "";
        	$bdatos      = "sistema_recolector";
        	$objConexion = null;
        	try{
        		$objConexion = new PDO("mysql:host=$servidor; dbname=$bdatos;charset=utf8",$usuario,$clave);
        		//echo "Conexion exitosa <br />";
        		return $objConexion;
        	} catch(PDOException $ex){
        		echo "Error de conexion: " .$ex->getMessage() ."<br />";
        		die();
        	}
        } //fin de la definicion del metodo conectar
    } //fin de la definicion de la clase Conexion

  /*
    Creamos la clase CRUD la cual nos permitira crear metodos que permitan: insertar, extraer, actualizar y eliminar
    informacion de una base de datos.
  */  

    class Crud{
        //Definimos las propiedades de la clase Crud
        
        public $tablas;
        public $campos;
        public $valores;
        public $expresion;
        public $condicion;
        public $agrupamiento;
        public $ordenamiento;
        public $filas;

        //Definimos el metodo constructor de la clase
        public function Crud(){
            $this->tablas       = null;
            $this->campos       = null;
            $this->valores      = null;
            $this->expresion    = null;
            $this->condicion    = null;
            $this->agrupamiento = null;
            $this->ordenamiento = null;
            $this->filas        = null;
        } // fin de la definición del metódo constructor.
         /*
           Definimos el método mensaje_error el cual capturara y visualizara el error de sintaxis o
           de ejecucion de una orden SQL
         */
         private function mensaje_error($perror,$pmsgerror){
            if($perror[0]!="00000"){
                echo  $pmsgerror ."<br />"; 
                echo  $perror[2] . "<br />";
                echo "Contacte al administrador del servidor de base de datos <br />";
                die();
            }
         }
        /*
        Definimos el metodo create el cual nos permitira ingresar cualquier registro en una tabla  de la base de datos.
        */

        public function create(){
            $tablas  = $this->tablas;
            $campos  = $this->campos;
            $valores = $this->valores;
            $sSQL    = "INSERT INTO $tablas($campos) VALUES($valores)";
            //echo $sSQL;
            $objConexion = new Conexion();
            $idenlace    = $objConexion->conectar();
            $pst         = $idenlace->prepare($sSQL);
            $pst->execute();
            $arerror     = $pst->errorInfo();
            /*echo "<pre>";
            print_r($arerror);
            echo "</pre>";*/
            $this->mensaje_error($arerror,"Ocurrió un error al tratar de insertar un registro en la tabla de $tablas");

        } //fin de la definición del método create.
        
         /*
        Definimos el metodo real el cual nos permitira cualquier informacion de la base de datos.
        */
        public function read(){
            $tablas       = $this->tablas;
            $expresion    = $this->expresion;
            $condicion    = $this->condicion;
            $agrupamiento = $this->agrupamiento;
            $ordenamiento = $this->ordenamiento;
            $sSQL      = "SELECT $expresion FROM $tablas ";
            if(isset($condicion)){
                $sSQL  = $sSQL . " WHERE $condicion ";
            }
            if(isset($agrupamiento)){
                $sSQL  = $sSQL . " GROUP BY $agrupamiento ";
            }
            if(isset($ordenamiento)){
                $sSQL  = $sSQL . " ORDER BY $ordenamiento ";
            }
            //echo $sSQL;
            $objConexion = new Conexion();
            $idenlace    = $objConexion->conectar();
            $pst         = $idenlace->prepare($sSQL);
            $pst->execute();
            $arerror     = $pst->errorInfo();
            $this->mensaje_error($arerror,"Ocurrió un error al tratar de extraer informacion de la(s) tabla(s) de $tablas");
            $numfil      = $pst->rowCount();
            if($numfil>0){
                while($registro = $pst->fetch(PDO::FETCH_ASSOC)){
                    $this->filas[] = $registro;
                }
            }
            return $numfil;
        } //fin de la definicion del metodo read

        /*
        Definimos el metodo update el cual nos permitira modificar cualquier informacion de una o de varias tablas de
        la base de datos..
        */

        public function update(){
            $tablas    = $this->tablas;
            $expresion = $this->expresion;
            $condicion = $this->condicion;
            $sSQL      = "UPDATE $tablas SET $expresion ";
            if(isset($condicion)){
                $sSQL  = $sSQL . " WHERE $condicion ";
            }
            //echo $sSQL;
            $objConexion = new Conexion();
            $idenlace    = $objConexion->conectar();
            $pst         = $idenlace->prepare($sSQL);
            $pst->execute();
            $arerror     = $pst->errorInfo();
            $this->mensaje_error($arerror,"Ocurrió un error al tratar de actualizar información en la(s) tabla (s) de $tablas");
        } //find definicion del metodo update


          /*
        Definimos el metodo delete el cual nos permitira borrar cualquier informacion de una o de varias tablas de
        la base de datos..
        */

        public function delete(){
            $tablas    = $this->tablas;
            $condicion = $this->condicion;
            $sSQL      = "DELETE FROM $tablas ";
            if(isset($condicion)){
                $sSQL  = $sSQL . " WHERE $condicion ";
            }
            //echo $sSQL;
            $objConexion = new Conexion();
            $idenlace    = $objConexion->conectar();
            $pst         = $idenlace->prepare($sSQL);
            $pst->execute();
            $arerror     = $pst->errorInfo();
            $this->mensaje_error($arerror,"Ocurrió un error al tratar de eliminar información en la(s) tabla (s) de $tablas");
        } //fin de la definicion del metodo delete


    }// fin de la definicion de la Clase Crud
  // Definimos la clase Utilidades

    class  Utilidades{
           public function Utilidades(){

           }
           public function llenar_combo($partabla,$parcampos,$parvalenviado){
               $objcrud               = new Crud();
               $objcrud->tablas       = $partabla;
               $objcrud->expresion    = $parvalenviado.",";
               $objcrud->expresion    = $objcrud->expresion .$parcampos;
               $objcrud->condicion    = null;
               $objcrud->agrupamiento = null;
               $objcrud->ordenamiento = $parcampos;
               $vrcantidad            =$objcrud->read('$idenlace');
               $ardatos               =$objcrud->filas;
              /* echo "<pre>";
               print_r($ardatos);
               echo "</pre>";*/

               foreach ($ardatos as  $arresultado) {
                    $valmostrar = "";
                    foreach ($arresultado as $indice => $valor) {
                        if($indice==$parvalenviado){
                            $valorenviado = $valor;
                        }
                        
                     $valmostrar = $valmostrar ."&nbsp;".$valor;
                        
                    }
                    echo "<option value='$valorenviado'>$valmostrar</option>";
                    

                }

            }
        public  function consecutivo($tabla,$campo) {
            $objcrud = new Crud();
            $objcrud->expresion    = "max($campo) as maximo";
            $objcrud->tablas       = $tabla;
            $objcrud->condicion    = null;
            $objcrud->agrupamiento = null;
            $objcrud->ordenamiento = null;
            $cantidad              = $objcrud->read('$idenlace');
            $registro              = $objcrud->filas;
            $vrconsecutivo         = $registro[0]["maximo"]+1;
            return $vrconsecutivo;
        }

        public function validarUsuario(){
             if(!isset($_SESSION["usuario"])){
                    header("refresh:3; url=../"); 
                    echo "Acceso denegado, por favor inicie sesi&oacute;n<br />";
                    die();
             } 
        }

        public function validarAdministrador(){
             if($_SESSION["usu_nivel"]!=1){
                
                    header("refresh:3; url=libranza.php"); 
                    echo "Acceso denegado, por favor inicie sesi&oacute;n con otro usuario diferente<br />";
                    die();
             } 
        }
        
     public function fecha_ac(){
            return  date("Y-m-d");
        }  

    public function llenar_seleccionado($tabla,$campos,$enviado,$sel){
            $objcrud=new crud();
            $objcrud->tablas=$tabla;
            $aux=$enviado ." as enviado";
            $objcrud->expresion=$aux ."," .$campos;
            $objcrud->condicion=null;
            $objcrud->agrupamiento=null;
            $objcrud->ordenamiento=$campos;
            $objcrud->read('$idenlace');
            $vrregistro=$objcrud->filas;
          /*    echo "<pre>";
            print_r($vrregistro);
            echo "</pre>";*/
            foreach ($vrregistro as $arreglo) {
                $valenviado="";
                $valmostrar="";
                foreach ($arreglo as $indice => $valor) {
                    if($indice=="enviado"){
                        $valenviado=$valor;
                    } else{
                        $valmostrar=$valmostrar."&nbsp" .$valor;
                    }
                    
                    
                    
                }
               if($valenviado==$sel){
                 echo "<option value='$valenviado' selected $sel> $valmostrar</option>";
               } else {
                 echo "<option value='$valenviado'> $valmostrar</option>";
               }
                
            }

          }          
        
    }       
 ?>
