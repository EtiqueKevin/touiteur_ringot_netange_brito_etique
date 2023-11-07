<?php

use touiteur\action\ActionConnexion;
use touiteur\action\ActionInscription;

require_once 'vendor/autoload.php';
require_once 'src/classes/action/lib_touiteur.php';

if (isset($_GET['action'])){
    $action = $_GET['action'];
}
else{
    $action = 'default';
}

switch ($_GET['action']){
    case 'inscription':
        $ai= new ActionInscription();
        $html = $ai->execute();
    break;
    case 'connexion':
        $ac = new ActionConnexion();
        $html = $ac->execute();
    break;
    default:
        $html = '<h1>Page d\'accueil</h1>';
    break;
}

echo <<<HTML
<!DOCTYPE html>
<html lang='fr' >
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='styles/index.css'>
<title>Touiteur</title>
</head>

    <body>
    <nav class='navbar'>
        <div id='logo' >
            <a href="?action=default"><img src='ressources/logo_blanc.png' alt='logo' > </a>
        </div>
        <div id='profil'>
                <a href="?action=inscription"><button class='inscription' >Inscription</button></a>
                <a href="?action=connexion"><button class='connexion'>Connexion</button></a>
        </div>
    </nav>
HTML.$html.<<<HTML
    </body>
</html>"
HTML;
