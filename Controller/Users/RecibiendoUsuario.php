<?php
//session_start();              
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Origin: *');

include_once $_SERVER['DOCUMENT_ROOT'] . '/config/dirs.php';
include_once 'User.php';  // CONTROLLER_PATH . '/Users/
include_once 'UserService.php';  //'CONTROLLER_PATH . '/Users/

echo "recept";

if (isset($_POST['name']) & isset($_POST['password'])) {
  echo "recept";
  try{ receivingUser();
  }catch (\Throwable $th) {
      echo $th->getCode() . $th->getMessage();
  }
}

/* Esta función llama al servicio UserService login 
si está definido el formulario que envía usuario y contraseña */
function  receivingUser()
{
   $name = $_POST['name']; # code...
    $password = $_POST['password'];
   //Construyo el user para pasar como parámetro al servicio UserService 
   $loginUser = User::loginUserCreate($name, $password);
   ($loginUser->getName().$loginUser->getPassword()."  Rec User   ");
   if (isset($loginUser)) {
      try {
         $daoUser = UserService::userLogin($loginUser);
         $name = $daoUser->name;
         $rol = $daoUser->rol;
         $Id = $daoUser->Id;
         echo json_encode($daoUser); 
         if(!empty($rol)  && $rol !=null){
            if (session_status() == PHP_SESSION_NONE) {
               session_start();
           }
         
         $_SESSION["rol"] = $rol;
         $_SESSION["name"] = $name;
         $_SESSION["Id"] = $Id;
         $timestart = intval(time());
         $_SESSION["timestart"] = $timestart;
         session_write_close();
         if(isset($_SESSION["rol"]));{
            try {
               //función que inserta login sucessful en tabla login,
               // el 1 corresponde a ingresar y el 0 a salir
               DAO_Users::insertLogin($Id,1);
           } catch (\Throwable $th) {
               echo $th->getFile();
               echo $th->getLine();
               echo $th->getMessage();
           }
         }
               
      }
        
      } catch (\Throwable $th) {
         echo $th->getCode() . $th->getMessage();
      }
   }
 
}
