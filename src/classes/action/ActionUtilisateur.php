<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;
use touiteur\renderer\UtilisateurRenderer;
use touiteur\utilisateur\Utilisateur;

class ActionUtilisateur extends Action
{

    public function execute(): string
    {

        $pseudo = $_GET['pseudo'];
        $db = ConnectionFactory::makeConnection();
        $query = 'SELECT * FROM Utilisateur WHERE pseudo = ?';
        $st = $db->prepare($query);
        $st->bindParam(1, $pseudo);
        $st->execute();
        $result = $st->fetch();
        $user = new Utilisateur($result['pseudo'], $result['email'], $result['mdp'], $result['role'], $result['pdp'], $result['bio']);
        return (new UtilisateurRenderer($user))->render(3);
    }
}