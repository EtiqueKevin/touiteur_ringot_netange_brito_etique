<?php

namespace touiteur\action;

class ActionDeconnexion extends Action{


    public function execute(): string{
        unset($_SESSION['user']);
        $html = '<h1>Vous êtes déconnecté</h1>';
        header('location: index.php/?action=gate');
        return $html;
    }
}