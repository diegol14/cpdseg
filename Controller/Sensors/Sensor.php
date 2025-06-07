<?php

class Sensor
{

    private static $idSiguiente = 1;
    private $id;
    private $name;
    private $type;
    

    public function __construct($name, $type)
    {

        $this->id=self::$idSiguiente;
        self::$idSiguiente ++;
        $this->name = $name;
        $this->type = $type;
    }

    public function getName()
    {
        return
        $this->name;

    }

    public function getId()
    {

        return $this->Id;}

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }
}
