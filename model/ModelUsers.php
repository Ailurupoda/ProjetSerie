<?php

require_once 'Model.php';

class ModelUsers extends Model {
    protected static $table = "users";
    protected static $primary_index = "idUser";
}

?>