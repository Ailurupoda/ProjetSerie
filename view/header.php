<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
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
                    <a href="?controller=users">Recommandations</a>
                </li>
                <li>
                    <a href="?action=readAllLiked&controller=users">Like</a>
                </li>
                <li>
                    <a href="?controller=series">Listing</a>
                </li>
                <li>
                    <a href="?controller=users">Recherche</a>
                </li>
                <li>
                    <a href="?action=update&controller=users">Profil</a>
                </li>
            </ul>
        </nav>
