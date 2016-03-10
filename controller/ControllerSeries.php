<?php

define('VIEW_PATH', ROOT . DS . 'view' . DS);

//on va chercher le modèle dans l'emplacement "./model/ModelUsers.php"
require_once MODEL_PATH . 'Model' . ucfirst($controller) . '.php';

switch($action) {


    default:
    //si l'action est inconnue, on effectue 'readAll'
    case "readAll" :
    //initialisation des variables pour la vue
    $tab_serie = ModelSeries::selectAll();
    //chargement de la vue
    $view = "list";
    $pagetitle = "Listing";
    break;

}
require VIEW_PATH . "view.php";