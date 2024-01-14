<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/dirs.php';
include_once CONTROLLER_PATH.'/Users/RecibiendoUsuario.php';
include_once USER_SERVICE_PATH;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Origin: *');
if (!isset($_SESSION["rol"]))header ('Location: /index.php');

else{
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
    <link rel="icon" type="image/png" sizes="192x192" href="/View/public/assets/favicons/android-icon-192x192.png">
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

    <?php
     if ($_SESSION["rol"] == "admin") {
        include_once  $_SERVER['DOCUMENT_ROOT'] . '/View/public/Headers/AdminHeader.php';
    } elseif ($_SESSION["rol"] == "user") {
        # code...
        include_once $_SERVER['DOCUMENT_ROOT'] .'/View/public/Headers/UserHeader.php';
    } 
?>
    <main>

        <div class="content" id="content">
            <header class="header">
                <div class="cpdseg">
                    <h1>CPDSeg</h1>
                    <small>Monitoriza tu instalaci&oacute;n</small>
                </div>
                <div class="comienza-monitorizacion" id="comienza">
                    <!-- Comienza monitorizaci&oacute;n.<br>-->Si omite un sensor,<br>para restaurarlo pulse Inicio<br> 
                    <input type="button" class="btncomienza" value="Aceptar" id="playsound"
                        title="Comenzar monitorizaci&oacute;n">
                </div>
            </header>
            <div id=sensores>
                <section class="principal">
                    <div class="box" id="boxluz" height="230" width="120">
                        <div class="boximg">
                            <img id="imgluz" src="/View/public/assets/img/luz.png" alt="Cantidad de luz" height="130"
                                width="120">
                        </div>
                        <div><input type="button" class="btn" value="Aceptar alarma" id="resetluz"></div>
                        <div><input type="button" class="btnomit" value="Omitir" id="nullluz"
                                title="No anula el evento en la Base de Datos"></div>
                        <div class="labsen"><label id="labluz">Nivel de luz (0 a 1023)</label>
                            <input name="luz" class="input" id="luz" maxlength="04" size="1" readonly />
                            <meter max="1023" high="700" name="meterluz" id="meterluz">
                        </div>
                        <div class="labsen">
                            <label id='labtimeluz'>&Uacute;ltima Lectura</label>
                            <input name="timeluz" class="input" id="timeluz" maxlength="30" size="16" readonly />
                        </div>
                        <div class="labsen">
                            <label id='labstatusluz'>Estado</label>
                            <input name="statusluz" id="statusluz" maxlength="30" size="14" readonly />
                        </div>
                    </div>

                    <div class="box" id="boxincendio" height="230" width="120"><img id="imgincendio"
                            src="/View/public/assets/img/sensorincendio.png" alt="Detector incendio" height="140"
                            width="120">
                    </div>
                    <div><input type="button" class="btn" value="Aceptar alarma" id="resetinc"></div>
                    <div><input type="button" class="btnomit" value="Omitir" id="nullinc"
                            title="No anula el evento en la Base de Datos"></div>
                    <div><label id='labincendio'>Incendio </label></div>
                    <div><label id='labtimeincendio'>&Uacute;ltima Lectura</label>
                        <input name="timeincendio" id="timeincendio" maxlength="30" size="16" readonly />
                        <div>
                        </div>
                        <div>
                            <label id='labstatusincendio'>Estado</label>
                            <input name="statusincendio" id="statusincendio" maxlength="30" size="14" readonly />
                        </div>


                        <div class="oculto"><img id="icono1" src="/View/public/assets/img/sensor-de-movimientos.png"
                                alt="Icono de aplicacion" height="100" width="120">Nuevo sensor</div>
                </section>

                <section class="secundaria">
                    <div class="box" id="boxtemperatura" height="230" width="120"><img id="imgtemperatura"
                            src="/View/public/assets/img/thermometer-153138_640.png" alt="temperatura" height="130"
                            width="120">
                    </div>
                    <div><input type="button" class="btn" value="Aceptar alarma" id="resettemp"></div>
                    <div><input type="button" class="btnomit" value="Omitir" id="nulltemp"
                            title="No anula el evento en la Base de Datos"></div>
                    <div><label id='labtemp'>Temperatura ( ºC )</label>
                        <input class="temperatura" name="temperatura" id="temperatura" maxlength="30" size="1"
                            readonly />
                        <meter class="temperatura" max="90.00" high="15" name="metertemperatura" id="metertemperatura">
                    </div>
                    <div>
                        <label id='labtimetemp'>&Uacute;ltima Lectura</label>
                        <input name="timetemperatura" id="timetemperatura" maxlength="30" size="16" readonly />
                    </div>
                    <div>
                        <label id='labstatustemp'>Estado</label>
                        <input name="statustemp" id="statustemp" maxlength="30" size="16" readonly />
                    </div>

                    <br>
                    <div class="box" id="boxvolumetrico" height="230" width="120">
                        <div class="boximg"><img id="imgvolumetrico"
                                src="/View/public/assets/img/sensor-de-movimiento.png" alt="Detector volumetrico"
                                height="125" width="120">
                        </div>
                        <div><input type="button" class="btn" value="Aceptar alarma" id="resetvol"></div>
                        <div><input type="button" class="btnomit" value="Omitir" id="nullvol"
                                title="No anula el evento en la Base de Datos"></div>
                        <div><label id='labvol'>Volumétrico</label>
                            <div>
                                <label id='labtimevol'>&Uacute;ltima Lectura</label>
                                <input name="timevol" id="timevol" maxlength="30" size="16" readonly />
                            </div>
                            <div>
                                <label id='labstatusvol'>Estado</label>
                                <input name="statusvol" id="statusvol" maxlength="30" size="14" readonly />
                            </div>
                        </div>
                        <div class="oculto" class="box"><img id="icono2"
                                src="/View/public/assets/img/sensor-de-movimientos.png" alt="Icono de aplicacion"
                                height="100" width="120">Nuevo sensor</div>
                        <br>
                </section>
                <section class="terciaria" class="inund">

                    <div class="box" id="boxhumedad" height="230" width="120">
                        <div><img id="imghumedad" src="/View/public/assets/img/senshumedad.png" alt="Cantidad de luz"
                                height="140" width="120">
                        </div>
                        <div><input type="button" class="btn" value="Aceptar alarma" id="resethum"></div>
                        <div><input type="button" class="btnomit" value="Omitir" id="nullhum"
                                title="No anula el evento en la Base de Datos"></div>
                        <div><label id='labhum'>Nivel de humedad ( % )</label>
                            <input class="humedad" name="humedad" id="humedad" maxlength="30" size="1" readonly />
                            <meter class="humedad" max="100.00" high="40.00" name="meterhumedad" id="meterhumedad">
                        </div>
                        <div>
                            <label id='labtimehum'>&Uacute;ltima Lectura</label>
                            <input name="timehum" id="timehum" maxlength="30" size="16" readonly />
                        </div>
                        <div>
                            <label id='labstatushum'>Estado</label>
                            <input name="statushum" id="statushum" maxlength="30" size="14" readonly />
                        </div>
                    </div>

                    <div class="box" id="boxinundacion" height="230" width="120">
                        <div><img id="imginundacion" src="/View/public/assets/img/inundacion.png"
                                alt="Detector inundacion" height="130" width="120">
                        </div>
                        <div><input type="button" class="btn" value="Aceptar alarma" id="resetinund"></div>
                        <div><input type="button" class="btnomit" value="Omitir" id="nullinund"
                                title="No anula el evento en la Base de Datos"></div>
                        <div><label id='labinundacion'>Inundacion </label></div>
                        <div><label id='labtimeinundacion'>&Uacute;ltima Lectura</label>
                            <input name="timeinundacion" id="timeinundacion" maxlength="30" size="16" readonly />
                        </div>
                        <div>
                            <label id='labstatusinundacion'>Estado</label>
                            <input name="statusinundacion" id="statusinundacion" maxlength="30" size="14" readonly />
                        </div>
                    </div>
                    <div class="oculto" class="box"><img id="icono2"
                            src="/View/public/assets/img/sensor-de-movimientos.png" alt="Icono de aplicacion"
                            height="100" width="120">Nuevo sensor</div>
                </section>

            </div>
            <div id="aside">
                <aside>
                    <h3>CPDSeg se conecta contigo</h3>
                    <img id="icono2" src="/View/public/assets/img/sensor-de-movimientos.png" alt="Icono de aplicacion"
                        height="100" width="120">
                    <p>CPDSeg es un sistema diseñado con hardware OpenSource de monitorización en vivo
                        de instalaciones a su medida
                    </p>


                </aside>
            </div>
            <script src="/View/js/jquery-3.6.0.min.js"></script>
            <script src="/View/js/functions.js"></script>
            <script src="/View/js/ShowSensorState.js"></script>
            <script src="/View/js/app1.js"></script>


            <?php
    }
    ?>
            <link href='/View/styles/contenido.css' rel='stylesheet' type='text/css' />
</body>



</html>