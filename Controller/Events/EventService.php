<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/dirs.php';
include_once DAO_EVENTS_PATH;
include_once RESET_TABLE_EVENTS_PATH;
include_once MODEL_EVENTS_PATH.'/SqlObj.php';

class EventService
{
    public static function insertOrUpdate($genericEvent)
    {
        $maxId =  ResetTableEvents::getMaxId();
        if ($maxId > 99999999) {
            ResetTableEvents::updateEvents($genericEvent);
        } else {
            DAO_Events::insertSensorValue($genericEvent);
        }
    }//End function insertOrUpdate

  
    /**
     * documented function summary
     * 6_ Function que brinda el servicio de búsqueda de eventos

     * documented function long description
     * Esta función llama al DAO ->7  y le pasa un objeto 
     * recibido desde el form de búsqueda de eventos
     * para construir su consulta SQL de búsqueda
     * @param Type $var objeto stdClass
     * @return $objeto con rowcount y date de la consulta
     **/
    public static function searchEvents($objSqlForm)//6
    {
       $objSqlReq = new SqlObj();
        try {
            $objSqlReq = DAO_Events::selectEvents($objSqlForm);//7 al 9
            
           return ($objSqlReq);

    }catch (\Throwable $th) {
        echo $th->getFile();
        echo $th->getLine();
        echo $th->getMessage();
    }return $objSqlReq;
}//End function searchEvents

/**
 * documented function summary
 * 15_ Función llamada por showTempEvents(), que le pasa un SqlObj para la consulta
 *
 * @param Type SqlObj objeto que contiene los parámetros de una búsqueda
 * @return type Array de eventos
 * @throws conditon si el DAO no devuelve el array, devuelve uno vacío
 **/
public static function searchTempEvents($objSqlEventSearched){//15
    $allEvents = [];

    $objSqlPage = new SqlObj();
    $objSqlPage = $objSqlEventSearched;

    try {
        $allEvents = DAO_Events::eventsPage($objSqlPage);//16
       //echo var_dump($allEvents);
        return $allEvents;
}catch (\Throwable $th) {
    echo $th->getFile();
    echo $th->getLine();
    echo $th->getMessage();
}return $allEvents;

}

}//End class EventService
