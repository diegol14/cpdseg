<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/dirs.php';
include CONN_PATH;
include_once CONTROLLER_PATH . "/Users/User.php";

class DAO_Users
{

    /**
     * DAOLogin function summary
     *
     * DAOLogin function long description
     * Esta función recibe el usuario de login y devuelve un usuario válido 
     * con rol y password válidos desde la Base de Datos o un usuario con atributos nulos
     * si no existen éstos
     * @param Type $object loginUser
     * @return type $object rolUser
     * @throws conditon
     **/
    public static function DAOLogin($loginUser)
    {
        try {
            $conn_sensors_db = Connection::getInstance()->getConnection();

            $name = $loginUser->getName();

            $sql = "SELECT name, rol, password, Id FROM users where name = ?";
            $obj_stmt = $conn_sensors_db->prepare($sql);
            $obj_stmt->execute([$name]);
            $row_count = $obj_stmt->rowCount();
            if ($row_count == 1) {
                $user = $obj_stmt->fetch(PDO::FETCH_OBJ);
                $name = $user->name;
                // echo "nomdao".$name;
                $rol = $user->rol;
                //echo "roldao".$rol;
                $password = $user->password;
                //echo "pssdao".$password;
                $Id = $user->Id;
                $rolUser = User::rolUserCreate($name, $rol, $password, $Id);

                $obj_stmt->closeCursor();
                $conn_sensors_db = null;
                return $rolUser;
            } //End if rowcount == 1
            else {
                $nullUser = new User();
                $nullUser->setName(null);
                $nullUser->setRol(null);
                $nullUser->setPassword(null);
                $nullUser->setId(null);
                return $nullUser;
            } //End else rowcount !=0
        } catch (\Throwable $th) {
            echo $th->getFile();
            echo $th->getLine();
            echo $th->getMessage();
        } //End catch
    } //End function DAOLogin

    /**
     * documented function summary
     *
     * documented function long description
     * función que inserta el usuario que ha ingresado
     * en la aplicacion en la tabla login con el timestamp correspondiente
     * @param Type   obj User, no int id 
     * @return type void
     * @throws conditon
     **/
    public static function insertLogin($Id,$io = null)
    {
      /*   $loginUserOk = new stdClass();
        $loginUserOk = $ajaxUser; 
        $io: el 1 corresponde a ingresar y el 0 a salir*/
        $FK_user_id = $Id;
        $in_or_out = $io;
        try {
            $conn_sensors_db = Connection::getInstance()->getConnection();

            $myquery = "INSERT INTO login ( FK_user_id,in_or_out) values ('$FK_user_id','$in_or_out')";
            
            $result = $conn_sensors_db->prepare($myquery);
            $isOk = $result->execute();
    
            if (!$isOk) {
            /*     echo "<p style='margin:5%;color:red;font-weight:bold;'>Error en la inserción de valores, se han insertado: "
                    . $result->rowCount() . " registros</p>" */;
            } // End if isOk
            else {
                /* echo "<p style='margin:5%;color:blue;font-weight:bold;'> registration insertado : " . $result->rowCount() . "</p>"; */
            }
    
            $result = null;
            $isOk = null;
            $conn_sensors_db = null;
        } catch (\Throwable $th) {
            echo $th->getFile();
            echo $th->getLine();
            echo $th->getMessage();
        }
    }
    /** 
     * selectAllUsers function summary
     *
     *selectAllUsers function long description
     *Función que devuelve un array de objetos con todos los usuarios
     * @return Array{$object fullUser}
     **/
    public static function selectAllUsers()
    {

        $conn_sensors_db = Connection::getInstance()->getConnection();

        try {
            $allUsers = [];
            $obj_stmt = $conn_sensors_db->prepare("SELECT * FROM users");


            $obj_stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $obj_stmt->execute();
            $user = new User();
            while ($user = $obj_stmt->fetch()) {
                array_push($allUsers, $user);
            }
        } catch (\Throwable $th) {
            echo "<br>ERROR EN LA CONEXIÓN A LA BASE DE DATOS";
        }
        if (isset($obj_stmt) and !empty($obj_stmt)) $obj_stmt->closeCursor();

        $conn_sensors_db = null;
        return $allUsers;
    } //End function selectAllUsers.

