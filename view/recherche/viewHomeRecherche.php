<?php $nav_en_cours = 'recherchhe'; ?>
<?php  

function viewR($cs){
    foreach($cs as $r) {
        $occ = $r->occ;
        $titre = $r->titre;

        echo <<< EOT
        <li> 
            Trouvé $occ fois dans la série $titre.
        </li>
EOT;
    }
}      ?>
	<form id="searchForm" name="moteurSubmit" method="GET" action="."> <?php //controller/ControllerRecherche.php ?>
    <fieldset class="form-group">
        <div class="input-group">
        <?php echo "<label>Recherche de séries par mots-clés: </label>"; ?>    
        <input type="text" value="<?php if(isset($_GET['moteur'])) {echo htmlspecialchars($_GET['moteur']);} ?>" name="moteur" id="moteur" autofocus/>
        </div>
	        <input type="hidden" name="action" value="<?php echo($act) ?>" />
            <input type="hidden" name="controller" value="recherche" />   
	        
	        <input type="submit" value="Envoyer" />
        </fieldset>
	</form>

<?php


//DEBUGG********************************************
/*
if (isset($rchch)) {
    echo "rchch est à: "; print_r($rchch);
}else{echo "rchch n'est pas set";}
echo "<br/>";

if (isset($_GET['moteur'])) {
    echo "moteur est à: ".$_GET['moteur'];
}else{echo "moteur n'est pas set";}
echo "<br/>";

if (isset($_GET['action'])) {
 	echo "action est à :  ".$_GET['action'];}
echo "<br/>";

if (isset($act)) {
	echo "act est a : "; print_r ($act);
}else{echo "act non définie";}
echo "<br/>";

if (isset($pagetitle)) {
	echo "pagetitle est a : "; print_r ($pagetitle);
}else{echo "pagetitle non définie";}
*/
//END DEBUGG****************************************

// Placez de préférence cette partie au-dessus du DOCTYPE sous les inclusions et la connexion BDD
if(isset($_GET) && !empty($_GET['moteur'])) {
/*
// Appel de la class moteurRecherche (8 arguments --> 9 pour PHP 5.5)
0. VERSION PHP 5.5 : premier paramètre en plus pour récupérer la connexion courante ($link dans l'exemple commenté ci-dessous)
1. requête de recherche ($_GET['moteur'] avec stripslashes() par sécurité) -> OBLIGATOIRE
2. table de la base de données dans laquelle chercher -> OBLIGATOIRE
3. mode de recherche (like, regexp ou fulltext) -> REGEXP par défaut
4. tableau contenant des stop words ($stopwords ici)
5. nombre entier pour exclure les mots plus petits ou égaux que cette taille (si vide, aucune exclusion -> par défaut)
6. encodage souhaité (utf8, utf-8, iso-8859-1, latin1...) -> UTF-8 par défaut
7. booléen (true/false) pour choisir entre la recherche exacte (tous les mots) ou non (un mot juste ou plusieurs) -> TRUE par défaut
8. booléen (true/false) pour faire des recherches sans accent (si les contenus sont entrés sans accent dans la BDD) -> FALSE par défaut
*/
   //$moteur = new moteurRecherche(stripslashes($_GET['moteur']), 'TABLE_SQL', 'regexp', $stopwords);
   //PHP 5.5. :
   $moteur = new moteurRecherche($link, stripslashes($_GET['moteur']), 'keywords', 'regexp', $stopwords);
 
    // tableau des colonnes dans lesquelles effectuer une recherche
    $colonnesWhere = array('word');
 
    // Lancement de la class moteurRequetes() pour générer les requêtes de recherche
    $moteur->moteurRequetes($colonnesWhere);
}

//************************************************************************************
//AFFICHHAGE DES RESULTATS
//************************************************************************************

