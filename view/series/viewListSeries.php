<?php
function view1($ts){
	foreach($ts as $s) {
		$idS = $s->idSerie;
		$t = $s->title;
		
		echo <<< EOT
		<li> 
			La série identifié par $idS porte le titre : $t
		
EOT;
		if (!empty($_SESSION['mail'])){

			require_once MODEL_PATH . 'ModelUsers.php';
			require_once MODEL_PATH . 'ModelLiked.php';
    		$data = array("mail" => $_SESSION['mail']);
    		$i = ModelUsers::getId($data);
    		$data = array(
    		"idUser" => $i["idUser"],
    		"idSerie" => $idS
    		);
    		$exists = ModelLiked::existId($data);
			if($exists > 0){
				echo "<a href ='?action=unLike&controller=liked&idSerie=$idS'>UNLIKE</a>";
				
			}
			else {
				echo "<a href ='?action=like&controller=liked&idSerie=$idS'>LIKE</a>";
			}
			
		}
		echo "</li>";
	}
}      
?>
        <!-- Une variable $tab_util est donnée -->    
        <div>
            <h1>Liste des séries:</h1>
<<<<<<< HEAD
            <ol>

            <?php view1($tab_series); ?>

            </ol>
=======
            <ul>
            <?php view1($tab_util); ?>
            </ul>
>>>>>>> ff41018afc5b34717569643db203197700348468
        </div>