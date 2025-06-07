<?php
include_once ($_SERVER['DOCUMENT_ROOT'].'/config/dirs.php');
include_once CONFIG_PATH;

class Connection
{
    private $conn = null;
    private static $instance = null;
    private $dsn;
    private $user;
    private $password;

    private function __construct()
    {
        $this->dsn = Config::getDsn();
        $this->user = Config::getUser();
        $this->password = Config::getPassword();

        try {
            $this->conn = new \PDO($this->dsn, $this->user, $this->password);
            $this->conn->exec("set names utf8");
           // echo "Connected to ". $this->dsn;
        } catch (PDOException $e) {
            echo "<p style='margin:5%;color:red;font-weight:bold;'>Falló la conexión a la Base de Datos:  &nbsp;"
            . $e->getMessage()." Code ". $e->getCode()."</p>";
        }
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Connection;
        }
        return self::$instance;
    }

    public function getConnection()
    {
        
        return self::getInstance()->conn;
    }
}


