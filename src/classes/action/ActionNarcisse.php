<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;
use touiteur\renderer\UtilisateurRenderer;
use touiteur\utilisateur\Utilisateur;

class ActionNarcisse
{

    public function execute()
    {
        $html = "";
        $user = unserialize($_SESSION['user']);
        $email = $user->email;
        $bd = ConnectionFactory::makeConnection();
        $query = "SELECT emailFollower FROM FollowUser WHERE emailFollowed = ?";
        $st = $bd->prepare($query);
        $st->bindParam(1, $email);
        $st->execute();
        $result = $st->fetchAll();
        $tab = [];
        foreach ($result as $row) {
            $query = 'SELECT * FROM Utilisateur WHERE email = ?';
            $st = $bd->prepare($query);
            $st->bindParam(1, $row['emailFollower']);
            $st->execute();
            $res = $st->fetch();
            $pdp = $res['pdp'] === null ? "ressources/Z.png" : $res['pdp'];
            $follower = new Utilisateur($res['pseudo'], $res['email'], $res['mdp'], $res['role'], $pdp);
            $html.= (new UtilisateurRenderer($follower))->render(4);
        }

        return $html;
    }
}