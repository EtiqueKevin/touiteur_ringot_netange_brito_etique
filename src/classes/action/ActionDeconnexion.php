<?php

namespace touiteur\action;

class ActionDeconnexion extends Action{


    public function execute(): string{
        unset($_SESSION['user']);
        $html = '<h1>Vous êtes déconnecté</h1>';
        $html .= '<p><a href="./index.php?action=gate">Menu</a></p>';
        return $html;
    }
}