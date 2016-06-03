<?php

class Conf {

    private static $database = array(
        'hostname' => 'localhost',  // infolimon (ou localhost)
        'database' => 'nextwatch', // votre login dans notre cas
        'login' => 'root',
        'password' => ''
    );
    
    private static $debug = true;
    
    private static $seed = 'une_chaine_aléatoire_fixe';
    
    static public function getSeed(){
        return self::$seed;
    }

    static public function getLogin() {
        return self::$database['login'];
    }

    static public function getHostname() {
        return self::$database['hostname'];
    }

    static public function getDatabase() {
        return self::$database['database'];
    }

    static public function getPassword() {
        return self::$database['password'];
    }
    
    static public function getDebug() {
        return self::$debug;
    }

}

?>
