<?php

namespace touiteur\action;

use touiteur\Home\Home;

require_once 'vendor/autoload.php';

class ActionHome
{
    public function execute(): string
    {
        //si l'utilisateur est connecte on affiche les touites des personnes ou des tags qu'il suit sinon on affiche les touites de tous les utilisateurs
        return isset($_SESSION['user']) ? Home::afficherTouitesSuivie() : Home::afficherTouit();

    }

}