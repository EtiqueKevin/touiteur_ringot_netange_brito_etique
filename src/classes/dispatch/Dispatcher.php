<?php

namespace touiteur\dispatch;

use touiteur\action\ActionConnexion;
use touiteur\action\ActionCreerTouite;
use touiteur\action\ActionDeconnexion;
use touiteur\action\ActionDiscover;
use touiteur\action\ActionDisplayTouite;
use touiteur\action\ActionFollow;
use touiteur\action\ActionFollowTag;
use touiteur\action\ActionGate;
use touiteur\action\ActionHome;
use touiteur\action\ActionInscription;
use touiteur\action\ActionLike;
use touiteur\action\ActionModifBio;
use touiteur\action\ActionModifPP;
use touiteur\action\ActionNarcisse;
use touiteur\action\ActionProfile;
use touiteur\action\ActionSuppTouite;
use touiteur\action\ActionTag;
use touiteur\action\ActionUtilisateur;


require_once 'vendor/autoload.php';

class Dispatcher{
    public function run(): void{

        $action = $_GET['action'] ?? 'gate';

        //l'ensemble des actions possibles

        switch ($action) {
            case 'inscription':
                $ai = new ActionInscription();
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

                //Session position permet de savoir sur quelle page on est quand on like
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

                //Session position permet de savoir sur quelle page on est quand on like
                $_SESSION['position'] = 'home';
                break;
            case 'discover':
                $d = new ActionDiscover();
                $html = $d->execute();

                //Session position permet de savoir sur quelle page on est quand on like
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
            case 'ActionUtilisateur':
                $f = new ActionUtilisateur();
                $html = $f->execute();
                break;
            case 'display-touite':
                $d = new ActionDisplayTouite();
                $html = $d->execute();
                break;
            case 'tag-list-touite':
                $d = new ActionTag();
                $html = $d->execute();
                break;
            case 'followTag':
                $f = new ActionFollowTag();
                $html = $f->execute();
                break;
            case 'edit-bio':
                $f = new ActionModifBio();
                $html = $f->execute();
                break;
            case 'edit-pdp':
                $f = new ActionModifPP();
                $html = $f->execute();
                break;
            case 'narcisse':
                $f = new ActionNarcisse();
                $html = $f->execute();
                break;
            case 'delete':
                $f = new ActionSuppTouite();
                $html = $f->execute();
                break;
            default:
                $html = '<h1>Par default</h1>';
                break;
        }

        $d = new Dispatcher();
        $d->renderPage($html);
    }

    public function renderPage(string $h): void{

        //Si l'utilisateur est connecté on affiche les boutons de navigation
        if (isset($_SESSION['user'])) {
            $k = <<<HTML
            <a href="?action=discover&page=1"><button class="button">Discover</button></a>
            <a href="?action=publier-touite"><button class="button"><strong>+</strong></button></a>
            <a href="?action=page-utilisateur&page=1"><button class='button'>Profil</button></a>
            <a href="?action=deconnexion"><button class='button'>Déconnexion</button></a>

HTML;
        } else {
            $k = <<<HTML
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
            <a href="?action=home-page&page=1"><img src='ressources/logo_blanc.png' alt='logo' > </a>
        </div>
        <div id='profil'>
HTML. $k . <<<HTML
        </div>
    </nav>
HTML . $h . <<<HTML
<script src="script/scroll.js"></script>
    </body>
</html>
HTML;
    }

}