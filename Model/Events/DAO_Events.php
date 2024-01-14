<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/dirs.php';
include CONN_PATH;
include_once EVENT_PATH;
include_once MODEL_EVENTS_PATH . '/SqlObj.php';

class DAO_Events
{

    private  $conn_sensors_db;


    public static function insertSensorValue($genericEvent)
    {

        $conn_sensors_db = Connection::getInstance()->getConnection();

        echo ($value = $genericEvent->getValue());
        echo ($type = $genericEvent->getType());
        echo ($FK_sensor_id = $genericEvent->getSensor_id());
        echo ($status  = $genericEvent->getStatus());

        /*echo */($myquery =
            "INSERT INTO events (value, type, status, FK_sensor_id) values ('$value', '$type' ,'$status', $FK_sensor_id)");

        $result = $conn_sensors_db->prepare($myquery);
        $isOk = $result->execute();

        if (!$isOk) {
            echo "<p style='margin:5%;color:red;font-weight:bold;'>Error en la inserción de valores, se han insertado: "
                . $result->rowCount() . " registros</p>";
        } // End if result
        else {
            /*echo "<p style='margin:5%;color:blue;font-weight:bold;'> registration insertado : " . $result->rowCount() . "</p>";*/
        }

        $result = null;
        $isOk = null;
        $conn_sensors_db = null;
    }

    public static function pintoSensor($sensor)
    {
        $conn_sensors_db = Connection::getInstance()->getConnection();

        $valueHora = array();

        $query = "SELECT value, hora, status  FROM events WHERE FK_sensor_id = $sensor ORDER BY hora desc LIMIT 1";
        $myquery = $conn_sensors_db->prepare($query);
        $result = $myquery->execute();
        $result = $myquery->fetchAll(PDO::FETCH_OBJ);

        if ($myquery->rowCount() > 0) {

            foreach ($result as $result) {
                //Conversion hora server
                $hora = $result->hora;
                $diff1Hours = new DateInterval('PT1H');
                $d0 = new DateTime($hora);
                $d0->add($diff1Hours);
                $d0 = $d0->format('Y-m-d H:i:s');

                $valueHora = [
                    "last_Value" => $result->value,
                    "last_hora" => $d0, 
                    "last_status" => $result->status
                ];
                //$resp = json_encode($valueHora); 
            }
        }
        $myquery->closeCursor();
        $myquery = null;
        $result = null;
        $conn_sensors_db = NULL;
        return $valueHora;
    } //End function pintoSensor

