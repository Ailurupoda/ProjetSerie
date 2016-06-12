<?php
function view1($ts,$nb,$p){
	echo '<div class="page">';
    for($i=1; $i<=$nb; $i++){
        if($i == $p){
            echo "<a class='elementRight inscription butt' href = '?action=readPage&controller=series&page=$i'> $i </a>";
            } else {
            echo "<a class='elementRight connection butt' href = '?action=readPage&controller=series&page=$i'> $i </a>";
            }
    }
    echo 'Nos Séries!</div>';
    $cpt=0;
    foreach($ts as $s) {
		$idS = $s->idSerie;
		$t = $s->title;
        $cpt++;
		echo <<< EOT
		<li class="cellule"> 
        <div class="id">$idS</div>
			<div class="title">- $t</div>
		
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
            echo "<div class='blike'>";
			if($exists > 0){
				echo "<a href ='?action=unLike&controller=liked&idSerie=$idS&page=1&nbPage=$nb'>UNLIKE</a>";
				
			}
			else {
				echo "<a href ='?action=like&controller=liked&idSerie=$idS&page=1&nbPage=$nb'>LIKE</a>";
			}
			echo "</div>";
		}
		echo "</li>";
	}
}



?> <?php $nav_en_cours = 'liste'; ?>
        <!-- Une variable $tab_series est donnée -->    
        <div class="pagination">
        <ol >
            <div class="back">
            <?php view1($tab_series,$nbPages,$page);?>
            </div>
        </ol>        


        </div>