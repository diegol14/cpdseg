<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/dirs.php';
include_once DAO_USERS_PATH;//'/Model/Users/DAO_Users.php' ;
include_once 'User.php';
class UserService
{

    /**  */
    /**Esta función crea el obj userLogin que 
     * es un tipo de usuario para pasar al DAO y acceder 
     * 
     */
    public static function userLogin($loginUser)
    {
        /** EL DAO me devuelve un objeto desde la BBDD
         *  @var Type 
         * user con las propiedades name, rol y password.*/
        try {
            $daoUser = new User();
            $daoUser = DAO_Users::DAOLogin($loginUser);
            $name = $daoUser->getName();
             /*echo  "<br>" . $name . "daouser<br>";*/
            /*echo*/
            $rol = $daoUser->getRol();
            $Id = $daoUser->getId();
            /* echo */
            $passwordHash = $daoUser->getPassword();
            $passwordForm = $loginUser->getPassword();
            if (!self::verify($passwordForm,$passwordHash)) {  
                $wrongUser = new stdClass();
                $wrongUser->name = $name;
                $wrongUser->rol = null;
                $wrongUser->Id = $Id;
                return $wrongUser;
               // echo json_encode($nullUser);
            } else {
                //echo "<br>iksession: " . json_encode($_SESSION);
                $ajaxUser = new stdClass();
                $ajaxUser->name = $name;
                $ajaxUser->rol = $rol;
                $ajaxUser->Id = $Id;

                return $ajaxUser;

            }
        } catch (\Throwable $th) {
            echo $th->getFile();
            echo $th->getLine();
            echo $th->getMessage();
           
            $nullUser = new stdClass();
            $nullUser->name = null;
            $nullUser->rol = null;
            $nullUser->Id = null;
            return $nullUser;
            //echo json_encode($nullUser);
        }
    }

    /**
     * selectAllUsers function summary
     *
     * selectAllUsers function long description
     * Esta función llama al DAO para seleccionar todos los usuarios 
     * y devuelve un array de objetos usuario
     * @return type array[users].
     **/
    public static function selectAllUsers()
    {
        try {
            $allUsers = DAO_Users::selectAllUsers();
            //var_dump($allUsers);
            return $allUsers;
        } catch (\Throwable $th) {
            echo $th->getFile();
            echo $th->getLine();
            echo $th->getMessage();
        }
    }

    public static function insertNewUser($user){
        try {
           $insertedUser = DAO_Users::insertUser($user);
           if(empty($insertedUser))echo "<p style='margin:5%;color:red;font-weight:bold;'>ERROR EN LA INSERCIÓN DE DATOS&nbsp; &nbsp;INTÉNTELODE NUEVO</p>";
           return $insertedUser;

        } catch (\Throwable $th) {
            "<p style='margin:5%;color:red;font-weight:bold;'>ERROR EN LA INSERCIÓN DE DATOS&nbsp; &nbsp;". $th->getMessage().
            "INTÉNTELODE NUEVO</p>";
             $th->getFile();
             $th->getLine();
            $th->getMessage();
        }
    }

    /**
     * documented function summary
     * Función que borra usuario
     * documented function long description
     * 
     *
     * @param Type $var Id del usuario
     * @return type boolean
     * @throws conditon
     **/
    public static function deleteUser($deleteId)
    {
        $deletion = false;
        try {
            $deletion = DAO_Users::deleteUser($deleteId);
            
        } catch (\Throwable $th) {
            echo $th->getMessage;
        }finally{
            return $deletion;
        }
    }//End function deleteUser
/**
 * documented function summary
 * Función que llama al DAO para seleccionar el usuario a modificar
 *
 * @param Type $var modifiId Id del usuarioa modificar
 * @return type User object
 **/
public static function selectUserToModify($modifyId)
{
    $userToModify = null;
    try {
        $userToModify = DAO_Users::selectUsertoModify($modifyId);
            } catch (\Throwable $th) {
       echo "<p style='margin:5%;color:red;font-weight:bold;'>Error en la búsqueda del usuario</p>";
    }finally{
        return $userToModify;
    }
    
}//End function selectUserTomodify

public static function modifyUser($modifiedUser){
   try {
    $user = DAO_Users::modifyUser($modifiedUser);
    return $user;
   } catch (\Throwable $th) {
       echo "<p style='margin:5%;color:red;font-weight:bold;'>".$th->getMessage.'Error_UserService</p>';
   } 
}

public static function hash($password) {
    return password_hash($password, PASSWORD_DEFAULT, ['cost' => 11]);
}
public static function verify($password, $hash) {
    return password_verify($password, $hash);
}


public static function logoutUser($userId) {
    session_start() ;
    session_destroy();
    //función que inserta logout en tabla login,
    // el 1 corresponde a ingresar y el 0 a salir
    DAO_Users::insertLogin($userId,0);
    header('location:/index.php');
}//End function logoutUser

}//End class UserService
