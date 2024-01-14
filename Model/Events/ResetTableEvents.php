<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/dirs.php';
include_once CONN_PATH;

class ResetTableEvents
{

    public static function getMaxId()
    {

        $conn_sensors_db = Connection::getInstance()->getConnection();

        $mysql = "SELECT Id  FROM events ORDER BY Id desc LIMIT 1";
        $myquery = $conn_sensors_db->prepare($mysql);
        $result = $myquery->execute();
        $result = $myquery->fetchAll(PDO::FETCH_OBJ);

        if ($myquery->rowCount() > 0) {

            foreach ($result as $result) {

                $maxId = $result->Id;
            }
        }
        $myquery->closeCursor();
        $myquery = null;
        $conn_sensors_db = NULL;

        echo  $maxId;
        return $maxId;
    }

    public static function getOldestId()
    {

        $conn_sensors_db = Connection::getInstance()->getConnection();

        $mysql = "SELECT Id FROM events ORDER BY hora asc LIMIT 1";
        $myquery = $conn_sensors_db->prepare($mysql);
        $result = $myquery->execute();
        $result = $myquery->fetchAll(PDO::FETCH_OBJ);

        if ($myquery->rowCount() > 0) {

            foreach ($result as $result) {

                $oldestId = $result->Id;
            }
        }
        $myquery->closeCursor();
        $myquery = null;
        $conn_sensors_db = NULL;

        echo  $oldestId;
        return $oldestId;
    }



    public static function updateEvents($genericEvent)
    {


        $conn_sensors_db = Connection::getInstance()->getConnection();

        echo ($value = $genericEvent->getValue());
        echo ($type = $genericEvent->getType());
        echo ($FK_sensor_id = $genericEvent->getSensor_id());

        echo $Id = self::getOldestId();

        $myquery = "UPDATE events SET  value ='$value', type = '$type', FK_sensor_id ='$FK_sensor_id', hora= CURRENT_TIMESTAMP WHERE Id = '$Id'";/* donde $Id es regMasAntiguo*/
        
        echo $myquery;
        $result = $conn_sensors_db->prepare($myquery);
        $isOk = $result->execute();

        if (!$isOk) {
            echo "Error en la actualizacion de valores, se han actualizado: " . $result->rowCount() . " registros";
        } // End if result
        else {
            echo "<br/>, registration actualizado : " . $result->rowCount();
        }

        $conn_sensors_db = null;
    }
}

/* resetTableEvents::getMaxId();
echo "<br>";
ResetTableEvents::getOldestId(); */
