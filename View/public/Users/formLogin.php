<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/dirs.php';
include_once USER_SERVICE_PATH;

if(isset($_POST['logout'])){
    $idUser = $_POST['logout'];
    UserService::logoutUser($idUser);
}
?>
<body class="bodylogin">
<div class="login">
    <header class="title">
        <div class="cpdseg">
            <h1>CPDSeg</h1>
            <small>Monitoriza tu instalaci&oacute;n</small>
        </div>
        <div class="comienza-monitorizacion" id="comienza">
            <!-- Advertencia.<br> 
            Por su seguridad,<br>-->No guarde su contraseña en el navegador<br>
            <input type="button" class="btncomienza" value="Aceptar" id="playsound"
                title="Comenzar monitorizaci&oacute;n">
        </div>
    </header>
    <div class="form">
        <form method='post' action='/View/public/Sensors/ShowSensors.php' name='login-form' id='login-form'
            autocomplete='off'>
            <fieldset>
                <legend>
                    <h3> NOMBRE Y CONTRASEÑA PARA INGRESAR EN LA INSTALACI&Oacute;N</h3>
                </legend>
                <div class='form'>
                    <label for='name' id='labname'>Nombre</label>
                    <input id='name' name='name' pattern='[a-zA-Z0-9 ]+' pattern='[a-zA-Z0-9 ]{2,50}+' required />
                </div>
                <div class='form'>
                    <label for='password' id='labpassword'>Contrase&ntilde;a</label>
                    <input type='password' id='password' name='password' required />
                    <input type="hidden" name="rol" id="rol" value="null">
                </div>

                <button type='submit' id='acceso' name='acceso' value='Acceso' disabled>Entrar</button>
                <button type='reset' id='reset' name='reset' value='reset'>Restablecer</button>
            </fieldset>
        </form>
        <div class='form'>
            <label for='registeredUser' id='labregistered'>Soy un usuario registrado</label>
            <input type='checkbox' id='registeredUser' name='registeredUser' required />
        </div>
    </div>
</div>
</body>
<link href='/View/styles/contenido.css' rel='stylesheet' type='text/css' />