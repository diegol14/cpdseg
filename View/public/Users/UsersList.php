<?php

/**Este archivo muestra la lista de los usuarios, solo si el rol es admin. 
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/dirs.php';
include_once CONTROLLER_PATH . '/Users/UserService.php';
session_start();

if (isset($_SESSION['rol'])) {
    switch ($_SESSION['rol']) {
        case 'user':
            header('Location: /' );
            break;

        case 'admin':
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
    <title>Users List</title>
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
    <?php
            include_once VIEW_PATH . '/public/Headers/AdminHeader.php';
    ?>
    <main>

        <div id="content">
            <header>
                <h1>CPDSeg</h1>
                <small>Monitoriza tu instalaci&oacute;n</small>
            </header>
            <div id=userlists>
                <section id="principal">
                    <?php
            UsersList::UserTable();
    }
} else {
    header('Location: /');
}

?>

                </section>
            </div>
            <div id="aside">
                <aside>
                    <h3>CPDSeg se conecta contigo</h3>
                    <img id="icono2" src="/View/public/assets/img/sensor-de-movimientos.png"
                        alt="Icono de aplicacion" width="60" height="auto">

                </aside>

                <script src="/View/js/jquery-3.6.0.min.js"></script>
                <link href='/View/styles/contenidoform.css' rel='stylesheet' type='text/css' />
</body>

</html>
<?php
/**
 * documented class class UsersList
 * Esta clase muestra el listado de usuarios.Dicha lista 
 * posee botones de creación,modificacion y borrado de usuarios.
 */
class UsersList
{

    /**
     * documented function summary
     * Lista de usuarios.
     * documented function long description
     * Recibe un array de objetos usuario y los muestra.
     * Junto a cada usuario existen botone de modificar y borrar usuario, y uno de crear usuario.
     * Estas solicitudes se envían al archivo ServiceActionUser.php
     * @param Type $var sin parámetros.
     * @return type html con listado de usuarios.
     **/
    public static function UserTable()
    {
        $allUsers = UserService::selectAllUsers();
        $numUsers = 0; ?>
<form action="/View/public/Users/FormUser.php" method="post">
    <input name="Id" type="hidden" value="0">
    <input name="action" type="hidden" value="nuevo">
    <input type="submit" value="Nuevo" title="Nuevo Usuario"
        style='font-size:1.2rem;font-weight:bold;color:green;'></input>
</form>

<!-- <div style='text-align:center;'> -->
<table class="table">

    <h2 title="Usuarios">USUARIOS</h2>

    <thead>
        <tr>
            <th class="btnshow" title="Columna Identificador Usuario"><span class="notranslate">Id</span></th>
            <th title="Columna Nombre Usuario">Nombre</td>
            <th title="Columna Correo de Usuario" class="colhide">Email</th>
            <th title="Columna Rol de Usuario" class="btnshow">Rol</th>
            <th title="Columna Provincia Usuario" class="colhide">Provincia</th>
            <!-- <th> &nbsp;</th>
                        <th> &nbsp;</th> -->
        </tr>
    </thead>
    <colgroup>
        <col>
        <col>
        <col>
        <col>
        <col>
        <col>
        <col>
        <col>
    </colgroup>
    <tbody>
        <?php

                    ?>

        <?php
                    foreach ($allUsers as $user) {
                        $idUser = $user->getId()
                      /*   echo */?>
        <tr>
            <td class="btnshow"><?php echo $user->getId() ?> </td>
            <td> <?php echo $user->getName() ?></td>
            <td class="colhide"><?php echo $user->getEmail() ?> </td>
            <td class="btnshow"><?php echo $user->getRol() ?> </td>
            <?php $user->getPassword() ?>
            <td class="colhide"><?php echo $user->getProvincia() ?> </td>

            <td>
                <form action="/View/public/Users/FormUser.php" method="post">
                    <input name="modifyId" type="hidden" value="<?php echo $idUser ?>">
                    <input name="action" type="hidden" value="modify">
                    <input style="font-family: FontAwesome" value="&#xf040;" type="submit"
                        title="Modificar Usuario"></input>
                    <!--                      <input type="submit" class ="btntable" value="Modificar"
                        style='font-size:1rem;font-weight:bold;color:blue;'></input> -->
                </form>
            </td>
            <td>
                <form action="/View/public/Users/FormUser.php" method="post">
                    <input name="deleteId" type="hidden" value="<?php echo $user->getId() ?>">
                    <input name="deleteName" type="hidden" value="<?php echo $user->getName() ?>">
                    <input name="action" type="hidden" value="delete">
                    <input style="font-family: FontAwesome" value="&#xf014" title="Borrar Usuario" color="red"
                        type="submit"></input>
                    <i class="fas fa-pencil-alt"></i>
                    <!-- <input type="submit"class ="btntable"  value="Borrar" style='font-size:1rem;font-weight:bold;color:red;'></input> -->
                </form>
            </td>
        </tr>
        <?php
                        $numUsers += 1;
                    } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan='5'>Total de usuarios:</td>
            <td><?php
                            echo $numUsers; ?></td>
        </tr>
    </tfoot>
</table>
&nbsp;

<?php
    }
} ?>