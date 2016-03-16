<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Moteur de recherche - Mode normal</title>
<link type="text/css" rel="stylesheet" href="class.inc/autocompletion/jquery.autocomplete.css" />
<script type="text/javascript" src="class.inc/autocompletion/jquery.js"></script>
<script type="text/javascript" src="class.inc/autocompletion/jquery.autocomplete.js"></script>
</head>

<body>
<form id="searchForm" name="moteurSubmit" method="GET" action="">
	<label for="q">Rechercher :</label>
	<input type="text" value="<?php if(isset($_GET['q'])) { echo htmlspecialchars($_GET['q']); } ?>" name="q" id="moteur" />
	<input type="submit" value="Envoyer" />
</form>
<?php
include_once("class.inc/BDD-PHP5.5.class-inc.php"); // Class PHP 5.5 (avec mysqli)
include_once("class.inc/stopwords.php");
include_once("class.inc/moteur-php5.5.class-inc.php"); // Class PHP 5.5

//
// $link se trouve dans BDD.class-inc.php, il s'agit de la variable de connexion
// Attention, elle doit absolument être utilisée (sous ce nom ou un autre) en PHP 5.5 ou supérieur
// N.B. : elle s'ajoute en début d'appel des class moteurRecherche($link...), autoCompletion($link...) et alterTableFullText($link...)
//

// Lancement de la fonction d'activation de l'autocomplétion (après la connexion !)
// $autocompletion = new autoCompletion("CHEMIN/autocompletion.php", "ID_INPUT_RECHERCHE", "NOM_DE_LA_TABLE", "NOM_DE_LA_COLONNE");
// Les autres paramètres sont détaillés dans la class PHP du moteur
$autocompletion = new autoCompletion($link, "class.inc/autocompletion/autocompletion-PHP5.5.php", "#moteur", "autosuggest", "words", true, 5, 0, false, true);

if(isset($_GET) && !empty($_GET['q'])) {
    $moteur = new moteurRecherche($link, stripslashes($_GET['q']), 'search', 'regexp', $stopwords);
    $colonnesWhere = array('title', 'description');
    $moteur->moteurRequetes($colonnesWhere);
}

if(isset($moteur)) {
    // Affichage de la requête avec $moteur->requete
    echo '<h3>Résultats de la recherche : <em>'.$moteur->requete.'</em></h3>';

	// Création de la table des mots corrects
	if($moteur->isIndex("correctindex", "table_search") == false) {
		// Créé l'index correct
		$moteur->createIndex();
	}

	// Tableau des mots puis ajout dans la table
	$motsCorrects = array("lorem", "ipsum", "dolor", "amet", "sit");
	$moteur->setIndex($motsCorrects);

	// Affichage de la correction des résultats
	$corrections = $moteur->getCorrection();
	$moteur->getCorrectedResults();
	if(!empty($corrections)) {
		echo "<p>Tentez avec une autre orthographe : ".$corrections."</p>\n";
	}

	// Fonction d'affichage des résultats (callback appelé ensuite)
	function display($requete, $nbResults, $mots) {
		if($nbResults == 0) { // Si aucun résultat n'est retourné
			echo "<p>Aucun résultat, veuillez effectuer une autre recherche !</p>";    
		} else { // Sinon on affiche les résultats en boucle
			
			// Affichage du nombre de résultats (optionnel)
			$affichageResultats = new affichageResultats();
			echo $affichageResultats->nbResultats();
			
			// Instanciation des ID (et du numéro de résultat si besoin)
			$nb = 0;
			
			// Comptage dynamique du nombre de résultats
			if(isset($_GET['p'])) {
				// $nb = 0 + (limite * (numéro de page - 1))
				$nb = $nb + (10 * ($_GET['p'] - 1));
			}
			
			while(($key = mysqli_fetch_assoc($requete))) {
				$nb++; // Incrémentation de l'ID
				
				// On encode chaque clé/valeur de résultats en UTF-8
				foreach($key as $k => $v) {
					 $key[$k] = utf8_encode($v);
				}

				// Résultats de recherche à afficher (à personnaliser)
				$texte  = "<div class='results' id='".$nb."'>\n";
				$texte .= "\t<h3>".$nb." - ".$key['title']."</h3>\n";
				$texte .= "\t<p>".$key['description']."</p>\n";
				$texte .= "</div>\n";

				// Affichage du contenu après surlignage des mots recherchés
				// N.B. : optionnel --> possibilité de remplacer par echo $texte;
				$surlignage = new surlignageMot($mots, $texte);
				echo $surlignage->contenu;
			} // Fin de la boucle while
		}
	} // Fin de la fonction display (callback)

	// Nombre de résultats par "tranche d'affichage"
	$limit = 10;
	
	// Numéro de page récupéré dynamiquement
	if(isset($_GET['p'])) {
		$page = htmlspecialchars($_GET['p']);
	} else {
		$page = 0;
	}
	
	// Lancement de la fonction d'affichage avec paramètres
	$moteur->moteurAffichage('display', '', array(true, $page, $limit, true));
	
	// Ajout de la fonction de pagination
	// N.B. : le second paramètre correspond au "name" de $_GET['p']
	$moteur->moteurPagination($page, 'p');
	
	// Fonction d'ajout automatique des mots recherchés dans un index de mots-clés (colonne 'autosuggest' ici)
	// N.B. : cette méthode est optionnelle si vous possédez déjà une table avec des mots-clés...
	$autocompletion->autoComplete(stripslashes($_GET['q']));
}
?>
</body>
</html>