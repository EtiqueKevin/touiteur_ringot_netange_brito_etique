<?php

namespace touiteur\action;

use touiteur\renderer\UtilisateurRenderer;

class ActionProfile extends Action
{
    public function execute(): string
    {
        return (new UtilisateurRenderer(unserialize($_SESSION['user'])))->render(1);
    }
}