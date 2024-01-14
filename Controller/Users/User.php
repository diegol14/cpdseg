<?php

/**
 * Clase que crea objetos usuario para su manipulación
 */


class User
{

    private $Id;
    private $name;
    private $email;
    private $rol;
    private $password;
    private $provincia;

    /**
     *  function summary
     *Constructor vacío para crear 2 tipos de usuario
     * con funciones estáticas 
     **/
    public function __construct()
    {
    }

    /**
     * function summary
     * Esta función crea el tipo de usuario loginUser para pasar al DAO para el acceso
     * Undocumented function long description
     * @param Type String $var nombre y contraseña
     * @return type objeto user
     **/
    public static function loginUserCreate($name, $password)
    {

        $loginUser = new User();
        $loginUser->name = $name;
        $loginUser->password = $password;
        return $loginUser;
    }

    public static function rolUserCreate( $name, $rol, $password, $Id ){
        $rolUser = new User();
        $rolUser->name = $name;
        $rolUser->rol = $rol;
        $rolUser->password = $password;
        $rolUser->Id = $Id;
        return $rolUser;
    }

    
    /* Esta función crea el tipo de usuario fullUser para pasar al DAO para CRUD */
    public static function fullUserCreate($name, $email, $rol, $password, $provincia)
    {
        $fullUser = new User();
        $fullUser->name = $name;
        $fullUser->email = $email;
        $fullUser->rol = $rol;
        $fullUser->password = $password;
        $fullUser->provincia = $provincia;
        return $fullUser;
    }

   /**
     * Set the value of Id
     *
     * @return  self
     */ 
    public function setId($Id)
    {
        $this->Id = $Id;

        return $this;
    }
    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the value of rol
     *
     * @return  self
     */ 
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get the value of Id
     */ 
    public function getId()
    {
        return $this->Id;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of rol
     */ 
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the value of provincia
     */ 
    public function getProvincia()
    {
        return $this->provincia;
    }

    public static function is_valid_email($strEmail)
{
  return (false !== filter_var($strEmail, FILTER_VALIDATE_EMAIL));
}

public function showUser(){
  if (!empty($this->getName()))$name = $this->getName();
  echo "Nombre: ".$name."<br>";
  if (!empty($this->getEmail()))$email = $this->getEmail();
  echo "Email: ".$email."<br>";
  if (!empty($this->getRol()))$rol = $this->getRol();
  echo "Rol: ".$rol."<br>";
  if (!empty($this->getPassword()))$password = $this->getPassword();
  echo "Password: ".$password."<br>";
  if (!empty($this->getProvincia()))$provincia = $this->getProvincia();
  echo "Provincia: ".$provincia."<br>";

}//End function

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
}//End class
