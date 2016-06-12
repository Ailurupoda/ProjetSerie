<?php

define('VIEW_PATH', ROOT . DS . 'view' . DS);

//on va chercher le modèle dans l'emplacement "./model/ModelUsers.php"
require_once MODEL_PATH . 'Model' . ucfirst($controller) . '.php';

switch($action) {


    case "create":
        $hidden_id = "";
        $t = "";
        $label = "Créer";
        $pagetitle = "Création d'une série";
        $submit = "Création";
        $act = "save";
        $view = "create";
        break;

    case "save":
        if (!(isset($_GET['title']))) {
            $view = "error";
            $pagetitle = "Erreur";
            break;
        }
        $data = array(
            "title" => $_GET["title"]          
        );
        $i = ModelSeries::insert($data);
        // Initialisation des variables pour la vue
        $tab_series = ModelSeries::selectAll();
        // Chargement de la vue
        $hidden_id = "";
        $t = "";
        $label = "Créer";
        $submit = "Création";
        $act = "save";
        $view = "created";
        $pagetitle = "Liste des séries";
        break;

    case "inserting":
        $tab_series = ModelSeries::selectAll();
        $hidden_id = "";
        $idS ="";
        $t = "";
        $label = "Insérer";
        $submit = "Insertion";
        $act = "inserting";
       // print_r($_FILES['subtitles']);
       // print_r($_POST['title']);
        if (strlen($_POST['title'])== 0) {
            $view = "error";
            $pagetitle = "Erreur";
            $message = "Il manque le titre.";
            break;
        }
        $extensions_valides = array('srt');
        //1. strrchr renvoie l'extension avec le point (« . »).
        //2. substr(chaine,1) ignore le premier caractère de chaine.
        //3. strtolower met l'extension en minuscules.
        //print_r($_FILES['subtitles']);

        foreach ($_FILES['subtitles']['name'] as $valTest) {
           $extension_upload = strtolower(  substr(  strrchr($valTest, '.')  ,1)  );
            if ( !in_array($extension_upload,$extensions_valides) ){
                $view = "error";
                $pagetitle = "Erreur";
                $message = "Vous n'avez pas choisi un fichier avec l'extension '.srt' attention.";
                break;
            }
        }
        /*if (file_exists('subtitles/'.$_FILES['subtitles']['name'])) {
            $view = "error";
            $pagetitle = "Erreur";
            $message = "Ce fichier a déjà été inséré.";
            break;
        }*/
        $incTs = 0;
        $incTm = 0;
        foreach ($_FILES['subtitles']['tmp_name'] as $valT2) {
            //print_r($i);
            $da = array("title" => $_POST['title']);
            $u = ModelSeries::selectWhere($da); 
            $title = $_POST['title'];
            $idS = $u[0]->idSerie;
            $uploaddir = 'C:\wamp\tmp\\';
            $uploadfile = $uploaddir . basename($valT2);
            $f = $valTest;
                if(is_uploaded_file($valT2)) {
                           if(ModelSeries::insertFile($_FILES['subtitles']['name'][$incTs])==true){

                                $data = insertion($uploadfile);
                               //$data = array("idSerie" => $idS , "word" => insertion($uploadfile));
                                //utf8_encode($data[$incTm]);
                                //print_r($data[$incTm]);
                                //print_r($data);
                                foreach ($data as $value) {
                                    utf8_encode($value);
                                   // print_r($value);
                                }
                                //print_r($data);
                                ModelSeries::insertSubtitle($data);                           
                                $idW = array();
                                foreach ($data as $value) {
                                    $i = array('word' => $value);
                                    array_push($idW, ModelSeries::getIdWords($i));  
                                }
                                //print_r($idW);
                                //$idW = ModelSeries::getIdWords($data);                          
                                $data2 = array($idS);
                                foreach ($idW as $v) { 
                                    array_push($data2, $v[0]->idWord);
                                    //ModelSeries::insertSubtitleSerie(array('idSerie' => $idS, 'idWord' => $v[0]->idWord));
                                    //foreach ($v as $value) {                                                              
                                        //ModelSeries::insertSubtitleSerie(array('idSerie' => $idS, 'idWord' => $value->idWord));
                                    //array_push($data2,array('idSerie' => $idS, 'idWord' => $value->idWord));
                                    //}
                                }
                                //print_r($data2);
                                ModelSeries::insertSubtitleSerie($data2);
                                //print_r($data2);
                                //ModelSeries::insertSubtitleSerie($data2);
                                //$id = ModelSeries::selectIdWords($data);

                            }
                } else {
                    echo "Attaque potentielle par téléchargement de fichiers.
                          Voici plus d'informations :\n";
                    echo 'Voici quelques informations de débogage :';
                }
                $incTs++;
                //print_r($incTs);
        }
        


    case "insert":
        $tab_series = ModelSeries::selectAll();
        $hidden_id = "";
        $idS ="";
        $t = "";
        $label = "Insérer";
        $pagetitle = "Insertion de sous-titres";
        $submit = "Insertion";
        $act = "inserting";
        $view = "insert";
    break;

    default :
    
    case "readAll":
    //initialisation des variables pour la vue
    $tab_series = ModelSeries::selectAll();
    //chargement de la vue
    $view = "list";
    $pagetitle = "Listing";
    break;

}
require VIEW_PATH . "view.php";