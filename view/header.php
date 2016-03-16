<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/nw.css">
        <title><?php echo $pagetitle; ?></title>
    </head>
    <body>


        <div class="container">
            <div class="box">
                <a href="?action=home&controller=users"><img src="css/LogoNextWatch.png" alt="Accueil"/>
            </div>  

            <div class="boxAuto">
                 <a href="?action=recommand&controller=users"><img src="css/recommandation.png" alt="Recommandations"/>

                 <?php  if (!empty($_SESSION['mail'])) {
                        echo "<a href='?action=readAll&controller=liked'><img src=\"css/Like.png\" alt=\"Like\"/></a>";
                    }
                    ?>
                    
                 

                 <a href="?action=readAll&controller=series"><img src="css/Listing.png" alt="Listing"/>
                 <a href="?action=initial&controller=recherche"><img src="css/Recherche.png" alt="Recherche"/> 

                 <?php ;if (!empty($_SESSION['mail']) ) {
                        echo "<a href='?action=profil&controller=users'><img src=\"css/Profil.png\" alt=\"Profil\"/></a>";
                    }
                    ?> 
                <?php if (!empty($_SESSION['mail'])  && ($_SESSION['admin'] == 1)) {
                        echo "<a href='?action=create&controller=series'>Ajouter une série</a>";
                    }
                    ?>
                    <?php if (!empty($_SESSION['mail'])  && ($_SESSION['admin'] == 1)) {
                    echo<<<AjouterSubtitle
               
                    <a href="?action=insert&controller=series">Ajouter des Sous-titres</a>               
AjouterSubtitle;
                }
                ?>

            </div>  

            <div class="box">
                <?php if (empty($_SESSION['mail'])) {
                            echo<<<connecter
                    <div class="elementRight">       
                    <div class="elementRight button"><a href="?action=create&controller=users">S'inscrire </a></div>        
                    <div class="elementRight button"><a href="?action=connect&controller=users">Se connecter </a></div>    
                    </div>                
connecter;
                }
                ?>
                    
                    <?php if (!empty($_SESSION['mail'])) {
                        $logtemp = $_SESSION['mail'];
                        echo<<<deconnecter
                    <div class="elementRight">    
                    <div><a href ='?action=read&controller=users&mail=$logtemp'> $logtemp </a></div>
                    <div class="button"><a href ='?action=deconnect&controller=users'> Se déconnecter </a></div>
                    </div>
deconnecter;
                    }
                    ?>


            </div>  




        </div>  