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
        $nav_en_cours="create";
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
        $nav_en_cours="create";
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
    	if ($_POST['title']=='') {
            $view = "error";
            $pagetitle = "Erreur";
            $message = "Il manque le titre.";
            break;
        }
		$extensions_valides = array('srt');
		//1. strrchr renvoie l'extension avec le point (« . »).
		//2. substr(chaine,1) ignore le premier caractère de chaine.
		//3. strtolower met l'extension en minuscules.
		$extension_upload = strtolower(  substr(  strrchr($_FILES['subtitles']['name'], '.')  ,1)  );
		if ( !in_array($extension_upload,$extensions_valides) ){
			$view = "error";
            $pagetitle = "Erreur";
            $message = "Vous n'avez pas choisi un fichier avec l'extension '.srt' attention.";
            break;
		}
		/*if (file_exists('subtitles/'.$_FILES['subtitles']['name'])) {
			$view = "error";
            $pagetitle = "Erreur";
            $message = "Ce fichier a déjà été inséré.";
            break;
		}*/
        $da = array("title" => $_POST['title']);
        $u = ModelSeries::selectWhere($da); 
        $title = $_POST['title'];
        $idS = $u[0]->idSerie;
        $uploaddir = 'D:\test\wamp\tmp\\';
		$uploadfile = $uploaddir . basename($_FILES['subtitles']['tmp_name']);
        $f = $_FILES['subtitles']['name'];
			if(is_uploaded_file($_FILES['subtitles']['tmp_name'])) {
                       if(ModelSeries::insertFile($_FILES['subtitles'])==true){
                            $data = insertion($uploadfile);
                           //$data = array("idSerie" => $idS , "word" => insertion($uploadfile));
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

			/*echo 'Voici quelques informations de débogage :';
			print_r($_FILES);

			echo '</pre>';*/
        $nav_en_cours="insert";
			$view='inserting';
    break;

    case "insert":
    	$tab_series = ModelSeries::selectAll();
    	$hidden_id = "";
        $idS ="";
        $t = "";
        $label = "Insérer";
        $pagetitle = "Insertion de sous-titres";
        $submit = "Insertion";
        $nav_en_cours="insert";
        $act = "inserting";
        $view = "insert";
    break;

    case "readAll":
    //initialisation des variables pour la vue
    $tab_count_series = ModelSeries::countSeries();
    //chargement de la vue
    $view = "list";
    $page = 1;
    $perPage = 20;
    $nb = $tab_count_series[0]->nbSeries / $perPage;
    $nbPages = round($nb);
    $pagetitle = "Listing";
    $nav_en_cours="liste";
    $data = array(0 => $page, 1 => $perPage);
    $tab_series = ModelSeries::selectPage($data);
    break;
        case "readPage":
    //initialisation des variables pour la vue
    $tab_count_series = ModelSeries::countSeries();
    //chargement de la vue
    $view = "list";
    $page = intval($_GET["page"]);
    $perPage = 20;
    $nb = $tab_count_series[0]->nbSeries / $perPage;
    $nbPages = round($nb);
    $pagetitle = "Listing";
    $nav_en_cours="liste";
    $data = array(0 => $page, 1 => $perPage);
    $tab_series = ModelSeries::selectPage($data);
    break;

}
require VIEW_PATH . "view.php";