    /**
    * documented function summary
    *
    * documented function long description
    * Es llamada por el servicio, se le pasa un SqlObj  con los datos de la consulta original.
    * Lo primero es checkear el objeto recibido con la función checkobjSql() ->8
    * @param Type $var Description
    * @return type SqlObj objSqlReq
    * @throws conditon
    **/
 public static function selectEvents($objSqlForm)//7
 {

     $objSqlChckd = new SqlObj();
     $objSqlChckd = DAO_Events::checkobjSql($objSqlForm);//8

     $sensor = (!empty($objSqlChckd->getSensor())) ? $objSqlChckd->getSensor() : null;
     $status = (!empty($objSqlChckd->getStatus())) ?  $objSqlChckd->getStatus() : null;
     $statuschange = (!empty($objSqlChckd->getStatuschange())) ?  $objSqlChckd->getStatuschange() : null;
     if (!empty($objSqlChckd->getDateStart())) $dateStart = $objSqlChckd->getDateStart();
     if (!empty($objSqlChckd->getDateEnd())) {
         $dateEnd = $objSqlChckd->getDateEnd();
         $dateEndTime = new DateTime($dateEnd);
         $dateEndTime = $dateEndTime->add(new DateInterval('P1D'));
         $dateEnd = $dateEndTime->format('Y-m-d');
     }
     //echo $dateEnd;

     $objSqlEvSrch = SqlObj::eventSearched($dateStart, $dateEnd, $sensor, $status, $statuschange);//9
    
      $conn_sensors_db = Connection::getInstance()->getConnection();
     /*   SELECT FK_sensor_id, status, value, hora FROM events 
     INNER JOIN statuschanges
     on events.id = statuschanges.event_id 
     order by events.hora desc */

     if (!empty($dateStart) and !empty($dateEnd)) {

         $queryInit = 'SELECT FK_sensor_id, status, value, hora FROM events ';
         $queryWhere = ' WHERE (hora BETWEEN :dateStart AND :dateEnd)';
         $queryOrder = ' order by hora desc';
         $querySensor = 'AND FK_sensor_id = :sensor ';
         $queryStatus = 'AND status = :status ';
         $queryStatuschange = ' INNER JOIN statuschanges on events.id = statuschanges.event_id ';
         $myquery = $queryInit . $queryWhere . $queryOrder;
         if (!empty($statuschange) and $statuschange != null and $statuschange=='statuschange') 
         $myquery = $queryInit .  $queryStatuschange . $queryWhere . $queryOrder;

         if (!empty($sensor)) {
             $myquery = $queryInit . $queryWhere . $querySensor . $queryOrder;
             if (!empty($statuschange) and $statuschange != null and $statuschange == 'statuschange')
                 $myquery = $queryInit . $queryStatuschange . $queryWhere . $querySensor . $queryOrder;
         } 
         if (!empty($status)) {
             $myquery = $queryInit . $queryWhere . $queryStatus . $queryOrder;
             if (!empty($statuschange) and $statuschange != null and $statuschange == 'statuschange') 
                 $myquery = $queryInit . $queryStatuschange . $queryWhere . $queryStatus . $queryOrder;
         }
         if (!empty($sensor) and !empty($status)) {
             $myquery = $queryInit . $queryWhere . $querySensor . $queryStatus . $queryOrder;
             if (!empty($statuschange) and $statuschange != null and $statuschange == 'statuschange')
                 $myquery =  $queryInit .  $queryStatuschange . $queryWhere . $querySensor . $queryStatus . $queryOrder;
         }

         $queryOk = false;

         //echo '<br>query'.$myquery;

          $obj_stmt = $conn_sensors_db->prepare($myquery);
         try {

             if (!empty($dateStart)) $obj_stmt->bindParam(':dateStart', $dateStart, PDO::PARAM_STR);
             if (!empty($dateEnd)) $obj_stmt->bindParam(':dateEnd', $dateEnd, PDO::PARAM_STR);
             if (!empty($sensor)) $obj_stmt->bindParam(':sensor', $sensor, PDO::PARAM_INT);
             if (!empty($status)) $obj_stmt->bindParam(':status', $status, PDO::PARAM_STR);

             $obj_stmt->setFetchMode(PDO::FETCH_OBJ);
             $result = $obj_stmt->execute();
             $rowcount = $obj_stmt->rowCount();
            
             if ($result) {

                 //Modifico el objSqlRequest creado en ln89 con la búsqueda
                 // para devolver el rowcount y la hora actual

                 $result = $conn_sensors_db->query("Select NOW() AS NOW");
                 while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                     foreach ($row as $now => $strnow)
                         $strnow;
                 }
                 //Cambio el nombre al obj EvSrch porque ya es la respuesta de la base de datos
                 //con los parámetros de la consulta original del form
                 $objSqlReq = new SqlObj;
                 $objSqlReq = $objSqlEvSrch;
                 $objSqlReq->setRowcount($rowcount);
                 $objSqlReq->setNowQuery($strnow);
                 
                 $queryOk = true;
                 $obj_stmt->closeCursor();
             } //End if result
             else echo "<p style='margin:5%;color:red;font-weight:bold;'>Error en la consulta</p>";

             $obj_stmt = null;
             $result = null;
             if (isset($conn_sensors_db)) $conn_sensors_db = null;

         } catch (\Throwable $th) {
             if (isset($result)) $result = null;
             if (isset($obj_stmt)) $obj_stmt = null;
             if (isset($conn_sensors_db)) $conn_sensors_db = null;
             echo $th->getFile();
             echo $th->getLine();
             echo $th->getMessage();
         } //End catch query 1

     } //End if !empty dates


     if (isset($result)) $result = null;
     if (isset($obj_stmt)) $obj_stmt = null;
     if (isset($conn_sensors_db)) $conn_sensors_db = null;
      //echo "2pijaaa". var_dump($objSqlReq);
      return $objSqlReq;  
// } //ESTA LLAVE HAY QUE QUITARLA era para pruebas sin query
 } //End Function selectEvents

 /**
  * documented function summary
  * 8_ Función llamada por selectEvents checkea SqlObj para 
  * la consulta original
  * documented function long description
  *
  * @param Type $var Description
  * @return type
  * @throws conditon
  **/
 public static function checkobjSql($objSqlForm)//8
 {
     $objSqlChckd = new SqlObj();

     $sensor = $objSqlForm->getSensor();
     $status = $objSqlForm->getStatus();
     $dateStart = $objSqlForm->getDateStart();
     $dateEnd = $objSqlForm->getDateEnd();
     $rowcount = $objSqlForm->getRowcount();
     $nowQuery = $objSqlForm->getNowQuery();
     $page = $objSqlForm->getPage();
     $statuschange =  $objSqlForm->getStatuschange();
     if (!empty($sensor) and ($sensor != null)) $objSqlChckd->setSensor($sensor);
     if (!empty($status) and ($status != null)) $objSqlChckd->setStatus($status);
     if (!empty($dateStart) and ($dateStart != null)) $objSqlChckd->setDateStart($dateStart);
     if (!empty($dateEnd) and ($dateEnd != null)) $objSqlChckd->setDateEnd($dateEnd);
     if (!empty($rowcount) and ($rowcount != null)) $objSqlChckd->setRowcount($rowcount);
     if (!empty($nowQuery) and ($nowQuery != null)) $objSqlChckd->setNowQuery($nowQuery);
     if (!empty($page) and ($page != null)) $objSqlChckd->setPage($page);
     if (!empty($statuschange) and ($statuschange != null)) $objSqlChckd->setStatuschange($statuschange);

     return $objSqlChckd;
 }

