<?php

require_once 'Model.php';
//Comme il s'agit d'un bundle, les accès bdd et la logique sont encapsulé dans la classe du bundle lui même.
include_once("Bundle/moteurPHP5.5/class.inc/BDD-PHP5.5.class-inc.php");
// Fichier contenant un tableau $stopwords pour les "stop words" (optionnel)
include_once("Bundle/moteurPHP5.5/class.inc/stopwords.php");
// Class du moteur de recherche PHP et autres
include_once("Bundle/moteurPHP5.5/class.inc/moteur-php5.5.class-inc.php");

class ModelRecherche extends Model {
    protected static $table = "series";
    protected static $primary_index = "idword";

    public static function isSubmit($rchch) {
        try {
            //valeur de idword comme :mail
            $sql = "SELECT s.title, sk.nbOccSerie FROM seriekeywords sk, series s WHERE sk.idWord = :idword AND s.idSerie = sk.idSerie";                       
            // Preparation de la requete
            $req = self::$pdo->prepare($sql);
            // execution de la requete
            $req->execute($rchch);
            return $req->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $mess) {
            echo $mess->getMessage();
            die("Erreur dans la BDD " . static::$table);
        }
    }
}
?>