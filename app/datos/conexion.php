<?php

class Conexion {

    private $host = 'mysql.lacomuna.net';
    private $user = 'lacomuna';
    private $password = 'LaComuna.123';
    private $database = 'lacomuna';
    private $link;
    private $statement;
    static $_instance;

    private function __construct() {
        $this->conectar();
    }

    private function __clone() {
        
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function conectar() {
        $this->link = mysql_connect($this->host, $this->user, $this->password);
        mysql_select_db($this->database, $this->link);
      mysql_set_charset('utf8', $this->link);
      //mysql_set_charset($this->link,"utf8");

    }

    public function ejecutar($query) {
        $this->statement = mysql_query($query,$this->link);

        return $this->statement;
    }

    public function close() {
        mysql_close($this->link);
    }

    public function last_id() {
        return mysql_insert_id();
    }
  
    public function obtener_filas($result){
      $cadena = '';
      while($row = mysql_fetch_assoc($result))
    {
        $encodedArray = array_map("utf8_encode", $row);
        $cadena = $cadena.json_encode($row);
    }
      
      return ($cadena);
    } 


}
