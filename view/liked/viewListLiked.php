<?php
function view1($lkd){
	foreach($lkd as $l) {
		$idS = $l->idSerie;
		
		echo <<< EOT
		<li> 
			Vous aimez la série d'id : $idS
		
EOT;
		if (!empty($_SESSION['mail'])){
			echo "<a href ='?action=unLike&controller=liked&idSerie=$idS'>UNLIKE</a>";
		}
		echo "</li>";
	}
}      
?>
        <!-- Une variable $tab_util est donnée -->    
        <div>
            <h1>Liste des séries que vous aimez:</h1>
            <ol>
            <?php view1($tab_lik); ?>
            </ol>
        </div>