<?php

class Session{
    public static function is_user($m){
        return(!empty($_SESSION['mail']) && ($_SESSION['mail'] == $m));
    }
    
    public static function is_admin() {
        return(!empty($_SESSION['admin']) && $_SESSION['admin']);
    }
}

?>