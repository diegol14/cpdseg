<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/dirs.php';


header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Origin: *');
if (!isset($_SESSION["rol"])) {

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=description content="CPDSeg es una aplicación WEB de monitorización de sensores
     en remoto. Está orientada a supervisar instalaciones, como por ejemplo,Centros de Procesamiento de Datos" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="DiegolPereira" />
    <title>CPDSeg</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https: //fonts.googleapis.com/css2? family = Roboto & display = swap " rel=" stylesheet ">
    <link href='/View/styles/normalyze.css' rel='stylesheet' type='text/css' />

    <link rel="preconnect" href="https://cpdseg.online">
    <link rel="preconnect" href="https://cpdseg.online" crossorigin>
    <link href="https: //fonts.googleapis.com/css2? family = Roboto & display = swap " rel=" stylesheet ">
    <link href='/View/styles/normalyze.css' rel='stylesheet' type='text/css' />
        <!-- Empieza favicon-->
        <link rel="apple-touch-icon" sizes="57x57" href="/View/public/assets/favicons/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/View/public/assets/favicons/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/View/public/assets/favicons/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/View/public/assets/favicons/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/View/public/assets/favicons/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/View/public/assets/favicons/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/View/public/assets/favicons/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/View/public/assets/favicons/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/View/public/assets/favicons/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/View/public/assets/favicons/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/View/public/assets/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/View/public/assets/favicons/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/View/public/assets/favicons/favicon-16x16.png">
<link rel="manifest" href="/View/public/assets/favicons/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/View/public/assets/favicons/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<!--Termina favicon-->
</head>

<body>
    <?php include_once 'View/public/Users/formLogin.php';//VIEW_PATH.
     
} else {

    header("Location: /View/public/Sensors/ShowSensors.php");

    if ($_SESSION["rol"] == "admin") {
        include_once  'View/public/Headers/AdminHeader.php';
        die();
    } elseif ($_SESSION["rol"] == "user") {
        # code...
        include_once 'View/public/Headers/UserHeader.php';
        die();
    }
?>
    <main>

        <div class="content" id="content">
            <header claas="header">
                <h1>CPDSeg</h1>
                <small>Monitoriza tu instalaci&oacute;n</small>

            </header>
            <?php
/*     include_once  'View/public/Sensors/ShowSensors.php';
    die(); */
}
    ?>
        </div>
        <div class="footer">
            <footer>
                <h4>Tu empresa</h4>

            </footer>
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script src="View/js/jquery-3.6.0.min.js"></script>
    <script src="View/js/functions.js"></script>
    <script src="View/js/formvalid.js"></script>
    <link href='View/styles/contenido.css' rel='stylesheet' type='text/css' />
   <?php include_once CONTROLLER_PATH . '/Users/UserService.php'; ?>
</body>

</html>