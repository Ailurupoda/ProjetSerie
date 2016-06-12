<?php $nav_en_cours = 'like'; ?>
<?php
function view1($lkd,$nb,$p){
	echo '<div class="page">';
    for($i=1; $i<=$nb; $i++){
        if($i == $p){
            echo "<a class='elementRight inscription butt' href = '?action=readPage&controller=liked&page=$i'> $i </a>";
            } else {
            echo "<a class='elementRight connection butt' href = '?action=readPage&controller=liked&page=$i'> $i </a>";
            }
    }
    echo 'Tout ce que vous aimez!</div>';
	foreach($lkd as $l) {
		$idS = $l->idSerie;
		$title = $l->title;
		
		echo <<< EOT
		<li class="cellule"> 
			<div class="title">-Vous aimez $title</div>
			
		
EOT;
		if (!empty($_SESSION['mail'])){
			echo "<div class='blike'><a href ='?action=unLike&controller=liked&idSerie=$idS&page=1&nbPage=$nb'>UNLIKE</a></div>";
		}
		echo "</li>";
	}
}      
?>
        <!-- Une variable $tab_util est donnée -->    
        <div>
            <ol>
            <?php view1($tab_lik,$nbPages,$page); ?>
            </ol>
        </div>