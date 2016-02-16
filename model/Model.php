<?php

// On va chercher le fichier de configuration dans "./config/Conf.php"
require_once ROOT . DS . 'config' . DS . 'Conf.php';

class Model {

    public static $pdo;

    public static function set_static() {
        $host = Conf::getHostname();
        $dbname = Conf::getDatabase();
        $login = Conf::getLogin();
        $pass = Conf::getPassword();

        try {
            // Connexion à la base de données            
            // Le dernier argument sert à ce que toutes les chaines de charactères 
            // en entrée et sortie de MySql soit dans le codage UTF-8
            self::$pdo = new PDO("mysql:host=$host;dbname=$dbname", $login, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

            // On active le mode d'affichage des erreurs, et le lancement d'exception en cas d'erreur
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            if (Conf::getDebug()) {
                echo $ex->getMessage();
                die('Problème lors de la connexion à la base de donnée');
            } else {
                echo 'Une erreur est survenue. <a href=""> Retour a la page d\'accueil </a>';
            }
            die();
        }
    }

    public static function selectAll() {
        try {
            $sql = "SELECT * FROM " . static::$table;
            $req = self::$pdo->query($sql);
            // fetchAll retoure un tableau d'objets représentant toutes les lignes du jeu d'enregistrements 
            return $req->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche de tous les objets de la BDD " . static::$table);
        }
    }

    public static function select($data) {
        try {
            $table = static::$table;
            $primary = static::$primary_index;
            $sql = "SELECT * FROM $table WHERE $table.$primary = :$primary";
            // Preparation de la requete
            $req = self::$pdo->prepare($sql);
            // execution de la requete
            $req->execute($data);

            if ($req->rowCount() != 0)
                return $req->fetch(PDO::FETCH_OBJ);
            return null;  // Optionel : si return est omis, Php envoie null dans tous les cas
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la BDD " . static::$table);
        }
    }

    public static function selectWhere($data) {
        try {
            $table = static::$table;
            $primary = static::$primary_index;
            $where = "";
            foreach ($data as $key => $value)
                $where .= " $table.$key=:$key AND";
            $where = rtrim($where, 'AND');
            $sql = "SELECT * FROM $table WHERE $where";
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
    
    public static function delete($data) {
        try {
            $table = static::$table;
            $primary = static::$primary_index;
            $sql = "DELETE FROM $table WHERE $table.$primary = :$primary";
            // Preparation de la requete
            $req = self::$pdo->prepare($sql);
            // execution de la requete
            return $req->execute($data);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la suppression dans la BDD " . static::$table);
        }
    }

    public static function insert($data) {
        try {
            $table = static::$table;
            $indices = "";
            $values = "";
            foreach ($data as $key => $value) {
                $indices .= "$key, ";
                $values .= ":$key, ";
            }
            $indices = '(' . rtrim($indices, ', ') . ')';
            $values = '(' . rtrim($values, ', ') . ')';
            $sql = "INSERT INTO $table $indices VALUES $values";
            // Preparation de la requete
            $req = self::$pdo->prepare($sql);
            // execution de la requete
            return $req->execute($data);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de l\'insertion dans la BDD " . static::$table);
        }
    }

    public static function update($data) {
        try {
            $table = static::$table;
            $primary = static::$primary_index;
                    
            $update = "";
            foreach ($data as $key => $value)
                $update .= "$key=:$key, ";
            $update = rtrim($update, ', ');
            $sql = "UPDATE $table SET $update WHERE $primary=:$primary";           
            
            // Preparation de la requete
            $req = self::$pdo->prepare($sql);
            // execution de la requete
            return $req->execute($data);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la mise à jour dans la BDD " . static::$table);
        }
    }

}

// On initiliase la connexion $pdo un fois pour toute
Model::set_static();
?>
