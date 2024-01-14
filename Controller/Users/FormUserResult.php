<?php

/**
 * Este archivo recibe los formularios de usuario
 * 
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/dirs.php';
include_once CONTROLLER_PATH . '/Users/User.php';
include_once DAO_USERS_PATH;
include_once USER_SERVICE_PATH;

session_start();

if (!isset($_SESSION['rol']))  header('Location:/' );
else {
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
                <meta namenew=description content="CPDSeg es una aplicación WEB de monitorización de sensores
     en remoto. Está orientada a supervisar instalaciones, como por ejemplo,Centros de Procesamiento de Datos" />
                <meta namenew="viewport" content="width=device-width, initial-scale=1.0">
                <meta namenew="author" content="DiegolPereira" />
                <title>Form Users Results</title>
                
            </head>

            <body>
    <?php
            include_once VIEW_PATH . '/public/Headers/AdminHeader.php';
            FormUserResult::insertNewUser();
            FormUserResult::deleteUser();
            FormUserResult::modifyUser();
    } //End switch
} //End else

/**
 *documented class FormNewUser
 * Esta clase tiene la función para crear,borrar  usuarios 
 */
class FormUserResult //implements Interface
{
    /** documented function summary
     * inserta un nuevo usuario
     *  
     * documented function long description
     * Recibe los datos insertados en FormNewUser.php,
     * crea un objeto User con esos datos y llama al servicio que a su vez llama al DAO 
     * para insertar el usuario. Si éste es insertado, te redirige al listado de usuarios.
     * @return void
     **/
    public static function insertNewUser()
    {
        $correctForm = 0;
        if (isset($_POST['createUser'])) {

            if (empty($_POST['namenew'])) {
                echo "Hay un error en el nombre";
            } else {
                $correctForm += 1;
                $namenew = strtolower($_POST['namenew']);
                unset($_POST['namenew']);
                $_POST['namenew'] = array();
            }

            if (empty($_POST['emailnew'])) {
                echo "Hay un error en el emailnew";
            } else {
                $emailnewForm = $_POST['emailnew'];
                $validEmailnew = User::is_valid_email($emailnewForm);
                if ($validEmailnew) {
                    $correctForm += 1;
                    $emailnew = $emailnewForm;
                    unset($_POST['emailnew']);
                    $_POST['emailnew'] = array();
                } else echo "Hay un error en el emailnew";
            }

            if (empty($_POST['rolnew'])) {
                echo "Hay un error en el rolnew";
            } else {
                $correctForm += 1;
                $rolnew = $_POST['rolnew'];
                unset($_POST['rolnew']);
                $_POST['rolnew'] = array();
            }

            if (empty($_POST['passwordnew'])) {
                echo "Hay un error en la contraseña";
            } else {
                $correctForm += 1;
                $passwordnew = UserService::hash($_POST['passwordnew']);
                unset($_POST['passwordnew']);
                $_POST['passwordnew'] = array();
            }

            if (empty($_POST['provincianew'])) {
                echo "Hay un error en la provincianew";
            } else {
                $correctForm += 1;
                $provincianew = $_POST['provincianew'];
                unset($_POST['provincianew']);
                $_POST['provincianew'] = array();;
            }
        } //End if isset campos del formulario 
        if ($correctForm == 5) {
            $user = User::fullUserCreate($namenew, $emailnew, $rolnew, $passwordnew, $provincianew);
            $insertedUser = UserService::insertNewUser($user);
            if(empty($insertedUser))echo "<p style='margin:5%;color:red;font-weight:bold;'>ERROR EN LA INSERCIÓN DE DATOS&nbsp; &nbsp;INTÉNTELODE NUEVO</p>";
            if ($insertedUser) {
                header('location:/View/public/Users/UsersList.php');
            }else echo "<p style='margin:5%;color:red;font-weight:bold;'>ERROR EN LA INSERCIÓN DE DATOS&nbsp; &nbsp;INTÉNTELODE NUEVO</p>";
        } //End if correctForm

        /*  else echo "Error en rellenado de formulario"; */
    } //End function insertNewUser

    /**
     * documented function summary
     * borrar usuario
     * documented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public static function deleteUser()
    {
        $deletion = false;
               if (isset($_POST['deleteUser'])) {
            echo $deleteUser = $_POST['deleteUser'];
            if(isset($_POST['Id'])){echo $deleteId = $_POST['Id'];
            $deletion = UserService::deleteUser($deleteId);
    }else echo 'kkId';
    if($deletion) header('location:/View/public/Users/UsersList.php');
    else{echo "<p style='margin:5%;color:red;font-weight:bold;'>Error en el borrado</p>";}
               }
    }//End function deleteUser

    /**
     * documented function summary
     *
     * documented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public static function modifyUser()
    {
        $updateOk = false;
        if (isset($_POST['modifyUser'])) {
            if (isset($_POST['IdModified']))$IdM = $_POST['IdModified'];
            if(isset($_POST['nameModified']))$nameM = strtolower($_POST['nameModified']);
            if(isset($_POST['emailModified']))$emailM = $_POST['emailModified'];
            if(isset($_POST['rolModified']))$rolM = $_POST['rolModified'];
            if(isset($_POST['passwordModified']))$passwordM = UserService::hash($_POST['passwordModified']);
            if(isset($_POST['provinciaModified']))$provinciaM = $_POST['provinciaModified'];

            echo $IdM.'<br>';
            echo $nameM.'<br>';
            echo $emailM.'<br>';
            echo $rolM.'<br>';
            echo $passwordM.'<br>';
            echo $provinciaM.'<br>';

            $userModified = User::fullUserCreate($nameM, $emailM, $rolM, $passwordM, $provinciaM);
            $userModified->setId($IdM);
            echo $userModified->getName().'<br>';
            echo $userModified->getId().'<br>';
            $userUpdateOk = new User();
            $userUpdateOk = UserService::modifyUser($userModified);
            if(isset($userUpdateOk)) header('location:/View/public/Users/UsersList.php');
            else{echo "<p style='margin:5%;color:red;font-weight:bold;'>ERROR EN LA INSERCIÓN DE DATOS&nbsp; &nbsp;INTÉNTELODE NUEVO</p>";}
        }
    }//End function modifyUser
} //End class

?>