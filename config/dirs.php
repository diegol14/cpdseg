<?php

 $_SERVER['DOCUMENT_ROOT'];///home/u194042960/domains/cpdseg.online/public_html
 
 define('ROOT_PATH','/home/u194042960/domains/cpdseg.tech/public_html' ); //$_SERVER['DOCUMENT_ROOT'].'/cpdseg''/home/u194042960/domains/cpdseg.online/public_html' 

 define('CONTROLLER_PATH', ROOT_PATH.'/Controller');

 define('USER_SERVICE_PATH', ROOT_PATH.'/Controller/Users/UserService.php');

 define ('EVENT_SERVICE_PATH', CONTROLLER_PATH.'/Events/EventService.php' );

 define ('EVENT_PATH',CONTROLLER_PATH.'/Events/Event.php');
  
define('MODEL_PATH', ROOT_PATH.'/Model');

 define('CONN_PATH', ROOT_PATH.'/Model/Connection.php');
  
 define('CONFIG_PATH', ROOT_PATH.'/config/config.php');
 
define('JS_PATH', ROOT_PATH.'js/');

 define('DAO_EVENTS_PATH', ROOT_PATH.'/Model/Events/DAO_Events.php');

 define('DAO_USERS_PATH', ROOT_PATH.'/Model/Users/DAO_Users.php');

 define('RESET_TABLE_EVENTS_PATH', ROOT_PATH.'/Model/Events/ResetTableEvents.php');

 define('MODEL_EVENTS_PATH', ROOT_PATH.'/Model/Events');

 define('SELECT_USERS_PATH', ROOT_PATH.'/Model/Users/SelectUsers.php');

define('VIEW_PATH', ROOT_PATH.'/View');
//echo '<br>'.VIEW_PATH;

define('PUBLIC_PATH', VIEW_PATH.'/public');
//echo '<br>'.PUBLIC_PATH;

define('FORM_NEW_USER_PATH',VIEW_PATH.'/public/FormNewUser.php');

define('HEADER_PATH', VIEW_PATH.'/public/Headers');

