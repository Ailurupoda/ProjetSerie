<?php

define('VIEW_PATH', ROOT . DS . 'view' . DS);

//on va chercher le modèle dans l'emplacement "./model/ModelUsers.php"
require_once MODEL_PATH . 'Model' . ucfirst($controller) . '.php';

switch($action) {

    case "recommand" :
        if(empty($_SESSION['mail'])){
            $tab_recom = ModelUsers::selectSeriesRand();
        }
        else{
            // recuperation de l'idUser
            $data = array("mail" =>  $_SESSION['mail']);
            $i = ModelUsers::getId($data);

            //recuperation des series liked par l'utilisateur
            $seriesLiked = ModelUsers::listLiked($i);
            $seriesLiked = array_map('reset', $seriesLiked);

            $listSeriesNotLiked = ModelUsers::listSeriesNotLiked($i);
            $listSeriesNotLiked = array_map('reset', $listSeriesNotLiked);
            //print_r($listSeries);

            $toRecommand = array();


            //Iteration pour chaque serie liked
            foreach($seriesLiked as $sL){
                //recuperation du top 5 des mots de la serie liked
                $top5WordsLiked = ModelUsers::top5Words(array(':idSerie' => $sL));

                foreach ($listSeriesNotLiked as $s) {
                        $top5WordsSerie = ModelUsers::top5Words(array(':idSerie' => $s));
                        //print_r($top5WordsSerie);

                        $nbMatch = 0;
                        foreach($top5WordsSerie as $t5ws){
                            foreach ($top5WordsLiked as $t5wl) {
                                if($t5ws['idWord'] == $t5wl['idWord'])
                                    $nbMatch++;
                            }
                        }
                        if($nbMatch >= 2)
                            $toRecommand[] = $s;   
                }


            }

            $tab_recom = array();
            foreach($toRecommand as $tr){
                $title = ModelUsers::getTitle(array(':idSerie' => $tr));
                $tab_recom[] = $title[0]['title'];
            }

        }
        $view = "recommand";
        $pagetitle = "Recommandations";
        break;    



    case "profil":
        if (empty($_SESSION['mail'])) {
            $view = "error";
            $pagetitle = "Erreur";
            $msg = "Vous n'êtes pas connecté";
            break;
        }
        
        $data  =  ModelUsers::getId(array("mail" => $_SESSION['mail']));

        $u = ModelUsers::select($data);

        $m = $u->mail;
        $pwd = $u->password;
        $birth = $u->birth;
        $adm = $u->admin;
        $r = "readonly"; 
        $label = "Profil";
        $pagetitle = "Profil";
        $submit = "Mettre à jour";
        $act = "updated";
        $view = "profil";
        break;



    case "create":
        if (!empty($_SESSION['mail'])  && ($_SESSION['admin'] != 1)) {
            $view = "error";
            $pagetitle = "Erreur";
            $msg = "Vous ne pouvez pas vous inscrire car vous êtes déjà connecté";
            break;
        }
        $m = "";
        $pwd = "";
        $birth = "";
        $adm = "";
        $r = "required";
        $label = "Créer";
        $pagetitle = "Création d'un utilisateur";
        $submit = "S'inscrire";
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
        $curDate = date('Y-m-d');
        if (($curDate -myGet('birth')) < 17) {
            $view = "error";
            $pagetitle = "Erreur";
            $msg = "Vous n'avez pas l'age requis pour vous inscrire ";
            break;
        }else{
        if(((10*$curDate[5] + $curDate[6]) - (10*(myGet('birth')[5]) + myGet('birth')[6])) < 0){
            $view = "error";
            $pagetitle = "Erreur";
            $msg = "Vous n'avez pas l'age requis pour vous inscrire ";
            break;
            }     
        } 
        if(myGet('password') != myGet('password2')) {
            $view = 'error';
            $pagetitle = 'Erreur';
            $msg = "Les mots de passe ne correspondent pas";
            break;
        }
        $data = array(
            "mail" => myGet("mail"),
            "password" => hash('sha256', myGet('password') . Conf::getSeed()),
            "birth" => myGet("birth")
        );

        ModelUsers::insert($data);
        // Initialisation des variables pour la vue
        $m = myGet('mail');
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

        $id  =  ModelUsers::getId(array("mail" => myGet('mail')));
        $data = array(
            "idUser" => $id['idUser'],
            "birth" => myGet('birth'),
            "mail" => myGet('mail'),
            "password" => hash('sha256', myGet('pwd') . Conf::getSeed())
        );

        ModelUsers::update($data);

        $u = ModelUsers::select($id);

        $m = $u->mail;
        $pwd = $u->password;
        $birth = $u->birth;
        $adm = $u->admin;
        $r = "readonly";   
        $pagetitle = "Profil";
        $submit = "Mettre à jour";
        $act = "updated";
        $view = "profil";
        break;

    case "connect":
        $m = "";
        $ConnectPassword = "";
        $submit = "Connexion";
        $act = "connected";
        $label = "Connecter";
        $view = "connect";
        $pagetitle = "Connection";
        break;

    case "connected":

        if (is_null(myGet('mail'))){
            $view = "error";
            $pagetitle = "Erreur";
            $msg = "Aucun identifiant saisie";
            break;  
        }

         $data  =  ModelUsers::getId(array("mail" => myGet('mail')));
    
        if (COUNT(ModelUsers::selectWhere($data))==0) {
            $view = "error";
            $pagetitle = "Erreur";
            $msg = "L'utilisateur n'existe pas";
            break;         
        }
        $u = ModelUsers::select($data);
        $i = $u->idUser;
        $m = $u->mail;
        $pwd = $u->password;
      
        if (is_null(myGet('mail') || is_null(myGet('ConnectPassword'))) || $pwd != hash('sha256', myGet('ConnectPassword') . Conf::getSeed())) {
            $m = "";
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