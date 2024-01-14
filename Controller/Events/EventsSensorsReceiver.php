<?php
include 'Event.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/config//dirs.php';

include_once DAO_EVENTS_PATH;
include_once RESET_TABLE_EVENTS_PATH;
include_once EVENT_SERVICE_PATH;

//Recibo valor del sensor, genero objeto evento y lo inserto en BBDD

$ldrValue = 0;
$humValue = 0;
$temperaturaValue = 0;
$volValue = 0;
$incendioValue = 0;
$inundacionValue = 0;

/* if (isset($_POST["ldr"])) {
    $ldrValue = $_POST["ldr"];
    settype($ldrValue, "double");

    $genericEvent = Event::receivingEvent($ldrValue, 'ldr');
    if (isset($genericEvent)) {

        echo 'genEvent si<br>';
        echo var_dump($genericEvent);

        EventService::insertOrUpdate($genericEvent);
    } else {
        echo "Evento no generado";
    }
} else echo "Receiving error1"; */
echo 'holita';
if (isset($_GET["ldr"])) {
    $ldrValue = $_GET["ldr"];
    settype($ldrValue, "double");

    $genericEvent = Event::receivingEvent($ldrValue, 'ldr');
    if (isset($genericEvent)) {

        echo 'genEvent si<br>';
        echo var_dump($genericEvent);

        EventService::insertOrUpdate($genericEvent);
    } else {
        echo "Evento no generado";
    }
} else echo "Receiving erroress1";

if (isset($_GET["hum"])) {
    $humValue = $_GET["hum"];
    settype($humValue, "double");

    $genericEvent = Event::receivingEvent($humValue, 'hum');
    if (isset($genericEvent)) {

        echo 'genEvent si<br>';
        echo var_dump($genericEvent);

        EventService::insertOrUpdate($genericEvent);
    } else {
        echo "Evento no generado";
    }
} else echo "Receiving error2";

if (isset($_GET["temp"])) {
    $tempValue = $_GET["temp"];
    settype($tempValue, "double");

    $genericEvent =Event::receivingEvent($tempValue, 'temp');
    if (isset($genericEvent)) {

        echo 'genEvent si<br>';
        echo var_dump($genericEvent);

        EventService::insertOrUpdate($genericEvent);
    } else {
        echo "Evento no generado";
    }
} else echo "Receiving error3";

if (isset($_POST["vol"])) {
    $volValue = $_POST["vol"];

    settype($volValue, "string");

    $genericEvent = Event::receivingEvent($volValue, 'vol');
    if (isset($genericEvent)) {

        echo 'genEvent si<br>';
        echo var_dump($genericEvent);

        EventService::insertOrUpdate($genericEvent);
    } else {
        echo "Evento no generado";
    }
} else echo "Receiving error4";


if (isset($_GET["vol"])) {
    $volValue = $_GET["vol"];

    settype($volValue, "string");

    $genericEvent = Event::receivingEvent($volValue, 'vol');
    if (isset($genericEvent)) {

        echo 'genEvent si<br>';
        echo var_dump($genericEvent);

        EventService::insertOrUpdate($genericEvent);
    } else {
        echo "Evento no generado";
    }
} else echo "Receiving error4";

if (isset($_POST["incendio"])) {
    $incendioValue = $_POST["incendio"];

    settype($incendioValue, "string");

    $genericEvent = Event::receivingEvent($incendioValue, 'incendio');
    if (isset($genericEvent)) {

        echo 'genEvent si<br>';
        echo var_dump($genericEvent);

        EventService::insertOrUpdate($genericEvent);
    } else {
        echo "Evento no generado";
    }
} else echo "Receiving error5";

if (isset($_GET["incendio"])) {
    $incendioValue = $_GET["incendio"];

    settype($incendioValue, "string");

    $genericEvent = Event::receivingEvent($incendioValue, 'incendio');
    if (isset($genericEvent)) {

        echo 'genEvent si<br>';
        echo var_dump($genericEvent);

        EventService::insertOrUpdate($genericEvent);
    } else {
        echo "Evento no generado";
    }
} else echo "Receiving error5";

if (isset($_POST["inundacion"])) {
    $inundacionValue = $_POST["inundacion"];

    settype($inundacionValue, "string");

    $genericEvent = Event::receivingEvent($inundacionValue, 'inundacion');
    if (isset($genericEvent)) {

        echo 'genEvent si<br>';
        echo var_dump($genericEvent);

        EventService::insertOrUpdate($genericEvent);
    } else {
        echo "Evento no generado";
    }
} else echo "Receiving error6";

if (isset($_GET["inundacion"])) {
    $inundacionValue = $_GET["inundacion"];

    settype($inundacionValue, "string");

    $genericEvent = Event::receivingEvent($inundacionValue, 'inundacion');
    if (isset($genericEvent)) {

        echo 'genEvent si<br>';
        echo var_dump($genericEvent);

        EventService::insertOrUpdate($genericEvent);
    } else {
        echo "Evento no generado";
    }
} else echo "Receiving error6";