/**
* undocumented function summary
* 16 _ El servicio le pasa el objeto recibido del botón-formulario de la paginación
* Chequea el objeto
* Construye una query y la devuelve como un array de la clase Event al servicio
*
* @param Type $var SqlObj que viene desde HistoryEvents cone l resultado de la consulta original
* @return type array[] con todos los registros de cada pagina definidos en el limit
**/
 public static function eventsPage($objSqlEventSearched)
 {

     $allEvents = [];

     $objSqlChckd = new SqlObj();
     $objSqlChckd = DAO_Events::checkobjSql($objSqlEventSearched);//
  /*            echo '<br>no<br>';
     echo var_dump($objSqlChckd);
     echo '<br>no<br>' */; 

     if (isset($objSqlChckd)) {

         if (!empty($objSqlChckd->getSensor())) $sensor = $objSqlChckd->getSensor();
         if (!empty($objSqlChckd->getStatus()))  $status = $objSqlChckd->getStatus();
         if (!empty($objSqlChckd->getDateStart())) $dateStart = $objSqlChckd->getDateStart();
         if (!empty($objSqlChckd->getDateEnd())) $dateEnd = $objSqlChckd->getDateEnd();
         if (!empty($objSqlChckd->getRowcount())) $rowcount = $objSqlChckd->getRowcount(); //else echo 'pi';
         if (!empty($objSqlChckd->getNowQuery())) $nowQuery = $objSqlChckd->getNowQuery(); //else echo 'pi';
         if (!empty($objSqlChckd->getStatuschange()))  $statuschange = $objSqlChckd->getStatuschange();

         $page = (!empty($objSqlChckd->getPage())) ? $objSqlChckd->getPage() : 1;

         $recordsPage = 100;
         $fromEvent = (($page - 1) * $recordsPage);

         if (!empty($rowcount) and (!empty($nowQuery))) {
             $totalPages = ($rowcount > $recordsPage) ? ceil($rowcount / $recordsPage) : 1;
             //Compruebo que la hora de la query no sea mayor que la hora en que fue hecha para no agregar registros al total
             $dateEnd = ($dateEnd >= $nowQuery) ? $nowQuery : $dateEnd;
         } //End if !empty rowcount y noquery

         if (!empty($dateStart) and !empty($dateEnd)) {

             $queryInit = 'SELECT FK_sensor_id, status, value, hora FROM events ';
             $queryWhere = ' WHERE (hora BETWEEN :dateStart AND :dateEnd)';
             $queryOrder = "order by hora desc  LIMIT " . " " . $fromEvent . ", " . $recordsPage;
             $querySensor = 'AND FK_sensor_id = :sensor ';
             $queryStatus = 'AND status = :status ';
             $queryStatuschange = ' INNER JOIN statuschanges on events.id = statuschanges.event_id ';
             $myquery = $queryInit . $queryWhere . $queryOrder;
             if (!empty($statuschange) and $statuschange != null) $myquery = $queryInit .  $queryStatuschange . $queryWhere . $queryOrder;

             if (!empty($sensor) and !empty($status)) {
                 $myquery = $queryInit . $queryWhere . $querySensor . $queryStatus . $queryOrder;
             if (!empty($statuschange) and $statuschange != null and $statuschange == 'statuschange')
                     $myquery =  $queryInit .  $queryStatuschange . $queryWhere . $querySensor . $queryStatus . $queryOrder;
             } 
             elseif (!empty($sensor)) {
                 $myquery = $queryInit . $queryWhere . $querySensor . $queryOrder;
                 if (!empty($statuschange) and $statuschange != null and $statuschange == 'statuschange')
                 $myquery = $queryInit . $queryStatuschange . $queryWhere . $querySensor . $queryOrder;
             }

             elseif (!empty($status)) {
                 $myquery = $queryInit . $queryWhere . $queryStatus . $queryOrder;
                 if (!empty($statuschange) and $statuschange != null and $statuschange == 'statuschange')
                     $myquery = $queryInit . $queryStatuschange . $queryWhere . $queryStatus . $queryOrder;
             }

             //echo $myquery;


              try {

                 $conn_sensors_db = Connection::getInstance()->getConnection();

                 $obj_stmt = $conn_sensors_db->prepare($myquery);

                 if (!empty($dateStart)) $obj_stmt->bindParam(':dateStart', $dateStart, PDO::PARAM_STR);
                 if (!empty($dateEnd)) $obj_stmt->bindParam(':dateEnd', $dateEnd, PDO::PARAM_STR);
                 if (!empty($sensor)) $obj_stmt->bindParam(':sensor', $sensor, PDO::PARAM_INT);
                 if (!empty($status)) $obj_stmt->bindParam(':status', $status, PDO::PARAM_STR);

                 $obj_stmt->setFetchMode(PDO::FETCH_OBJ);
                 $result = $obj_stmt->execute();

                 /*
    $obj_stmt->bindParam(':fromEvent', $fromEvent, PDO::PARAM_STR);
     $obj_stmt->bindParam(':recordsPage', $recordsPage, PDO::PARAM_STR); */

                $event = new stdClass();
                 $queryOk = ($result) ? true : false;

                 if ($queryOk) {

                     while ($event = $obj_stmt->fetch()) {
                         $myevent = new Event();
                         $myevent->setSensor_id($event->FK_sensor_id);
                         $myevent->setStatus($event->status);
                         $myevent->setValue($event->value);
                         $myevent->setDate($event->hora);


                         array_push($allEvents, $myevent);
                     } //echo var_dump($allEvents);
                     $result = null;
                     $obj_stmt = null;
                     $conn_sensors_db = null;
                     return $allEvents;
                 } //End if queryOk
                 if (isset($result)) $result = null;
                 if (isset($$obj_stmt)) $obj_stmt = null;
                 if (isset($conn_sensors_db)) $conn_sensors_db = null;
                 return $allEvents;
             } catch (\Throwable $th) {
                 if (isset($result)) $result = null;
                 if (isset($obj_stmt)) $obj_stmt = null;
                 if (isset($conn_sensors_db)) $conn_sensors_db = null;
                 echo $th->getFile();
                 echo $th->getLine();
                 echo $th->getMessage();
                 return $allEvents;
             } //End catch query 2 */

         } //End if empty dates
     } //End if isset ibjSql
 } //End funcion eventPage

}//End class DAO_Events


