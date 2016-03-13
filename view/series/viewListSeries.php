<?php
function view1($ts){
	foreach($ts as $s) {
		$idS = $s->idSerie;
		$t = $s->title;
		
		echo <<< EOT
		<li> 
			La série identifié par $idS porte le titre : $t
		</li>
EOT;
	}
}	       
?>
        <!-- Une variable $tab_util est donnée -->    
        <div>
            <h1>Liste des séries:</h1>
            <ol>
            <?php view1($tab_series); ?>
            </ol>
        </div>