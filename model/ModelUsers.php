<?php

require_once 'Model.php';

class ModelUsers extends Model {
    protected static $table = "users";
    protected static $primary_index = "idUser";

 
    public static function selectSeriesRand() { // afficher tous les éléments de la table
        try {
            $sql = "SELECT title FROM series ORDER BY Rand() LIMIT 10";
            $req = self::$pdo->query($sql);
            // fetchAll retoure un tableau d'objets représentant toutes les lignes du jeu d'enregistrements 
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche de tous les objets de la BDD series");
        }
    }


    public static function isAdmin($data) {
        try {
            $sql = "SELECT * FROM users u WHERE u.idUser = :idUser AND u.admin != 0";                       
            // Preparation de la requete
            $req = self::$pdo->prepare($sql);
            // execution de la requete
            $req->execute($data);
            return $req->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $mess) {
            echo $mess->getMessage();
            die("Erreur dans la BDD " . static::$table);
        }
	}

    public static function getId($data){
        try{
            $sql = "SELECT idUser FROM users u WHERE u.mail = :mail";

            $req = self::$pdo->prepare($sql);

            $req->execute($data);

            return $req->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $mess){
            echo $mess->getMessage();
            die("Erreur dans le BDD " . static::$table);
        }
    }


        public static function top5Words($data) {
        try {
            $sql = "SELECT idWord FROM seriesKeywords S WHERE S.idSerie = :idSerie ORDER BY nbOcc DESC LIMIT 10 ";                       
            // Preparation de la requete
            $req = self::$pdo->prepare($sql);
            // execution de la requete
            $req->execute($data);
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $mess) {
            echo $mess->getMessage();
            die("Erreur dans la BDD " . static::$table);
        }
    }

    public static function listLiked($data) {
        try{
            $sql = "SELECT idSerie FROM liked l WHERE l.idUser = :idUser";
            // Preparation de la requete
            $req = self::$pdo->prepare($sql);
            // execution de la requete
            $req->execute($data);
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $mess){
            echo $mess->getMessage();
            die("Erreur dans la BDD" . static::$table);
        }
    }

    public static function listSeriesNotLiked($data) {
        try{
            $sql = "SELECT idSerie FROM series WHERE idSerie NOT IN (SELECT idSerie FROM liked l WHERE l.idUser = :idUser)";
           // Preparation de la requete
            $req = self::$pdo->prepare($sql);
            // execution de la requete
            $req->execute($data);
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $mess){
            echo $mess->getMessage();
            die("Erreur dans la BDD" . static::$table);
        }
    }

    public static function getTitle($data){
        try{
            $sql = "SELECT title FROM series s WHERE s.idSerie = :idSerie";
           // Preparation de la requete
            $req = self::$pdo->prepare($sql);
            // execution de la requete
            $req->execute($data);
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $mess){
            echo $mess->getMessage();
            die("Erreur dans la BDD" . static::$table);
        }
    }

}

?>