if(isset($moteur)) {
    // Affichage de la requête avec $moteur->requete
    echo '<h3>Resultats de la recherche : <em>'.$moteur->requete.'</em></h3>';
 
/*
Fonction "callback" pour l'affichage des résultats (3 arguments obligatoires)
1. Requête de recherche (variable au choix...)
2. Nombre total de résultats (variable au choix...)
3. Liste des mots et expressions de la requête (variable au choix...)
*/
    function affichage($requete, $nbResults, $mots) {
	if($nbResults == 0) { // Si aucun résultat n'est retourné
	    echo "<p>Aucun résultat, veuillez effectuer une autre recherche !</p>";	

	} else { // Sinon on affiche les résultats en boucle
 
        // Afficher le nombre de résultats
	    $affichageResultats = new affichageResultats();
	    echo $affichageResultats->nbResultats();
 
	    while($key = $requete->fetch_assoc()) {
                // On encode chaque clé/valeur de résultats en UTF-8
                foreach($key as $k => $v) {
                     $key[$k] = utf8_encode($v);
                }
 
                // Résultats de recherche à afficher (à personnaliser)
                //$texte  = "<br/>Mot clé: ".$key['word']."<br/>";

                $texte = "Le mot ";
                $texte .= $key['word'];
                $texte .= " a été trouvé ";
                $texte .= $key['nbOcc']." fois.<br/>";

                /*
                Objet pour surligner les mots recherchés si nécessaire
                => 3 arguments (les deux premiers sont obligatoires)
                1. variable contenant les mots ($mots ici)
                2. variable contenant le texte ($texte ici)
                3. "exact" (la chaîne précise mise en gras) ou "total" (la chaîne précise + environnante en gras) -> "exact" par défaut
                */
                $surlignage = new surlignageMot($mots, $texte);
                echo $surlignage->contenu; // Affichage du contenu après surlignage
                // N.B. : echo $texte; si vous ne voulez pas de surlignage...
	    } // Fin de la boucle while
	}
    }
 
// Nombre de résultats par "tranche d'affichage"
$limit = 10;
 
// Numéro de page récupéré dynamiquement
if(isset($_GET['p'])) {
	$page = htmlspecialchars($_GET['p']);
} else {
	$page = 0;
}
 
/*
Lancement de la class moteurAffichage
1. appel à la fonction callback d'affichage entre guillemets (obligatoire)
2. colonnes à sélectionner dans la base (toutes s'il est laissé "vide")
3. LIMIT en SQL -> tableau avec 4 valeurs : true/false, numDépart ($_GET['page'] ici pour la pagination dynamique), nbResultatsParPage (4 ici), true/false (true pour pagination classique, false pour autre) -> Par défaut array(false, 0, 10, false)
4. ORDER BY : tableau avec 3 valeurs : true/false, colonne d'ordre, ASC/DESC -> par défaut array(false, 'id', 'DESC')
5. ORDER BY avec algorithme de pertinence -> tableau avec 4 valeurs : true/false, colonne de classement (inédite !), ASC/DESC, colonne de l'ID -> Par défaut array(false,'algo','DESC','id')
N.B. : la fonction ajoute la colonne de classement si elle n'existe pas !
6. Fin de requête personnalisable (après le WHERE) : avec ORDER BY, LIMIT, AND
*/
$moteur->moteurAffichage('affichage', '', array(true, $page, $limit, true));
 
/*
Lancement de la méthode de pagination
1. OBLIGATOIRE : variable de récupération de la page ($page pour $_GET['p'] ici)
2. OBLIGATOIRE : nom du paramètre GET pour la page (situé dans l'input "hidden") -> 'page' ('p' dans l'exemple)
3. nombre de pages affichées autour de la page courante -> 2 par défaut
4. nombre de liens (premières et dernières pages) à afficher (0 pour annuler l'option) -> 0 par défaut
5. booléen (true/false) pour afficher ou non "page suivante" et "page précédente" -> true par défaut
6. booléen (true/false) pour afficher ou non "première page" et "dernière page" -> true par défaut
7. tableau qui contient les éléments de mise en forme (8 args)
=> textePrécédent, texteSuivant, textePremierePage, texteDernierePage, classPrecSuiv, classPage, classBloc, classInactif
-> défaut : array('&laquo; Précédent', 'Suivant &raquo;', 'Première page', 'Dernière page', 'precsuiv', 'current', 'pagination', 'inactif')
8. tableau qui contient les séparateur (5 args) 
=> pointSuspension, sepPremiereDernierePage, $sepNumPage, sepSuivPrec, sepDebutFin
-> Défaut : array('&hellip;', ' ', ' ', ' ', ' ')
*/
$moteur->moteurPagination($page, 'p');
}
    if (($moteurR == "") && $action != "initial") {
        echo "Le champ de recherche n'a pas été rempli.";
    }else{
        if (isset($tab_rchch)&&!empty($tab_rchch)) {
            echo "<div>";
                //var_dump($tab_rchch);
                foreach ($tab_rchch as $motRecherche => $tabUneDimension) {
                    echo "_________________________________________________<br/><br/>";
                    echo "<ol>";
                    if (count($tabUneDimension)!=0) {
                        echo "<b>".$motRecherche."</b> a été trouvé dans ".count($tabUneDimension)." séries : <br/>";
                        //var_dump($tabUneDimension);
                        //Le tableau est constitué d'objets de type stdclass                
                        foreach ($tabUneDimension as $valeur) {
                            echo "<ul><li>";
                                echo $valeur->occ;
                                echo " fois dans ";
                                echo $valeur->titre;
                                echo "<br/>";
                            echo "</li></ul>";
                        }
                    }else{
                        echo "<em><b>Erreur</b> : le mot <b>".$motRecherche."</b> n'a été trouvé dans aucune série.</em>";
                    }
                    echo "</ol>";
                }
                echo "_________________________________________________";
            echo "</div>";
        }else{
            //echo "<br/><em>Erreur :</em> Aucune série correspondante.";
        }
}
?>