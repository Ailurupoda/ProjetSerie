<?php
if(isset($_GET['q']) && !empty($_GET['q'])) {
	$query = htmlspecialchars(stripslashes($_GET['q']));

	// Récupération à la volée des informations transmises par le script d'autocomplétion
	$table	 = htmlspecialchars($_GET['t']);
	$field	 = htmlspecialchars($_GET['f']);
	$type	 = htmlspecialchars($_GET['type']);
	$encode	 = htmlspecialchars($_GET['e']);

	if(is_numeric($_GET['l'])) {
		$limitS  = htmlspecialchars($_GET['l']);
	} else {
		$limitS = 5;	
	}
	
	if($type == 0 || $type > 1) {
		$arg = "";
	} else {
		$arg = "%";	
	}

	// Connexion à la base de données PHP 5.5 --> Obligatoire !!!
	include_once("../BDD-PHP5.5.class-inc.php");
	
    // Requête de recherche dans l'index inversé (base de mots clés auto-générés)
    $requeteSQL = "SELECT DISTINCT ".$field." FROM ".$table." WHERE ".$field." LIKE '".$arg.$link->real_escape_string($query)."%' ORDER BY ".$field." ASC, idindex DESC LIMIT 0 , ".$limitS."";
    
	// Lancement de la requête
    $results = $link->query($requeteSQL) or die("Erreur : ".$link->error);
    
	// Retourne les résultats avec le système d'autocomplétion
    while($donnees = mysqli_fetch_assoc($results)) {
		$mots = $donnees[$field];
		if(preg_match("#([ ]+)#", $mots)) {
			$mots = '"'.$mots.'"';
		}
	
        if($encode == "utf-8" || $encode == "utf8" || $encode == "UTF-8" || $encode == "UTF8") {
			echo utf8_encode($mots)."\n";
		} else {
			echo $mots."\n";	
		}
    }
}
?>