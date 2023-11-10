<?php

namespace touiteur\action;

use touiteur\renderer\UtilisateurRenderer;

class ActionProfile extends Action
{
    public function execute(): string
    {
        //affichage du profil de l'utilisateur par un renderer en mettant en parametre l'utilisateur connecte
        return (new UtilisateurRenderer(unserialize($_SESSION['user'])))->render(1);
    }
}