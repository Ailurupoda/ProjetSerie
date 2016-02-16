<?php
require "header.php";
require VIEW_PATH . $controller . DS . 'view' . ucfirst($view) . ucfirst($controller) . '.php';
require "footer.php";
?>