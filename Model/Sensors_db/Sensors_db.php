<?php
//include ('../Connection.php');

class Sensors_db
{

    private $conn_sensors_db;

    public function __construct()
    {
        $this->conn_sensors_db = Connection::getInstance()->getConnection();
    }

    public function insert_sensor_value(){
        
    }

}
