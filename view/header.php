<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="css/nw.css">
        <title><?php echo $pagetitle; ?></title>
    </head>
    <body class="body">

        <div class="container">
            <header id="header" role="banner" class="main-header">
            <div class="header-inner">
            <div class="header-logo tooltip">
                <a href="?action=home&controller=users&nav_en_cours=home" class="logo logo-tourne">logo</a><span class="tooltiptext">Retour à l'accueil.</span>
            </div>  

            <nav class="header-nav">
                <ul>
                    <li class="tooltip"><a href="?action=recommand&controller=users&nav_en_cours=recommandations" class="icon icon-slide<?php if ($nav_en_cours == 'recommandations') {echo '-en-cours';} ?>  recommandations">recommandations</a><span class="tooltiptext">Panne d'inspiration?</span></li>

                 <?php  if (!empty($_SESSION['mail'])) {
                        echo "<li class='tooltip'><a href='?action=readAll&controller=liked&nav_en_cours=like&page=1' class=\"icon icon-slide"; if ($nav_en_cours == 'like') {echo '-en-cours';} echo " like\">like</a><span class='tooltiptext'>Les séries que vous aimez!</span></li>";
                    }
                    ?>
                    
                 

                 <li class='tooltip'><a href="?action=readAll&controller=series&nav_en_cours=liste&page=1" class="icon icon-slide<?php if ($nav_en_cours == 'liste') {echo '-en-cours';} ?> liste">liste</a><span class="tooltiptext">Retrouvez toutes nos séries!</span></li>
                 <li class='tooltip'><a href="?action=initial&controller=recherche&nav_en_cours=recherche" class="icon icon-slide<?php if ($nav_en_cours == 'recherche') {echo '-en-cours';} ?> loupe">loupe</a><span class="tooltiptext">Recherchez une série par mots-clés.</span></li>

                 <?php ;if (!empty($_SESSION['mail']) ) {
                        echo "<li class='tooltip'><a href='?action=profil&controller=users&nav_en_cours=profil' class=\"icon icon-slide"; if ($nav_en_cours == 'profil') {echo '-en-cours';} echo " profil\">profil</a><span class='tooltiptext'>Editez votre profil!</span></li>";
                    }
                    ?> 
                <?php if (!empty($_SESSION['mail'])  && ($_SESSION['admin'] == 1)) {
                        echo "<li class='tooltip'><a href='?action=create&controller=series&nav_en_cours=create' class=\"icon icon-slide"; if ($nav_en_cours == 'create') {echo '-en-cours';} echo " administration\">Ajouter série</a><span class='tooltiptext'>Vous voulez ajouter une série?</span></li>";
                    }
                    ?>
                    <?php if (!empty($_SESSION['mail'])  && ($_SESSION['admin'] == 1)) {
                           
                    echo "<li class='tooltip'><a href='?action=insert&controller=series&nav_en_cours=insert' class=\"icon icon-slide"; if ($nav_en_cours == 'insert') {echo '-en-cours';} echo " ajout\">ajout</a><span class='tooltiptext'>Vous avez de nouveaux sous-titres?</span></li>";
                }
                ?>
                </ul>
            </nav>  

            <div class="header-box">
                <?php if (empty($_SESSION['mail'])) {
                            echo<<<connecter
                    <div class="elementRight">        
                    <div class="elementRight"><a class="elementRight inscription" href="?action=create&controller=users&nav_en_cours=home">S'inscrire </a></div>
                    <div class="elementRight"><a class="elementRight connection" href="?action=connect&controller=users&nav_en_cours=home">Se connecter</a></div>           
                    </div>                                         
connecter;
                }
                ?>
                    
                    <?php if (!empty($_SESSION['mail'])) {
                        $logtemp = $_SESSION['mail'];
                        echo<<<deconnecter
                    <div class="elementRight"> 
                    <div class="elementRight"><a class="elementRight inscription" href ='?action=profil&controller=users&nav_en_cours=profil'> $logtemp </a></div>   
                    <div class="elementRight"><a class="elementRight connection" href ='?action=deconnect&controller=users&nav_en_cours=home'> Se déconnecter </a></div>
                    </div>
deconnecter;
                    }
                    ?>


            </div>  




        </div>  
        </header>
        <div class="global">
