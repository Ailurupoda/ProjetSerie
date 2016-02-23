<?php

require 'Config/Session.php';
session_start();

function myGet($nomvar) {
    if(isset($_GET[$nomvar])){
        return $_GET[$nomvar];
    }
    if(isset($_POST[$nomvar])){
        return $_POST[$nomvar];
    }
    return null;
}

define('MODEL_PATH', ROOT . DS . 'model' . DS);

if (!is_null(myGet('controller')))
    $controller = myGet('controller'); //recupere le controlleur passe dans l'url
else
    $controller = "users";

if (!is_null(myGet('action')))
    $action = myGet('action');    //recupere l'action  passee dans l'url
else
    $action = "readAll";

switch ($controller) {
    
        
    case "series" :
        require_once "ControllerSeries.php";
        break;

    default:

    case "users":
        require_once "ControllerUsers.php";
        break;
        
}
?>