<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/dirs.php';
$nameUser = (isset($_SESSION['name'])) ? ucfirst($_SESSION['name']) : null ; 
$idUser = (isset($_SESSION['Id'])) ? $_SESSION['Id'] : null ;

?>

<nav id="navbar">
    <div class="myicon" id="myicon">
        <i class="fa fa-bars"></i>

    </div>
    <ul class="small-list">
        <!-- Este formulario para crear nuevo usuario se envía cuando
            el usuario pulsa el <a> Crear Usuario quew está mas abajo
            Funcion del archivo createUser.js-->
        <li>
            <form action='/View/public/Users/FormUser.php' method='post' id="newuser">
                <input name="Id" type="hidden" value="0">
                <input name="action" type="hidden" value="nuevo">
            </form>
        </li>
        <!-- Este formulario para modificar usuario se envía cuando
            el usuario pulsa el <a> con el nombre del  Usuario que está mas abajo
            Funcion del archivo createUser.js-->
        <li>
            <form action='/View/public/Users/FormUser.php' method='post' id="modifyuser">
                <input name="modifyId" type="hidden" value="<?php echo $idUser ?>">
                <input name="action" type="hidden" value="modify">
            </form>
        </li>
        <li><a href='/View/public/Sensors/ShowSensors.php' title="Inicio">Inicio</a></li>
        <li><a href='/View/public/Users/UsersList.php' title="Lista de Usuarios">Usuarios</a></li>
        <li>
            <a href="/View/public/Users/UsersList.php" id="btnnewuser" title="Crear Usuario">Crear Usuario</a>
        </li>

        <li><a href='/View/public/Events/HistoryEvents.php' title="Hist&oacute;rico de Eventos">Hist&oacute;rico</a></li>
        <li>
            <a href="/View/public/Users/UsersList.php" id="btnoutuser" title="Cerrar Sesi&oacute;n">Cerrar sesi&oacute;n</a>
        </li>
        <!-- Este formulario para cerrar sesion de usuario se envía cuando
            el usuario pulsa el <a> con Cerrar Sesion
            Funcion del archivo createUser.js-->
        <li>
            <form id="outuser" action='/View/public/Users/formLogin.php' method='post'>
                <input name='logout' type='hidden' value="<?php echo $idUser ?>">
            </form>
        </li>
        <li>
            <a href="/View/public/Users/UsersList.php" id="btnmodifyuser"
                title="Modificar Usuario"><?php echo $nameUser ?></a>
        </li>
    </ul>
</nav>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href='/View/styles/contenido.css' rel='stylesheet' type='text/css' />
<script src="/View/js/jquery-3.6.0.min.js"></script>
<script src="/View/js/createuser.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>

</script>