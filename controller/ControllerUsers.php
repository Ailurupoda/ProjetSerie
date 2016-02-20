<?php

define('VIEW_PATH', ROOT . DS . 'view' . DS);

//on va chercher le modèle dans l'emplacement "./model/ModelUsers.php"
require_once MODEL_PATH . 'Model' . ucfirst($controller) . '.php';

switch($action) {

    case "update":
        if (is_null(myGet('mail'))) {
            $view = "error";
            $pagetitle = "Erreur";
            $msg = "Mail non trouvé";
            break;
        }

        $data = array("mail" => myGet('mail'));
        $u = ModelUser::select($data);

        $m = $u->mail;
        $pwd = $u->password;
        $adm = $u->admin;
        $r = "readonly";   
        $label = "Modifier";
        $login_status = "readonly";
        $pagetitle = "Modification d'un utilisateur";
        $submit = "Mettre à jour";
        $act = "updated";
        $view = "create";
        break;

case "create":
        if (!empty($_SESSION['mail'])  && ($_SESSION['admin'] != 1)) {
            $view = "error";
            $pagetitle = "Erreur";
            $msg = "Vous êtes déjà connecté";
            break;
        }
        $m = "";
        $pwd = "";
        $adm = "";
        $r = "required";
        $label = "Créer";
        $login_status = "required";
        $pagetitle = "Création d'un utilisateur";
        $submit = "Création";
        $act = "save";
        $view = "create";
        break;

    case "save":
         if (is_null(myGet('mail') || is_null(myGet('password')))){ 
            $view = "error";
            $pagetitle = "Erreur";
            $msg = "Tous les champs n'ont pas été remplis";
            break;
        }
        if(myGet('pwd') != myGet('pwd2')) {
            $view = 'error';
            $pagetitle = 'Erreur';
            $msg = "Les mots de passe ne correspondent pas";
            break;
        }
        $data = array(
            "mail" => myGet("mail"),
            "password" => hash('sha256', myGet('pwd') . Conf::getSeed())
        );

        ModelUsers::insert($data);
        // Initialisation des variables pour la vue
        $mail = myGet('mail');
        $tab_util = ModelUsers::selectAll();
        if (Session::is_admin()) {
            $view = "home";
            $pagetitle = "Accueil";
            break;
        }else{
            $ConnectPassword = myGet('pwd');
            $submit = "Connexion";
            $act = "connected";
            $label = "Se Connecter";
            $view = "connect";
            $pagetitle = "Connection";
            break;
        }
        // Chargement de la vue
        

    case "updated":
        if (is_null(myGet('mail')) || is_null(myGet('pwd')) || is_null(myGet('pwd2')) ){ 
            $view = "error";
            $pagetitle = "Erreur";
            $msg = "Tous les champs n'ont pas été remplis";
            break;
        }
        if(myGet('pwd') != myGet('pwd2')) {
            $view = 'error';
            $pagetitle = 'Erreur';
            $msg = "Les mots de passe ne correspondent pas";
            break;
        }
        $data = array(
            "mail" => myGet("mail"),
            "admin" => myGet("admin"),
            "pwd" => hash('sha256', myGet('pwd') . Conf::getSeed())
        );
        ModelUsers::update($data);
        $Login = myGet('mail');
        $tab_util = ModelUsers::selectAll();
        $view = "updated";
        $pagetitle = "Liste des Utilisateurs";
        break;

    case "connect":
        $mail = "";
        $ConnectPassword = "";
        $submit = "Connexion";
        $act = "connected";
        $label = "Connecter";
        $view = "connect";
        $pagetitle = "Connection";
        break;

    case "connected":
        $data = array("mail" => myGet('mail'));
        if (COUNT(ModelUsers::selectWhere($data))==0) {
            $view = "error";
            $pagetitle = "Erreur";
            $msg = "L'utilisateur n'existe pas";
            break;         
        }
        $u = ModelUsers::select($data);
        $m = $u->mail;
        $pwd = $u->password;

        if (is_null(myGet('mail') || is_null(myGet('ConnectPassword'))) || $pwd != hash('sha256', myGet('ConnectPassword') . Conf::getSeed())) {
            $mail = "";
            $ConnectPassword = "";
            $submit = "Connexion";
            $act = "connected";
            $label = "Mauvais mot de passe";
            $view = "connect";
            $pagetitle = "Connection";
            break;
        }

        $admini = ModelUsers::isAdmin($data);
        $logValide = ModelUsers::selectWhere($data);
        if(COUNT($logValide) == 1){
            $_SESSION['mail'] = myGet('mail');
            $_SESSION['ConnectPassword'] = myGet('ConnectPassword');
            if(COUNT($admini) != 0){
                $_SESSION['admin'] = 1;
            } 
            else{
                $_SESSION['admin'] = 0;
            }
            // Initialisation des variables pour la vue
            $tab_util = ModelUsers::selectAll();
            // Chargement de la vue
            $view = "home";
            $pagetitle = "Connexion";
        }
        else{
            $view = "error";
            $pagetitle = "Erreur";  
            $msg = "Mauvais mot de passe";
        }
        break;

    case "deconnect":
       
        session_destroy();
        unset($_SESSION);
        $view = "home";
        $pagetitle = "Accueil";

        break;



    default:
    //si l'action est inconnue, on effectue 'readAll'

    case "home" :
    //initialisation des variables pour la vue
    //chargement de la vue
    $view = "home";
    $pagetitle = "Home page";
    break;

}
require VIEW_PATH . "view.php";