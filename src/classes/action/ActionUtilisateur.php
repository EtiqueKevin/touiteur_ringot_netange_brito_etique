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
        $pdp = $result['pdp'] === null ? "ressources/Z.png" : $result['photo'];
        $bio = $result['bio'] === null ? "Exprimez-vous" : $result['bio'];
        $user = new Utilisateur($result['pseudo'], $result['email'], $result['mdp'], $result['role'], $pdp, $bio);
        return isset($_SESSION['user']) ? (new UtilisateurRenderer($user))->render(2) : (new UtilisateurRenderer($user))->render(1);
    }
}