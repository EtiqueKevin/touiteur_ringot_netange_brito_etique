<?php

namespace touiteur\dispatch;

use touiteur\action\ActionConnexion;
use touiteur\action\ActionCreerTouite;
use touiteur\action\ActionDeconnexion;
use touiteur\action\ActionDiscover;
use touiteur\action\ActionGate;
use touiteur\action\ActionHome;
use touiteur\action\ActionInscription;
use touiteur\action\ActionLike;
use touiteur\action\ActionProfile;
use touiteur\action\ActionFollow;


require_once 'vendor/autoload.php';

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
                $ap = new ActionProfile();
                $html = $ap->execute();
                $_SESSION['position'] = 'profile';
            break;
            case 'publier-touite':
                $ap = new ActionCreerTouite();
                $html = $ap->execute();
            break;
            case 'deconnexion':
               $ad = new ActionDeconnexion();
               $html = $ad->execute();
            break;
            case 'home-page':
                $ah = new ActionHome();
                $html = $ah->execute();
                $_SESSION['position'] = 'home';
                break;
            case 'discover':
                $d = new ActionDiscover();
                $html = $d->execute();
                $_SESSION['position'] = 'discover';
                break;
            case 'like':
                $l = new ActionLike();
                $html = $l->execute();
                break;
            case 'follow':
                $f = new ActionFollow();
                $html = $f->execute();
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
            <a href="?action=discover"><button class="button">Discover</button></a>
            <a href="?action=publier-touite"><button class="button"><strong>+</strong></button></a>
            <a href="?action=page-utilisateur"><button class='button'>Profil</button></a>
            <a href="?action=deconnexion"><button class='button'>Déconnexion</button></a>

HTML;
        }else {
            $k=<<<HTML
                <a href="?action=inscription"><button class='button' >Inscription</button></a>
                <a href="?action=connexion"><button class='button'>Connexion</button></a>
HTML;
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
            <a href="?action=home-page"><img src='ressources/logo_blanc.png' alt='logo' > </a>
        </div>
        <div id='profil'>
HTML.$k.<<<HTML
        </div>
    </nav>
HTML.$h.<<<HTML
    </body>
</html>
HTML;
    }

}