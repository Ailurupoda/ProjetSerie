<?php

define('VIEW_PATH', ROOT . DS . 'view' . DS);

//on va chercher le modèle dans l'emplacement "./model/ModelUsers.php"
require_once MODEL_PATH . 'Model' . ucfirst($controller) . '.php';

switch($action) {


    case "like":
        if(empty($_SESSION['mail']) || is_null(myGet('idSerie'))){
            $view = "error";
            $pagetitle = "Erreur";
            $msg = "Aucun utilisateur sélectionné";
            break;  
        }
    	require_once MODEL_PATH . 'ModelUsers.php';
    	$data = array("mail" => $_SESSION['mail']);
        $tab_count_liked = ModelLiked::countLike();
        $page = 1;
        $perPage = 20;
        $nb = $tab_count_liked[0]->nbLike / $perPage;
        $nbPages = round($nb);
    	$i = ModelUsers::getId($data);
    	$data = array(
    		"idUser" => $i["idUser"],
    		"idSerie" => myGet('idSerie')
    	);
        $exists = ModelLiked::existId($data);
        if(($exists)>0){
            $view = "error";
            $pagetitle = "Erreur";
            $msg = "Vous avez déjà aimé cette série";
            break;  
        }
    	ModelLiked::insert($data);

    	$tab_lik = ModelLiked::selectTitleWhere($i);
       $nav_en_cours="like";

    	$view = "list";
    	$pagetitle = "List liked";
    	break;

    case "unLike" :
        if(empty($_SESSION['mail']) || is_null(myGet('idSerie'))){
            $view = "error";
            $pagetitle = "Erreur";
            $msg = "Aucun utilisateur sélectionné";
            break;  
        }
    	require_once MODEL_PATH . 'ModelUsers.php';
    	$data = array("mail" => $_SESSION['mail']);
        $tab_count_liked = ModelLiked::countLike();
        $page = 1;
        $perPage = 20;
        $nb = $tab_count_liked[0]->nbLike / $perPage;
        $nbPages = round($nb);
    	$i = ModelUsers::getId($data);

    	$data = array(
    		"idUser" => $i["idUser"],
    		"idSerie" => myGet('idSerie')
    	);
        $exists = ModelLiked::existId($data);
        if(($exists) == 0){
            $view = "error";
            $pagetitle = "Erreur";
            $msg = "Vous avez déjà aimé cette série";
            break;  
        }
    	ModelLiked::deleteLike($data);

    	$tab_lik = ModelLiked::selectTitleWhere($i);
        $nav_en_cours="like";
    	$view = "list";
    	$pagetitle = "List Like";
    	break;

        
	default:
    //si l'action est inconnue, on effectue 'readAll'
    case "readAll" :
    require_once MODEL_PATH . 'ModelUsers.php';
    //initialisation des variables pour la vue
    $tab_count_liked = ModelLiked::countLike();
    $page = 1;
    $perPage = 20;
    $nb = $tab_count_liked[0]->nbLike / $perPage;
    $nbPages = round($nb);
    $data = array("mail" => $_SESSION['mail']);
    $i = ModelUsers::getId($data);
    array_push($i,($page-1)*$perPage);
    $tab_lik = ModelLiked::selectPage($i);
    $nav_en_cours="like";
    $view = "list";
    $pagetitle = "List Like";
    break;
        
    case "readPage" :
        require_once MODEL_PATH . 'ModelUsers.php';
        //initialisation des variables pour la vue
        $tab_count_liked = ModelLiked::countLike();
        $page = intval($_GET["page"]);
        $perPage = 20;
        $nb = $tab_count_liked[0]->nbLike / $perPage;
        $nbPages = round($nb);
        $data = array("mail" => $_SESSION['mail']);
        $i = ModelUsers::getId($data);
        array_push($i,($page-1)*$perPage);
        $tab_lik = ModelLiked::selectPage($i);
        $nav_en_cours="like";
        $view = "list";
        $pagetitle = "List Like";
        break;

}
require VIEW_PATH . "view.php";