    /**
     * documented function summary
     * Inserta un usuario en la BBDD
     * documented function long description
     *
     * @param Type $var Description
     * $object User para insertar nuevo en la BBDD
     * @return type
     * @throws conditon
     **/
    public static function insertUser($user)
    {
        $queryOk = false;

        $nam = $user->getName();
        $mail = $user->getEmail();
        $rol = $user->getRol();
        $pass = $user->getPassword();
        $prov = $user->getProvincia();
        try {
            $conn_sensors_db = Connection::getInstance()->getConnection();
            $sql =
                'INSERT INTO users (name, email, rol, password, provincia) VALUES(:nam, :mail, :rol, :pass, :prov)';
            $obj_stmt = $conn_sensors_db->prepare($sql);
            $obj_stmt->execute(array(':nam' => $nam, ':mail' => $mail, ':rol' => $rol, ':pass' => $pass, ':prov' => $prov));
            $rowCount = $obj_stmt->rowCount();
            if ($rowCount == 1) $queryOk = true;
            else echo "<p style='margin:5%;color:red;font-weight:bold;'>ERROR EN LA INSERCIÓN DE DATOS&nbsp; &nbsp;INTÉNTELODE NUEVO<p>";
            $obj_stmt = null;
            $conn_sensors_db = null;
            if ($queryOk) return $user;
            else echo "<p style='margin:5%;color:red;font-weight:bold;'>ERROR EN LA INSERCIÓN DE DATOS&nbsp; &nbsp;INTÉNTELODE NUEVO<p>";
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    } //End function insertUser.

    /**
     * documented function summary
     *
     * documented function long description
     *
     * @param Type $deleteId: Id del usuario a ser borrado
     * @return type boolean si la consulta está hecha 
     * y afecta a una columna
     **/
    public static function deleteUser($deleteId)
    {
        $queryOk = false;
        try {

            $conn_sensors_db = Connection::getInstance()->getConnection();
            $sql = "DELETE FROM users where Id = ?";
            $obj_stmt = $conn_sensors_db->prepare($sql);
            $obj_stmt->execute([$deleteId]);
            $rowCount = $obj_stmt->rowCount();
            if ($rowCount == 1) $queryOk = true;
            else echo "<p style='margin:5%;color:red;font-weight:bold;'>ERROR EN LA INSERCIÓN DE DATOS&nbsp; &nbsp;INTÉNTELODE NUEVO<p>";
            $obj_stmt = null;
            $conn_sensors_db = null;
        } catch (\Throwable $th) {
            echo "<p style='margin:5%;color:red;font-weight:bold;'>" . $th->getMessage() . "</p>";
        } finally {
            return $queryOk;
        }
    } //End function deleteUser

    /**
     * documented function summary
     * Selecciona el usuario a modificar (update)
     * documented function long description
     *
     * @param Type $var Id para seleccionar usuario
     * @return type User object
     **/
    public static function selectUsertoModify($modifyId)
    {
        $modifyUser = null;

        $conn_sensors_db = Connection::getInstance()->getConnection();

        $allUsers = [];
        $obj_stmt = $conn_sensors_db->prepare("SELECT * FROM users where Id = ?");
        try {

            $obj_stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $obj_stmt->execute([$modifyId]);
            $user = new User();
            while ($user = $obj_stmt->fetch()) {
                array_push($allUsers, $user);
            }
        } catch (\Throwable $th) {
            echo "<p style='margin:5%;color:red;font-weight:bold;'>ERROR EN LA INSERCIÓN DE DATOS&nbsp; &nbsp;" . $th->getMessage() . "INTÉNTELODE NUEVO</p>";
        }
        $obj_stmt->closeCursor();
        $obj_stmt = null;
        $conn_sensors_db = null;
        return $allUsers[0];
    } //End selectUserToModify

    public static function modifyUser($user)
    {
        $queryOk = false;

        $Id = $user->getId();
        $nam = $user->getName();
        $mail = $user->getEmail();
        $rol = $user->getRol();
        $pass = $user->getPassword();
        $prov = $user->getProvincia();

        try {
            $conn_sensors_db = Connection::getInstance()->getConnection();
            $sql =
                'Update users set name= :nam, email = :mail, rol= :rol, password= :pass, provincia= :prov
                 where Id= :Id';
            $obj_stmt = $conn_sensors_db->prepare($sql);
            $obj_stmt->bindParam(':nam', $nam, PDO::PARAM_STR, 50);
            $obj_stmt->bindParam(':mail', $mail, PDO::PARAM_STR, 50);
            $obj_stmt->bindParam(':rol', $rol, PDO::PARAM_STR, 5);
            $obj_stmt->bindParam(':pass', $pass, PDO::PARAM_STR, 50);
            $obj_stmt->bindParam(':prov', $prov, PDO::PARAM_STR, 30);
            $obj_stmt->bindParam(':Id', $Id, PDO::PARAM_INT, 10);
            $obj_stmt->execute();
            $rowCount = $obj_stmt->rowCount();
            if ($rowCount == 1) $queryOk = true;
            else echo "<p style='margin:5%;color:red;font-weight:bold;'>ERROR EN LA INSERCIÓN DE DATOS&nbsp; &nbsp;INTÉNTELODE NUEVO</p>";
            $obj_stmt = null;
            $conn_sensors_db = null;
            if ($queryOk) {
                echo "queryOk";
                return $user;
            }
        } catch (\Throwable $th) {
            echo "<p style='margin:5%;color:red;font-weight:bold;'>ERROR EN LA INSERCIÓN DE DATOS&nbsp; &nbsp;" . $th->getMessage() . "INTÉNTELODE NUEVO</p>";
        }
    } //End modifyUser

}//End class DAO_Users.
