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

}

?>

