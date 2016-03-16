<?php

require_once 'Model.php';

class ModelSeries extends Model {
    protected static $table = "series";
    protected static $primary_index = "idSerie";

    public static function insertSubtitle($data){
    	try{
	    	$v = "";
	        foreach ($data as $value) {
	            $v .= "('".$value."',1),";
	        }
            $v = substr($v, 0, strlen($v)-1);
            
            $v = mb_convert_encoding($v, "UTF-8");
            //print_r($v);
	        $sql = "INSERT INTO keywords (word,nbOcc) VALUES $v ON DUPLICATE KEY UPDATE nbOcc=nbOcc+1;";
	        $req = self::$pdo->prepare($sql);
            // execution de la requete
            $req->execute($data);
    	} catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la BDD keywords insertsubtitle");
        }
    }

    public static function getIdWords($data){
        try{
            $v = "(";
            foreach ($data as $value) {
                $v .= "'".$value."',";
            }
            $v = substr($v, 0, strlen($v)-1);
            $v = $v.")";
            //print_r($v);
            $v = mb_convert_encoding($v, "UTF-8");
            $sql = "SELECT * FROM keywords WHERE word IN $v";
            $req = self::$pdo->prepare($sql);
            // execution de la requete
            $req->execute($data);
            return $req->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la BDD keywords getIdWords");
        }
    }

        public static function insertSubtitleSerie($data){
        try{
            /*$v = "(";
            foreach ($data as $value) {
                $v .= $value.",";
            }
            $v = substr($v, 0, strlen($v)-1);
            $v = $v.",1)";
            
            $v = mb_convert_encoding($v, "UTF-8");
            //$v = substr($v, 0, strlen($v)-1);
            //print_r($v);
            $sql = "INSERT INTO serieskeywords (idSerie,idWord,nbOcc) VALUES $v ON DUPLICATE KEY UPDATE nbOcc=nbOcc+1;";*/
            $idSer = array_shift($data);
            $values = "";
                foreach ($data as $value) {
                    $values .= "(".$idSer.",".$value.",1),";
                }


            $values = rtrim($values, ', ');
            $sql = "INSERT INTO serieskeywords (idSerie,idWord,nbOcc) VALUES $values ON DUPLICATE KEY UPDATE nbOcc=nbOcc+1; ";
            $req = self::$pdo->prepare($sql);
            // execution de la requete
            $req->execute($data);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la BDD keywords insertSubtitleSerie");
        }
    }


    public static function insertFile($data){
        try{
            $table = static::$table;
            $primary = static::$primary_index;
            $values = "";
            $values = '("' . $data['name'] . '")';
            $sql = "INSERT INTO files (nameFile) VALUES $values";
            $req = self::$pdo->prepare($sql);
            // execution de la requete
            $req->execute($data);
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la BDD keywords insertfile");
        }
    }



}

?>