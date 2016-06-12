<?php
// Gestion de la connexion SQL (avec ma méthode personnalisée)
$base    = "nextwatch";
$serveur = "localhost";
$login   = "root";
$passe   = "pandas";

// Connexion
$link = new mysqli($serveur, $login, $passe, $base);

// En cas d'erreur
if (mysqli_connect_error()) {
	die('Connexion impossible à Mysql ('.mysqli_connect_errno().') : '.mysqli_connect_error());
}
?>