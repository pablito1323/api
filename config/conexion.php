<?php

class Conectar
{
    protected $dbh;

    public function Conexion()
    {
        try {
            $conectar = $this->dbh = new PDO("mysql:host=localhost;dbname=computacionventas3", "root", "");         
            return $conectar;
        } catch (Exception $e) {
            print "Error BD: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function set_names()
    {
        return $this->dbh->query("SET NAMES 'utf8'");
    }  
}

?>