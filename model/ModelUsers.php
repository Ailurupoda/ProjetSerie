<?php

require_once 'Model.php';

class ModelUsers extends Model {
    protected static $table = "users";
    protected static $primary_index = "idUser";

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
}

?>