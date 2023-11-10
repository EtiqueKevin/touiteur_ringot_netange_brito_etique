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
        //recuperation des informations de l'utilisateur
        $query = 'SELECT * FROM Utilisateur WHERE pseudo = ?';
        $st = $db->prepare($query);
        $st->bindParam(1, $pseudo);
        $st->execute();
        $result = $st->fetch();
        //on regarde si il y a une pdp, si non on met une pdp par defaut et si oui on met la pdp
        $pdp = $result['pdp'] === null ? "ressources/Z.png" : $result['img'];
        //on regarde si il y a une bio, si non on met une bio par defaut et si oui on met la bio
        $bio = $result['bio'] === null ? "Exprimez-vous" : $result['bio'];
        //on cree l'utilisateur
        $user = new Utilisateur($result['pseudo'], $result['email'], $result['mdp'], $result['role'], $pdp, $bio);
        //on regarde si l'utilisateur est connecte, si oui on affiche le profil de l'utilisateur avec le bouton de modification de la pdp
        return isset($_SESSION['user']) ? (new UtilisateurRenderer($user))->render(2) : (new UtilisateurRenderer($user))->render(1);
    }
}