<?php

define('VIEW_PATH', ROOT . DS . 'view' . DS);

//on va chercher le modèle dans l'emplacement "./model/ModelUsers.php"
require_once MODEL_PATH . 'Model' . ucfirst($controller) . '.php';

switch($action) {

    case "rechercher":
        //$submit = ModelRecherche::isSubmit($rchch);
        if (isset($_GET['moteur'])) {
            $moteurR = $_GET['moteur'];
        }else{$moteurR = "";}
        $nav_en_cours="recherche";
        $act = "rechercher";
        $view = "home";
        $pagetitle = "Recherche";

        $data = array("mot" => $moteurR);
      
        //DEBUGG**********
        //var_dump($data);
        //FIN DEBUGG******

        $tab_rchch = ModelRecherche::selectr($data);
        break;

    case "initial":
        //chargement de la vue recherche par défaut.
        $nav_en_cours="recherche";
        $moteurR = "";
        $act = "rechercher";
        $view = "home";
        $pagetitle = "Recherche";
        break;
}
require VIEW_PATH . "view.php";