/* 
     

try {

 foreach ($allEvents as $myevent) {

     $sensor =$myevent->getSensor_id();
     $status = $myevent->getStatus();
     $value = $myevent->getValue();
     $hora = $myevent->getDate();

     $myInsert=  "INSERT INTO events_temp (FK_sensor_id,status, value, hora) values ('$sensor','$status','$value','$hora' )";
    
     $obj_stmt_temp = $conn_sensors_db->prepare($myInsert);

     $result = $obj_stmt_temp->execute();
     if ($result) "okresult";
     else echo "Error en la insercion temporal de eventos";
             }
         } catch (\Throwable $th) {
             echo $th->getFile();
             echo $th->getLine();
             echo $th->getMessage();
         }
     
              */
               
/*  echo '<br>total paginas: ' .  
             */

/*                 $strFromPage = strval($fromPage);
             $strRecordsPage = strval(($recordsPage));
             $myqueryPage = $myquery . ' LIMIT ' . $strFromPage. ',' . $strRecordsPage;
             echo $myqueryPage;
             $obj_stmt = $conn_sensors_db->prepare($myqueryPage); */
             //echo '<br>querypage'.$myqueryPage;
              /*try {

                 if (!empty($dateStart)) $obj_stmt->bindParam(':dateStart', $dateStart, PDO::PARAM_STR);
                 if (!empty($dateEnd)) $obj_stmt->bindParam(':dateEnd', $dateEnd, PDO::PARAM_STR);
                 if (!empty($sensor)) $obj_stmt->bindParam(':sensor', $sensor, PDO::PARAM_STR);
                 if (!empty($status)) $obj_stmt->bindParam(':status', $status, PDO::PARAM_STR);

                 $obj_stmt->setFetchMode(PDO::FETCH_OBJ);
                 $result = $obj_stmt->execute();
                 $event = new stdClass();
                 echo '<h4>Mostrando p&aacute;gina '. $page.' de '.$totalPages.'</h4>'; */

                 /*                 } catch (\Throwable $th) {
                 echo $th->getFile();
                 echo $th->getLine();
                 echo $th->getMessage();
             } //End catch 2 */
/*                 for ($i=1; $i <= $totalPages ; $i++) { 
             
                 echo "<a href='?page=".$i."'>".$i."</a>"." ";
             }//Enf for paginas */
         //}//End if isset get $page