<?php

namespace touiteur\action;

class ActionGate extends Action
{

    public function execute(): string
    {
        $html = <<<HTML
        <div id="gate">
            <p>Bienvenue sur Touiteur, le réseau social de l'avenir !</p>
            <p>Vous pouvez vous inscrire ou vous connecter en cliquant sur les liens ci-dessous.</p>
            <a href="?action=inscription"><button class="button">Inscription</button></a>
            <a href="?action=connexion"><button class="button">Connexion</button></a>
            <p>Vous pouvez également consulter les derniers Touits sans être inscrit.</p>
            <p><a href="?action=afficherTouits&page=1"><button class="button">Rejoindre en tant qu'Invité</button></a></p>
        </div>
HTML;
        return $html;
    }

}