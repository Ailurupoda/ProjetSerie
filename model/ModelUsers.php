<?php

require_once 'Model.php';

class ModelUsers extends Model {
    protected static $table = "users";
    protected static $primary_index = "mail";

    public static function isAdmin($data) {
        try {
            $sql = "SELECT * FROM users u WHERE u.mail = :mail AND u.admin != 0";                       
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
}

?>