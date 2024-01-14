<?php

class Event
{

    private $id = null;
    private $value = 0;
    private $type;
    private $date;
    private $status;
    private $sensor_id = 0;


    public function __construct()
    {
    }

    public static function receivingEvent($value, $name)
    {

        $genericEvent = new Event();
        $genericEvent->value = $value;
        $genericEvent->status = "reposo";


        switch ($name) {

            case 'ldr':
                $genericEvent->setType('analogico');
                $genericEvent->setSensor_id(1);
                $genericEvent->status = ($genericEvent->value >= 700) ? "alarma" : "reposo";
                break;

            case 'hum':
                $genericEvent->setType('analogico');
                $genericEvent->setSensor_id(2);
                $genericEvent->status = ($genericEvent->value >= 65) ? "alarma" : "reposo";
                break;

            case 'temp':
                $genericEvent->setType('analogico');
                $genericEvent->setSensor_id(3);
                $genericEvent->status = ($genericEvent->value >= 25) ? "alarma" : "reposo";
                break;

            case 'vol':
                $genericEvent->setType('biestado');
                $genericEvent->setSensor_id(4);
                $genericEvent->status = ($genericEvent->value == 1) ? "alarma" : "reposo";
                break;

            case 'incendio':
                $genericEvent->setType('biestado');
                $genericEvent->setSensor_id(5);
                $genericEvent->status = ($genericEvent->value == 1) ? "alarma" : "reposo";
                break;

            case 'inundacion':
                $genericEvent->setType('biestado');
                $genericEvent->setSensor_id(6);
                $genericEvent->status = ($genericEvent->value == 1) ? "alarma" : "reposo";
                break;

            default:
                $genericEvent->setType('biestado');

                break;
        } //End switch name
        
        return $genericEvent;
        
    } //End function receivingEvent
    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the value of date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }


    /**
     * Get the value of sensor_id
     */
    public function getSensor_id()
    {
        return $this->sensor_id;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set the value of sensor_id
     *
     * @return  self
     * @return  self
     */
    public function setSensor_id($sensor_id)
    {
        $this->sensor_id = $sensor_id;

        //return $genericEvent->sensor_id;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the name of sensor_id
     */
    public function getSensorName($sensor)
    {
        $sensorName = null;
        switch ($sensor) {
            case '1':
                $sensorName = '1 - Nivel de Luz';
                break;
            case '2':
                $sensorName = '2 - Humedad';
                break;    
            case '3':
                $sensorName = '3 - Temperatura';
                break;    
            case '4':
                $sensorName = '4 - Volum&eacute;trico';
                break; 
            case '5':
                $sensorName = '5 - Incendio';
                break;    
            case '6':
                $sensorName = '6 - Inundaci&oacute;n';
                break;  
            default: 
                $sensorName = 'Sensor no encontrado';
                break;
        }//End switch sensorName
        return $sensorName;
    }//End function getSensorName of Event


}//End class Event
