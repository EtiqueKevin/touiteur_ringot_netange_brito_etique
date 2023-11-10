<?php

namespace touiteur\action;

class ActionDeconnexion extends Action
{


    public function execute(): string
    {
        unset($_SESSION['user']); //destruction de la session de l'utilisateur
        $html = '<h1>Vous êtes déconnecté</h1>';
        header('location: ?action=gate&page=1');  //redirection vers la page d'accueil
        return $html;
    }
}