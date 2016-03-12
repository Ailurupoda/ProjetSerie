<?php

define('VIEW_PATH', ROOT . DS . 'view' . DS);

//on va chercher le modèle dans l'emplacement "./model/ModelUsers.php"
require_once MODEL_PATH . 'Model' . ucfirst($controller) . '.php';

switch($action) {

    case "rechercher":
        //$submit = ModelRecherche::isSubmit($rchch);
        $rchch = array("idword" => myGet('idword'));
        $act = "rechercher";
        $view = "home";
        $pagetitle = "Recherche";
        break;

    default:
    case "initial":
        //chargement de la vue recherche par défaut.
        $rchch = array("idword" => "");
        $act = "rechercher";
        $view = "home";
        $pagetitle = "Recherche";
        break;
}
require VIEW_PATH . "view.php";