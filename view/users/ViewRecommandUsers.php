<?php
function view1($recom){
	foreach($recom as $r) {
		if(empty($_SESSION['mail'])){
			$titleR = $r['title'];
		}
		else{
			$titleR = $r;
		}
		echo <<< EOT
		<li> 
			Nous vous recommandons : $titleR
		
EOT;

		echo "</li>";
	}
}      
?>
        <!-- Une variable $tab_recom est donnée -->    
        <div>
            <h1>Liste des séries recommandées:</h1>
            <ol>
            <?php view1($tab_recom); ?>
            </ol>
        </div>