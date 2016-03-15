<?php
include_once("class.inc/BDD-PHP5.5.class-inc.php"); // Class PHP 5.5 (avec mysqli)
include_once("class.inc/stopwords.php");
include_once("class.inc/moteur-php5.5.class-inc.php"); // Class PHP 5.5

//
// $link se trouve dans BDD.class-inc.php, il s'agit de la variable de connexion
// Attention, elle doit absolument être utilisée (sous ce nom ou un autre) en PHP 5.5 ou supérieur
// N.B. : elle s'ajoute en début d'appel des class moteurRecherche($link...), autoCompletion($link...) et alterTableFullText($link...)
//

$moteur = new moteurRecherche($link, stripslashes($_GET['q']), 'search', 'regexp', $stopwords);
$colonnesWhere = array('title', 'description');
$moteur->moteurRequetes($colonnesWhere);

if(isset($moteur)) {
	function affichage($requete, $nbResults, $mots) {
		// Récupération du numéro de résultats
		$nb = $_GET['nb'];
		
		while(($key = mysqli_fetch_assoc($requete)) && $nb < $nbResults) {
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
	} // Fin de la fonction display (callback)

	// Nombre de résultats par "tranche d'affichage"
	$limit = htmlspecialchars($_GET['limit']);
	
	// Numéro de page récupéré dynamiquement
	if(isset($_GET['nb'])) {
		$page = htmlspecialchars($_GET['nb']);
	} else {
		$page = 0;
	}
	
	// Lancement de la fonction d'affichage avec paramètres
	$moteur->moteurAffichage('affichage', '', array(true, $page, $limit, false));
}
?>