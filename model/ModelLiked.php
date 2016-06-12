<?php

require_once 'Model.php';

class ModelLiked extends Model {
    protected static $table = "liked";
    protected static $primary_index = "";

    public static function deleteLike($data){
    	try{
    		$sql = "DELETE FROM liked WHERE liked.idSerie = :idSerie AND liked.idUser = :idUser";

    		$req = self::$pdo->prepare($sql);

    		return $req->execute($data);
    	}catch (PDOException $e) {
    		echo $e->getMessage();
    		die("Erreur dans la BDD " . static::$table);
    	}
    }

    public static function existId($data){
        try{
            $sql = "SELECT * FROM liked l WHERE l.idUser = :idUser AND l.idSerie = :idSerie " ;

            $req = self::$pdo->prepare($sql);

            $req->execute($data);
            return $req->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            echo $e->getMessage();
            die("Erreur dans la BDD " . static::$table);    
        }
    }

    public static function selectTitleWhere($data) {
        try {
            $table = static::$table;
            $primary = static::$primary_index;
            $where = "";
            foreach ($data as $key => $value)
                $where .= " $table.$key=:$key AND";
            $where = rtrim($where, 'AND');
            $sql = "SELECT $table.idUser, $table.idSerie, s.title FROM $table, Series s WHERE $where AND $table.idSerie = s.idSerie";
            // Preparation de la requete
            $req = self::$pdo->prepare($sql);
            // execution de la requete
            $req->execute($data);
            return $req->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la BDD " . static::$table);
        }
    }
    
    public static function countLike(){
        try {
            $sql = "SELECT count(*) as nbLike FROM " . static::$table;
            $req = self::$pdo->query($sql);
            // fetchAll retoure un tableau d'objets représentant toutes les lignes du jeu d'enregistrements 
            return $req->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche de tous les objets de la BDD " . static::$table);
        }
    }
    
    public static function selectPage($data){
        try {
            $table = static::$table;
            $primary = static::$primary_index;
            $where = "";
            $where= " liked.idUser=".$data['idUser']." LIMIT $data[0]";
            $sql = "SELECT $table.idUser, $table.idSerie, s.title FROM $table, Series s WHERE $table.idSerie = s.idSerie AND $where,20";
            // Preparation de la requete
            $req = self::$pdo->prepare($sql);
            // execution de la requete
            $req->execute($data);
            return $req->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la BDD " . static::$table);
        }
    }

}

?>

