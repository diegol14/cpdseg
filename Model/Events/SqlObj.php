<?php 

/**
 * documented class
 * Esta clase crea objetos para realizar las consultas a la BBDD
 */
class SqlObj 
{

    private $sensor; 
    private $status ;
    private $dateStart;
    private $dateEnd;
    private $rowcount;
    private $nowQuery;
    private $page;
    private $statuschange;

    //constructor vacío para construir objetos a medida
    public function __construct()
    {
    }

    /**
     * documented function summary
     * 9_
     * Esta función crea un objeto para parametrizar la consulta
     * al historico de eventos
     * documented function long description
     *
     * @param Type $var Description
     * parámetros de entrada de la sentencia sql
     * @return type
     * objeto evento buscado SqlObj a DAOEvents::selectEvents
     **/
    public static function eventSearched($dateStart = null, $dateEnd = null, $sensor = null,$status = null, $statuschange = null)
    {
        $eventSearched = new SqlObj();
        $eventSearched->dateStart = $dateStart;
        //Convierto de string a fecha y le sumo un día para que busque 
        //en ese día hasta las 24hs y no hasta la 0
        //$dateEndTime = new DateTime($dateEnd);
        //$dateEndTime = $dateEndTime->add(new DateInterval('P1D'));
        $eventSearched->dateEnd = $dateEnd;
        $eventSearched->sensor = $sensor ;
        $eventSearched->status = $status;
        $eventSearched->statuschange = $statuschange;
        return $eventSearched;
    }

   /**
    * documented function summary
    *
    * documented function long description
    *
    * @param Type $devueltos por la consulta ya hecha
    * @return type objeto con parámetros devueltos por la consulta
    **/
   public static function rowsAndNow($rowcount , $nowQuery)
   {
    $rowAndNow= new SqlObj(); 
    $rowAndNow->rowcount = $rowcount;
    $rowAndNow->nowQuery = $nowQuery;
    return $rowAndNow; 
   }
    /**
     * Get the value of sensor
     */ 
    public function getSensor()
    {
        return $this->sensor;
    }

    /**
     * Set the value of sensor
     *
     * @return  self
     */ 
    public function setSensor($sensor)
    {
        $this->sensor = $sensor;

        return $this;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus()
    {
        return $this->status;
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
     * Get the value of dateStart
     */ 
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set the value of dateStart
     *
     * @return  self
     */ 
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get the value of dateEnd
     */ 
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set the value of dateEnd
     * Le agrego un día para que tenga en cuenta el último día 
     * y cuente hasta la hora 0 del sig dia
     * @return  self
     */ 
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get the value of rowcount
     */ 
    public function getRowcount()
    {
        return $this->rowcount;
    }

    /**
     * Set the value of rowcount
     *
     * @return  self
     */ 
    public function setRowcount($rowcount)
    {
        $this->rowcount = $rowcount;

        return $this;
    }

    /**
     * Get the value of nowQuery
     */ 
    public function getNowQuery()
    {
        return $this->nowQuery;
    }

    /**
     * Set the value of nowQuery
     *
     * @return  self
     */ 
    public function setNowQuery($nowQuery)
    {
        $this->nowQuery = $nowQuery;

        return $this;
    }

    /**
     * Get the value of page
     */ 
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set the value of page
     *
     * @return  self
     */ 
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get the value of statuschange
     */ 
    public function getStatuschange()
    {
        return $this->statuschange;
    }

    /**
     * Set the value of statuschange
     *
     * @return  self
     */ 
    public function setStatuschange($statuschange)
    {
        $this->statuschange = $statuschange;

        return 1;
    }
}




?>