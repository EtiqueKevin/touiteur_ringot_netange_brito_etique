<?php

namespace touiteur\dispatch;

use touiteur\action\ActionConnexion;
use touiteur\action\ActionDeconnexion;
use touiteur\action\ActionGate;
use touiteur\action\ActionInscription;

require_once 'vendor/autoload.php';
require_once 'src/classes/action/lib_touiteur.php';

class Dispatcher{
    public function run(): void{

        $action = $_GET['action'] ?? 'gate';


        switch ($action){
            case 'inscription':
                $ai= new ActionInscription();
                $html = $ai->execute();
            break;
            case 'connexion':
                $ac = new ActionConnexion();
                $html = $ac->execute();
            break;
            case 'gate':
                $ag = new ActionGate();
                $html = $ag->execute();
            break;
            case 'page-utilisateur':
                $html = '<h1>Page utilisateur</h1>';
            break;
            case 'deconnexion':
               $ad = new ActionDeconnexion();
                $html = $ad->execute();
            break;
            default:
                $html = '<h1>Par default</h1>';
            break;
        }

        $d = new Dispatcher();
        $d->renderPage($html);
    }

    public function renderPage(string $h): void
    {

        if (isset($_SESSION['user'])) {
        $k=<<<HTML
            <a href="?action=page-utilisateur"><button class='profil'>Profil</button></a>
            <a href="?action=deconnexion"><button class='deconnexion'>Déconnexion</button></a>
HTML;
        }else {
            $k=<<<HTML
                <a href="?action=inscription"><button class='inscription' >Inscription</button></a>
                <a href="?action=connexion"><button class='connexion'>Connexion</button></a>
HTML;
             }

        echo <<<HTML
<!DOCTYPE html>
<html lang='fr' >
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='styles/index.css'>
    <link rel='stylesheet' href='styles/gate.css'>
    <link rel='stylesheet' href='styles/auth.css'>
<title>Touiteur</title>
</head>

    <body>
    <nav class='navbar'>
        <div id='logo' >
            <a href="?action=default"><img src='ressources/logo_blanc.png' alt='logo' > </a>
        </div>
        <div id='profil'>
HTML.$k.<<<HTML
        </div>
    </nav>
HTML.$h.<<<HTML
    </body>
</html>"
HTML;
    }

}