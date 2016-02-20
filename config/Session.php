<?php

class Session{
    public static function is_user($mail){
        return(!empty($_SESSION['mail']) && ($_SESSION['mail'] == $mail));
    }
    
    public static function is_admin() {
        return(!empty($_SESSION['admin']) && $_SESSION['admin']);
    }
}

?>