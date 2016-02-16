<?php

function view1($tu) {
	foreach ($tu as $u) {
		$id = $u->idUser;
		$n = $u->nickname;
		$e = $u->mail;


	echo <<< EOT 
	<li> Sous l'id $id se trouve $n avec son email : $e.
	<a href='?action=read$controller=users&idUser=$id'>Détail</a>
	</li>
EOT;
	}
	echo <<<EOT
	<li>
		<a href='?action=create&controller=users'>Créer un nouvel utilisateur</a>
	<li>
EOT;
}
?>
	<div>
		<h1>Liste des utilisateurs:</h1>
		<ol>
			<?php view1($tab_util); ?>
		</ol>
	<div>