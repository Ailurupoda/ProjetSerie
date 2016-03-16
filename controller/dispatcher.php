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

function insertion($var){
    define('SRT_STATE_SUBNUMBER', 0);
    define('SRT_STATE_TIME',      1);
    define('SRT_STATE_TEXT',      2);
    define('SRT_STATE_BLANK',     3);

    $lines = file($var);
    $lines = $lines;
    $subs = array();
    $state = SRT_STATE_SUBNUMBER;
    $subText = '';


    foreach($lines as $line) {
        switch($state) {
            case SRT_STATE_SUBNUMBER:
                $subNum = trim($line);
                $state  = SRT_STATE_TIME;
                break;

            case SRT_STATE_TIME:
                $subTime = trim($line);
                $state   = SRT_STATE_TEXT;
                break;

            case SRT_STATE_TEXT:
                if (trim($line) == '') {
                    $sub = new stdClass;
                    $sub->text   = $subText;
                    $subText     = '';
                    $state       = SRT_STATE_SUBNUMBER;

                    $subs[]      = $sub->text;
                } else {
                    $subText .= $line;
                }
                break;
        }
    }
    //print_r($subs);

    /*$imparfait = '#ai(s|t|ent)$#';
    $present = '#e(s|z|nt)$|ons$#';
    $futur = '#er(a(i|s))$|ons$|ez$|ent$#';
    $passe_simple = '#a(i|s)$|â(m|t)es$|èrent$#';


    $autres = '#er|é|ant$#';
    $conjug_premier_groupe = '$indic_premier_groupe|$condi_premier_groupe|$subj_premier_groupe|$autres';*/



    $caracexclus = array('-','.','?',',',';',':','!','/',')','(','[',']','{','}');

    $motsaexclures = array('il','j','je','me','m','moi','tu','te','t','toi','nous','vous','il','elle','ils','elles','se','en','y','le','la',
    'l','d','les','lui','soi','leur','eux','lui','leur','celui','celui-ci','celui-là','celle','celle-ci',
    'celle-là','ceux','ceux-ci','ceux-là','celles','celles-ci','celles-là','ce','ceci','cela','ça',
    'mien','tien','sien','mienne','tienne','sienne','miens','tiens','qu','dans',
    'siens','miennes','tiennes','siennes','nôtre','vôtre','leur','des',
    'nôtre','vôtre','leur','nôtres','vôtres','leurs','qui','que','quoi','dont','où','lequel',
    'auquel','duquel','laquelle','à','laquelle','de','laquelle','lesquels','auxquels','desquels','lesquelles','auxquelles',
    'desquelles','qui','que','quoi','qu\'est-ce','lequel','auquel','duquel','laquelle','à','laquelle','de','laquelle',
    'lesquels','auxquels','desquels','lesquelles','auxquelles','desquelles','on','tout','un','une','l\'un','l\'une',
    'uns','unes','autre','autre','d\'autres','l\'autre','autres','aucun','aucune','aucuns',
    'aucunes','certains','certaine','certaines','tel','telle','tels','telles','tout','toute','tous','toutes',
    'même','mêmes','nul','nulle','nuls','nulles','quelqu\'un','quelqu\'une','quelques','uns',
    'quelques','personne','aucun','aucuns','autrui','quiconque','d\'aucuns','',' ','qu\'il','au','ton','mais','<','i>','à','a','est',
    'oui','pour','bien','mon','merci','était','suis','sais');


    $mots = array();

        foreach ($subs as $value) {
            $groupemots = array();
            $groupemots[] = preg_split('/[\t\r\n\v\f\s,-_:;.!"#$?`{|}~@%&\']+/', strtolower($value));
            //unset($groupemots[count($groupemots)-1]); str_replace($caracexclus, ' ', strtolower($value));

            foreach ($groupemots as $value2) {
                 
                foreach ($value2 as $value3) {
                    $value3 = trim($value3);
                    if(strlen($value3)>3){
                        $mots[] = $value3;
                        //str_replace(' ', '.', $value3);
                        //echo $value3;
                        //echo strlen($value3);
                    }
                }
            }   
        }
        return $mots;
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
   
    case "recherche" :
        require_once "ControllerRecherche.php";
        break;

    case "liked" :
        require_once "ControllerLiked.php";
        break;

    default:

    case "users":
        require_once "ControllerUsers.php";
        break;       
}
?>