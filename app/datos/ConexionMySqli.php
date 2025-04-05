<?php
// ======================================================
// Clase: class.Database.php
// Funcion: Se encarga del manejo con la base de datos
// Descripcion: Tiene varias funciones muy útiles para
//                 el manejo de registros.
//                 
// Ultima Modificación: 17 de marzo de 2015
// ======================================================
    
class Database{
	
    private $_connection;
    /*private $_host = "localhost";
    private $_user = "user_bd_breadking";
    private $_pass = "79B8@tfb";
    private $_db   = "bd_breadking";*/
    private $_host = "srv936.hstgr.io";
    private $_user = "u330449319_u_bd_breadking";
    private $_pass = "Br34dK1ng215Edw";
    private $_db   = "u330449319_bd_breadking";
    // Almacenar una unica instancia
    private static $_instancia;
    // ================================================
    // Metodo para obtener instancia de base de datos
    // ================================================
    public static function getInstancia(){
        if(!isset(self::$_instancia)){
            self::$_instancia = new self;
        }
        return self::$_instancia;
    }
    // ================================================
    // Constructor de la clase Base de datos
    // ================================================
    public function __construct(){
        $this->_connection = new mysqli($this->_host,$this->_user,$this->_pass,$this->_db);
        // Manejar error en base de datos
        if (mysqli_connect_error()) {
            trigger_error('Falla en la conexion de base de datos'. mysqli_connect_error(), E_USER_ERROR );
        }
    }
    // Metodo vacio __close para evitar duplicacion
    private function __close(){}
    // Metodo para obtener la conexion a la base de datos
    public function getConnection(){
        return $this->_connection;
    }
    // Metodo que revisa el String SQL
    private function es_string($sql){
        if (!is_string($sql)) {
            trigger_error('class.Database.inc: $SQL enviado no es un string: ' .$sql);
            return false;
        }
        return true;
    }
	
	//liberar
	public function cerrar(){
		$db = DataBase::getInstancia();
        $mysqli = $db->getConnection();
		$mysqli->close();
		//mysql_close($mysqli);
		//unset($data,$mysqli);
		
	}
    // ==================================================
    //     Funcion que ejecuta el SQL y retorna un ROW
    //         Esta funcion esta pensada para SQLs, 
    //         que retornen unicamente UNA sola línea
    // ==================================================
    public function get_Row($sql){
        
        if(!self::es_string($sql))
            exit();
        $db = DataBase::getInstancia();
        $mysqli = $db->getConnection();
        $resultado = $mysqli->query($sql);
		if (!$resultado ) {
            echo "class.Database.class: error ". $mysqli->error;
        }
		
        if($row = $resultado->fetch_assoc()){
            return $row;
        }else{
            return array();
        }
    }
	
	public function ejecutar($sql){
        
        if(!self::es_string($sql))
            exit();
        $db = DataBase::getInstancia();
        $mysqli = $db->getConnection();
        $resultado = $mysqli->query($sql);
		if (!$resultado ) {
            echo "class.Database.class: error ". $mysqli->error;
        }
		
        return $resultado;
    }
	
	public function get_Row_Procedure_Select_Insert($sql){
        
        if(!self::es_string($sql))
            exit();
        $db = DataBase::getInstancia();
        $mysqli = $db->getConnection();
		while($mysqli->more_results() && $mysqli->next_result()){
			if($result = $mysqli->store_result()){
				$result->free();
				echo " libero memoria ";
			}
		} 
		
        $resultado = $mysqli->query($sql);
		if (!$resultado ) {
            echo "class.Database.class: error ". $mysqli->error;
        }
		
        if($row = $resultado->fetch_assoc()){
			$res = $row["Resultado"];
			$resultado->free_result();
            return $res;
        }else{
            return array();
        }
    }
	
