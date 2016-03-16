<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
<<<<<<< HEAD
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
                    
                 <?php if (!empty($_SESSION['mail'])  && ($_SESSION['admin'] == 1)) {
                        echo "<a href='?action=create&controller=series'>Ajouter une série</a>";
=======
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="css/navstyle.css">
        <title><?php echo $pagetitle; ?></title>
    </head>
    <body>
        <div>
                <div>  
                <?php if (empty($_SESSION['mail'])) {
                        echo<<<connecter
                <a href="?action=connect&controller=users">Se connecter </a>
                <a href="?action=create&controller=users">S'inscrire </a>
connecter;
            }
            ?>    
                <?php if (!empty($_SESSION['mail'])) {
                    $logtemp = $_SESSION['mail'];
                    echo<<<deconnecter
                <a href ='?action=read&controller=users&mail=$logtemp'>$logtemp</a>
                <a href ='?action=deconnect&controller=users'>Se déconnecter</a>
deconnecter;
                }
                ?>
                </div>
                </div>              
        <div>
        <nav>
            <ul>
                <li>
                    <a href="?action=home&controller=users">Accueil</a>
                </li>
                <li>
                    <a href="?action=recommand&controller=users">Recommandations</a>
                </li>
                
                    <?php  if (!empty($_SESSION['mail'])) {
                    echo "<li>
                    <a href='?action=readAll&controller=liked'>Like</a>
                        </li>";
                    }
                    ?>

                    </li>
                
                <li>
                    <a href="?action=readAll&controller=series">Listing</a>
                </li>


                <?php ;if (!empty($_SESSION['mail']) ) {
                    echo "<li>
                    <a href='?action=profil&controller=users'>Profil</a>
                        </li>";
>>>>>>> modCc
                    }
                    ?>

                 <a href="?action=readAll&controller=series"><img src="css/Listing.png" alt="Listing"/>
                 <a href="?controller=users"><img src="css/Recherche.png" alt="Recherche"/> 

                 <?php ;if (!empty($_SESSION['mail']) ) {
                        echo "<a href='?action=profil&controller=users'><img src=\"css/Profil.png\" alt=\"Profil\"/></a>";
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
                    
<<<<<<< HEAD
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
=======
                     
         
                <li>
                    <a href="?action=initial&controller=recherche">Recherche</a>
                </li>
    
                <?php if (!empty($_SESSION['mail'])  && ($_SESSION['admin'] == 1)) {
                    echo<<<AjouterSeries
                <li>
                    <a href="?action=create&controller=series">Ajouter des Séries</a>
                </li>
AjouterSeries;
                }
                ?>
                                <?php if (!empty($_SESSION['mail'])  && ($_SESSION['admin'] == 1)) {
                    echo<<<AjouterSubtitle
                <li>
                    <a href="?action=insert&controller=series">Ajouter des Sous-titres</a>
                </li>
AjouterSubtitle;
                }
                ?>

            </ul>
        </nav>
>>>>>>> modCc
