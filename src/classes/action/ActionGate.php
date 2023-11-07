<?php

namespace touiteur\action;

class ActionGate extends Action{

    public function execute(): string{
        $html = <<<HTML
            <p>Bienvenue sur Touiteur, le réseau social de l'avenir !</p>
            <p>Vous pouvez vous inscrire ou vous connecter en cliquant sur les liens ci-dessous.</p>
            <p><a href="?action=inscription">Inscription</a></p>
            <p><a href="?action=connexion">Connexion</a></p>
            <p>Vous pouvez également consulter les derniers Touits sans être inscrit.</p>
            <p><a href="?action=afficherTouits">Rejoindre en tant qu'Invité</a></p>
HTML;
        return $html;
    }

}