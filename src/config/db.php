<?php

class db{

    private $host='localhost';
    private $usuario ='root';
    private $password='';
    private $base ='ejemplo2';


    //conexion base de datos
    public function conectar(){
        $conexion = "mysql:host=$this->host;dbname=$this->base";
        $conexionBD = new PDO($conexion, $this->usuario, $this->password);
        $conexionBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //esta linea arregla la codificacion de caracteres UTF-8
    //    $conexion->exec("set names utf8");
        return $conexionBD;
      }
}

?>