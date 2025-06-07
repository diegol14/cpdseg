<?php

/**
 * Este archivo contiene el formulario para crear un nuevo usuario
 * y la clase que lo crea
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/dirs.php';
include_once CONTROLLER_PATH . '/Users/User.php';
include_once DAO_USERS_PATH;
include_once USER_SERVICE_PATH;

session_start();

if (!isset($_SESSION['rol']))  header('Location: /');
else {
    switch ($_SESSION['rol']) {
        case 'user':
            header('Location: /');
            break;

        case 'admin':
            if (!isset($_POST['action']))header('Location: /');
else
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
    <title>Form-New-User</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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

<body class="bodylogin">
    <?php
                include_once VIEW_PATH . '/public/Headers/AdminHeader.php';
                ?>
    <main>
        <div id="content">
            <header>
                <h1>CPDSeg</h1>
                <small>Monitoriza tu instalaci&oacute;n</small>
            </header>
            <div id=forms>
                <section id="principal">
                    <?php

                switch ($_POST['action']) {
                    case 'nuevo':
                        FormUser::createUser();
                        break;

                    case 'modify':
                        FormUser::showUserToModify();
                        break;

                    case 'delete':
                        FormUser::deleteUser();
                        break;

                    default:;
                        break;
                } // End switch action

                ?>

                    <br> <?php
                } //End switch session rol/**
            } //End else  ! isset session
                        ?>
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
            <script src="/View/js/deluser.js"></script>

            <link href='/View/styles/contenidoform.css' rel='stylesheet' type='text/css' />
</body>

</html>
<?php

            /**
             * documented class
             * Tiene las funciones para llamar al servicio
             * para crear, modificar y borrar usuario
             */
            class FormUser
            {
                /**
                 * documented function summary
                 * Muestra un formulario para crear un usuario
                 * documented function long description
                 * Muestra un formulario que luego de completarse
                 * es enviado a FormUserResult.php
                 * @return type void
                 **/
                public static function createUser()
                {
            ?>
<div class="form">
<H2>A&ntilde;adir Usuario</H2><br />
    <table class="formtable">

        <form action="/Controller/Users/FormUserResult.php" method="post" autocomplete="off">
            <input type="hidden" name="createUser" value="createUser">

            <table border="0" align="center" class="form">
                <tr>
                    <td><label for="Nombre">Nombre</label></td>
                    <td><input type="text" name="namenew" placeholder="nombresinespacios" maxlength="50"
                            pattern='[a-z A-Z0-9.]+' pattern='[a-zA-Z0-9 ]{2,50}+' required /></td>
                </tr>
                <tr>
                    <td><label for="email">Email</label></td>
                    <td><input type="email" name="emailnew" placeholder="email@mail.com" maxlength="40" required /></td>
                </tr>
                <tr>
                    <td><label for="rol">Rol</label></td>
                    <td><select name="rolnew" required>
                            <option>- selecciona -</option>
                            <option value='user'>User</option>
                            <option value='admin'>Admin</option>
                        </select></td>
                </tr>
                <tr>
                    <td><label for="password">Contrase&ntilde;a</label></td>
                    <td><input type="password" name="passwordnew" placeholder="Contrase&ntilde;a" maxlength="20"
                            autocomplete="new-password" required /></td>
                </tr>
                <tr>
                    <td><label for="provincia">Provincia</label></td>
                    <td><select name="provincianew" required>
                            <option>- selecciona -</option>
                            <option value='Alava'>&Aacute;lava</option>
                            <option value='Albacete'>Albacete</option>
                            <option value='Alicante'>Alicante/Alacant</option>
                            <option value='Almeria'>Almer&iacute;a</option>
                            <option value='Asturias'>Asturias</option>
                            <option value='Avila'>&Aacute;vila</option>
                            <option value='Badajoz'>Badajoz</option>
                            <option value='Barcelona'>Barcelona</option>
                            <option value='Burgos'>Burgos</option>
                            <option value='Caceres'>C&aacute;ceres</option>
                            <option value='Cadiz'>C&aacute;diz</option>
                            <option value='Cantabria'>Cantabria</option>
                            <option value='Castellon'>Castell&oacute;n</option>
                            <option value='Ceuta'>Ceuta</option>
                            <option value='CiudadReal'>Ciudad Real</option>
                            <option value='Cordoba'>C&oacute;rdoba</option>
                            <option value='Cuenca'>Cuenca</option>
                            <option value='Girona'>Girona</option>
                            <option value='Las_Palmas'>Las Palmas</option>
                            <option value='Granada'>Granada</option>
                            <option value='Guadalajara'>Guadalajara</option>
                            <option value='Guipuzcoa'>Guip&uacute;zcoa</option>
                            <option value='Huelva'>Huelva</option>
                            <option value='Huesca'>Huesca</option>
                            <option value='Illes_Balears'>Illes Balears</option>
                            <option value='Jaen'>Ja&eacute;n</option>
                            <option value='A_ccoruna'>A Coru&ntilde;a</option>
                            <option value='La_Rioja'>La Rioja</option>
                            <option value='Leon'>Le&oacute;n</option>
                            <option value='Lleida'>Lleida</option>
                            <option value='Lugo'>Lugo</option>
                            <option value='Madrid'>Madrid</option>
                            <option value='Malaga'>M&aacute;laga</option>
                            <option value='Melilla'>Melilla</option>
                            <option value='Murcia'>Murcia</option>
                            <option value='Navarra'>Navarra</option>
                            <option value='Ourense'>Ourense</option>
                            <option value='Palencia'>Palencia</option>
                            <option value='Pontevedra'>Pontevedra</option>
                            <option value='Salamanca'>Salamanca</option>
                            <option value='Segovia'>Segovia</option>
                            <option value='Sevilla'>Sevilla</option>
                            <option value='Soria'>Soria</option>
                            <option value='Tarragona'>Tarragona</option>
                            <option value='Santa_Cruz_Tenerife'>Santa Cruz de Tenerife</option>
                            <option value='Teruel'>Teruel</option>
                            <option value='Toledo'>Toledo</option>
                            <option value='Valencia'>Valencia</option>
                            <option value='Valladolid'>Valladolid</option>
                            <option value='Vizcaya'>Vizcaya</option>
                            <option value='Zamora'>Zamora</option>
                            <option value='Zaragoza'>Zaragoza</option>
                        </select></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="center"><input type="submit" value="Aceptar"
                            style='font-size:1rem;font-weight:bold;color:green;'></td>
                </tr>
            </table>
        </form>
    </table>
</div>
</section>
<br>
<?php
                } //End function createUser

                /**
                 * documented function summary
                 * Función que muestra por pantalla el usuario a borrar
                 * Crea un formulario que envia a FormUserResult para su procesamiento
                 * 
                 * documented function long description
                 * Funcion que recibe Id y nombre de usuario a borrar desde el UsersList
                 *  y lo muestra por pantalla.
                 * Luego lo envía a FormUserResult, que a su vez llama a UserService y éste al DAO
                 * @param Type sin parámetros, captura las variables POST
                 * @return type void
                 **/
                public static function deleteUser()
                {
                    try {

                        $userId = $_POST['deleteId'];
                        $userName = $_POST['deleteName'];
                    ?>
<div class="form">
    <h2>Usuario a borrar</h2>

    <table class="formtable">
        <form action='/Controller/Users/FormUserResult.php' method='post' id='delform'>
            <table border="0" align="center" >
                <tr>
                    <td>
                        Id : </td>
                    <td><?php echo " " . $userId ?> </td>
                </tr>
                <tr>
                    <td>Nombre:</td>
                    <td> <?php echo $userName ?> </td>
                </tr>
                <input type="hidden" name="deleteUser" value="deleteUser">
                <input name='Id' type='hidden' value='<?php echo $userId ?>' />
                <input type='hidden' id="namedel" value="<?php echo $userName ?>">
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <input style='font-size:1rem;font-weight:bold;color:red;' id='deluser' type=submit name='borrar'
                            value='Borrar'>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
        </form>
        </td>
        <tr>
            <td><a href='/View/public/Users/UsersList.php' class='button'>Volver sin borrar</a></td>

        </tr>

    </table>
</div>
    <br />
    <?php
                    } catch (\Throwable $th) {
                        echo $th->getMessage();
                        header("Location:/index.php ");
                    }
                } // End function deleteUser

                public static function modifyUser()
                {

                    if (isset($_POST['modifyId'])) {
                        $userToModify = null;
                        $modifyId = $_POST['modifyId'];
                        if ($modifyId != null) {
                            $userToModify = UserService::selectUserToModify($modifyId);
                        } else echo "El n&ucute;mero identificador no es correcto";
                        return $userToModify;
                    }
                } //End function modifyUser

                public static function showUserToModify()
                {
                    try {
                        $userToShow = self::modifyUser();
                        $modifId = $userToShow->getId();
                        $modifName = $userToShow->getName();
                        $modifEmail = $userToShow->getEmail();
                        $modifRol = $userToShow->getRol();
                        $modifPassword = $userToShow->getPassword();
                        $modifProvincia = $userToShow->getProvincia();
                    ?>
                    <div class="form">
    <h2>Usuario a modificar n&uacute;mero: <?php echo $modifId ?></h2>
    <table class="formtable">
        
            <form action='/Controller/Users/FormUserResult.php' method='post'>
                <input type="hidden" name="modifyUser" value="modifyUser">
                <table border="0" align="center" class="form">
                    <tr>
                        <td><label for="IdModified">Id no modificable</label></td>
                        <td><input type="number" size="25" name="IdModified" value="<?php echo $modifId; ?>" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="nameModified">Nombre</label></td>
                        <td><input type="text" size="25" name="nameModified" value="<?php echo $modifName; ?>"
                                pattern='[a-zA-Z0-9 ]+' pattern='[a-zA-Z0-9 ]{2,50}+' required maxlength="50"></td>
                    </tr>
                    <tr>
                        <td><label for="emailModified">Email</label></td>
                        <td><input type="email" name="emailModified" maxlength="50" size="25"
                                value="<?php echo $modifEmail; ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="rolModified">Rol</label></td>
                        <td><input type="text" name="rolToModified" maxlength="10" value="<?php echo $modifRol; ?>"
                                readonly></td>
                    </tr>
                    <tr>
                        <td><label for="admin">Admin</label></td>
                        <td><input type="radio" name="rolModified" id="admin" value='admin' required></td>
                    </tr>
                    <tr>
                        <td><label for="user">User</label></td>
                        <td><input type="radio" name="rolModified" id='user' value='user'></td>
                    </tr>
                    <tr>
                        <td><label for="passwordModified">Contrase&ntilde;a</label></td>
                        <td><input type="password" name="passwordModified" size="25"
                                placeholder="Debe cambiar la contraseña" value="<?php
            /*  echo $modifPassword; */ ?>" maxlength="20">
                        </td>
                    </tr>


                    <tr>
                        <td><label for="provinciaModified">Provincia</label></td>
                        <td><input type="text" name="provinciaModified" size="25" value="<?php echo $modifProvincia; ?>"
                                maxlength="20"></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <input style='font-size:1rem;font-weight:bold;color:blue;' type=submit name='modify'
                                value='modificar' align='center'>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr><td> &nbsp;</td> <td><div class="btnmdfy">
                    <a href='/View/public/Users/UsersList.php' class='button'>Volver sin
                        modificar</a>
                </div></td></tr>
                </table>
              
            </form>
            <div class="form">

                <?php
                    } catch (\Throwable $th) {
                        echo $th->getMessage();
                    }
                } //End function showUserToModify







            } //End class FormUser

                        ?>