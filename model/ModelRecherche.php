<?php

require_once 'Model.php';
//Comme il s'agit d'un bundle, les accès bdd et la logique sont encapsulé dans la classe du bundle lui même.
include_once("Bundle/moteurPHP5.5/class.inc/BDD-PHP5.5.class-inc.php");
// Fichier contenant un tableau $stopwords pour les "stop words" (optionnel)
include_once("Bundle/moteurPHP5.5/class.inc/stopwords.php");
// Class du moteur de recherche PHP et autres
include_once("Bundle/moteurPHP5.5/class.inc/moteur-php5.5.class-inc.php");

class ModelRecherche extends Model {
    protected static $table = "keywords";
    protected static $table2 = "seriesKeywords";
    protected static $table3 = "series";
}
?>