    // ==================================================
    //     Funcion que ejecuta el SQL y retorna un CURSOR
    //         Esta funcion esta pensada para SQLs, 
    //         que retornen multiples lineas (1 o varias)
    // ==================================================
    public function get_Cursor($sql){
        if(!self::es_string($sql))
            exit();
        $db = DataBase::getInstancia();
        $mysqli = $db->getConnection();
        $resultado = $mysqli->query($sql);
        return $resultado; // Este resultado se puede usar así:  while ($row = $resultado->fetch_assoc()){...}
    }
    // ==================================================
    //     Funcion que ejecuta el SQL y retorna un jSon
    //     data: [{...}] con N cantidad de registros
    // ==================================================
    public function get_json_rows($sql){
        if(!self::es_string($sql))
            exit();
        $db = DataBase::getInstancia();
        $mysqli = $db->getConnection();
        $resultado = $mysqli->query($sql);
        // Si hay un error en el SQL, este es el error de MySQL
        if (!$resultado ) {
            return "class.Database.class: error ". $mysqli->error;
        }
        $i = 0;
		$resultado_str="";
        while($row = $resultado->fetch_assoc()){
			//$encodedArray = array_map("utf8_encode", $row);
            $encodedArray = array_map(function ($value) {
                return is_string($value) ? mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1') : $value;
            }, $row);
			$resultado_str =  $resultado_str.json_encode($row);
            $i++;
        };
		return $resultado_str;
    }
	
	
    // ==================================================
    //     Funcion que ejecuta el SQL y retorna un jSon
    //     de una sola linea. Ideal para imprimir un
    //     Query que solo retorne una linea
    // ==================================================
    public function get_json_row($sql){
        if(!self::es_string($sql))
            exit();
        $db = DataBase::getInstancia();
        $mysqli = $db->getConnection();
        $resultado = $mysqli->query($sql);
        // Si hay un error en el SQL, este es el error de MySQL
        if (!$resultado ) {
			echo "class.Database.class: error ". $mysqli->error;
            return "class.Database.class: error ". $mysqli->error;
        }
        if(!$row = $resultado->fetch_assoc()){
			echo "{}";
            return "{}";
        }
		//$resultado->free_results();
		//$resultado->free();
		while ($mysqli->next_result());
		//$resultado->close();
		//$mysqli->close();
        return json_encode( $row );
    }
    // ====================================================================
    //     Funcion que ejecuta el SQL y retorna un valor
    //     Ideal para count(*), Sum, cosas que retornen una fila y una columna
    // ====================================================================
    public function get_valor_query($sql,$columna){
        if(!self::es_string($sql,$columna))
            exit();
        $db = DataBase::getInstancia();
        $mysqli = $db->getConnection();
        $resultado = $mysqli->query($sql);
        // Si hay un error en el SQL, este es el error de MySQL
        if (!$resultado ) {
            return "class.Database.class: error ". $mysqli->error;
        }
        $Valor = NULL;
        //Trae el primer valor del arreglo
        if ($row = $resultado->fetch_assoc()) {
            // $Valor = array_values($row)[0];
            $Valor = $row[$columna];
        }
        return $Valor;
    }
    // ====================================================================
    //     Funcion que ejecuta el SQL de inserción, actualización y eliminación
    // ====================================================================
    public function ejecutar_idu($sql){
        if(!self::es_string($sql))
            exit();
        $db = DataBase::getInstancia();
        $mysqli = $db->getConnection();
        if (!$resultado = $mysqli->query($sql) ) {
            return "class.Database.class: error ". $mysqli->error;
        }else{
            return $resultado;
        }
        
        return $resultado;
    }
    // ====================================================================
    //     Funciones para encryptar y desencryptar data: 
    //         crypt_blowfish_bydinvaders
    // ====================================================================
    function crypt($aEncryptar, $digito = 7) {
        $set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $salt = sprintf('$2a$%02d$', $digito);
        for($i = 0; $i < 22; $i++)
        {
            $salt .= $set_salt[mt_rand(0, 22)];
        }
        return crypt($aEncryptar, $salt);
    }
    function uncrypt($Evaluar, $Contra){
        if( crypt($Evaluar, $Contra) == $Contra)
            return true;
        else
            return false;
        
    }
	
	public function DesHabilitar_Commit(){
		//echo 'haciendo Commint';
		$db = DataBase::getInstancia();
        $mysqli = $db->getConnection();
		//$mysqli->close();
		$mysqli->autocommit(FALSE);
		//$mysqli->commit();
	}
	
	public function Commit(){
		//echo 'haciendo Commint';
		$db = DataBase::getInstancia();
        $mysqli = $db->getConnection();
		//$mysqli->close();
		$mysqli->commit();
	}
	
	public function rollback(){
		$db = DataBase::getInstancia();
        $mysqli = $db->getConnection();
		//echo 'haciendo rollback';
		$mysqli->rollback();
	}
	
}
?>