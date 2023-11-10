<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;

class ActionFollow extends Action
{

    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_SESSION['user'])) {
                $email = $_GET['email'];
                $user = unserialize($_SESSION['user'])->email;
                $bd = ConnectionFactory::makeConnection();
                $sql = "SELECT * FROM FollowUser where emailFollower = ? and emailFollowed = ?";
                $st = $bd->prepare($sql);
                $st->bindParam(1, $user);
                $st->bindParam(2, $email);
                $st->execute();
                $result = $st->fetch();
                if (!$result) {
                    $sql = "INSERT INTO FollowUser (emailFollower, emailFollowed) VALUES (?, ?)";
                } else {
                    $sql = "DELETE FROM FollowUser WHERE emailFollower = ? and emailFollowed = ?";
                }
                $st = $bd->prepare($sql);
                $st->bindParam(1, $user);
                $st->bindParam(2, $email);
                $st->execute();

                $sql = "SELECT pseudo FROM Utilisateur WHERE email = ?";
                $st = $bd->prepare($sql);
                $st->bindParam(1, $email);
                $st->execute();
                $result = $st->fetch();
                $pseudo = $result['pseudo'];
                header('location: ?action=ActionUtilisateur&pseudo=' . $pseudo . '&page=1');
            }
        } else {
            $html = '<h1>Vous devez être connecté pour pouvoir suivre quelqu un</h1>';
            header('location: ?action=gate');
        }
        return $html;
    }
}