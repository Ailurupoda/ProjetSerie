<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/navstyle.css">
        <title><?php echo $pagetitle; ?></title>
    </head>
    <body>
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
