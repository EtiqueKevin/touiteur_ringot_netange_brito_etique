<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;

class ActionFollow extends Action
{

    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_SESSION['user'])) { //on verifie que l'utilisateur est connecté
                $email = $_GET['email']; //on recupere l'email de l'utilisateur à suivre
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                $user = unserialize($_SESSION['user'])->email; //on recupere l'email de l'utilisateur connecté
                $bd = ConnectionFactory::makeConnection();
                //on verifie si l'utilisateur connecté suit deja l'utilisateur à suivre
                $sql = "SELECT * FROM FollowUser where emailFollower = ? and emailFollowed = ?";
                $st = $bd->prepare($sql);
                $st->bindParam(1, $user);
                $st->bindParam(2, $email);
                $st->execute();
                $result = $st->fetch();
                if (!$result) { //si c'est pas le cas on ajoute le follow dans la base de donnee
                    $sql = "INSERT INTO FollowUser (emailFollower, emailFollowed) VALUES (?, ?)";
                } else { //si non on supprime le follow de la base de donnee
                    $sql = "DELETE FROM FollowUser WHERE emailFollower = ? and emailFollowed = ?";
                }
                $st = $bd->prepare($sql);
                $st->bindParam(1, $user);
                $st->bindParam(2, $email);
                $st->execute();
                //permet de revenir sur la page de l'utilisateur à suivre
                $sql = "SELECT pseudo FROM Utilisateur WHERE email = ?";
                $st = $bd->prepare($sql);
                $st->bindParam(1, $email);
                $st->execute();
                $result = $st->fetch();
                $pseudo = $result['pseudo'];
                header('location: ?action=ActionUtilisateur&pseudo=' . $pseudo . '&page=1');
            }
        } else { //si l'utilisateur n'est pas connecte on le renvoie dans le portail
            $html = '<h1>Vous devez être connecté pour pouvoir suivre quelqu un</h1>';
            header('location: ?action=gate');
        }
        return $html;
    }
}