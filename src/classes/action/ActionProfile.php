<?php


namespace touiteur\action;

use touiteur\action\Action;
use touiteur\auth\Auth;
use touiteur\auth\AuthException;
use touiteur\renderer\UtilisateurRenderer;

class ActionProfile extends Action{

    public function execute(): string{

        $html = (new UtilisateurRenderer(unserialize($_SESSION['user'])))->render(1);
        return $html;
    }



}