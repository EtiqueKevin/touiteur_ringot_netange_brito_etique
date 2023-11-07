<?php


namespace touiteur\action;

use touiteur\action\Action;
use touiteur\auth\Auth;
use touiteur\auth\AuthException;

class ActionProfile extends Action{

    public function execute(): string{
        $html = '<h1>Page utilisateur</h1>';
        return $html;
    }



}