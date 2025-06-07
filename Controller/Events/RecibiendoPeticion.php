<?php
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Origin: *');

include 'Event.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/dirs.php';
include_once DAO_EVENTS_PATH;
$sensor = 0;

//Recibo la petición ajax del valor del ultimo evento y llamo a la función que solicita el último evento

if (isset($_POST["getSensor"])) {

    $sensor = $_POST["getSensor"];


    $arraySensor = DAO_Events::pintoSensor($sensor);

    echo json_encode($arraySensor);
} else echo "kk";
