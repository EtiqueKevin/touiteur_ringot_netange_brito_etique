<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;

class ActionLike extends Action
{

    public function execute(): string
    {
        $html = '';
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_SESSION['user'])) { //on verifie si l'utilisateur est connecté
                $user = unserialize($_SESSION['user'])->email; //on recupere l'email de l'utilisateur connecté
                $id = $_GET['id']; //on recupere l'id du touite à liker
                $bd = ConnectionFactory::makeConnection();
                //on verifie si l'utilisateur connecté a deja liker le touite
                $sql = "SELECT * FROM HasLiked where email = ? and idTouite = ?";
                $st = $bd->prepare($sql);
                $st->bindParam(1, $user);
                $st->bindParam(2, $id);
                $st->execute();
                $result = $st->fetch();
                if (!$result) { //si il ne l'a pas deja liker alors on ajoute le like dans la base de donnee
                    $sql = "INSERT INTO HasLiked (email, idTouite) VALUES (?, ?)";
                    $st = $bd->prepare($sql);
                    $st->bindParam(1, $user);
                    $st->bindParam(2, $id);
                    $st->execute();
                    //on met a jour le nombre de like du touite en l'incrementant
                    $sql = "UPDATE Touite SET likes = likes + 1 WHERE id = ?";

                } else {// si il l'a deja liker alors on supprime le like de la base de donnee
                    $sql = "DELETE FROM HasLiked WHERE email = ? and idTouite = ?";
                    $st = $bd->prepare($sql);
                    $st->bindParam(1, $user);
                    $st->bindParam(2, $id);
                    $st->execute();
                    //on met a jour le nombre de like du touite en le decrementant
                    $sql = "UPDATE Touite SET likes = likes - 1 WHERE id = ?";
                }
                $st = $bd->prepare($sql);
                $st->bindParam(1, $id);
                $st->execute();
                if ($_SESSION['position'] == 'home') { //on verifie la page sur laquelle on se trouve pour pouvoir revenir dessus
                    $ah = new ActionHome();
                    $html = $ah->execute();
                } else if ($_SESSION['position'] == 'profile') {
                    $ap = new ActionProfile();
                    $html = $ap->execute();
                } else if ($_SESSION['position'] == 'discover') {
                    $ad = new ActionDiscover();
                    $html = $ad->execute();
                }
            } else { //si l'utilisateur n'est pas connecte on le renvoie dans le portail
                $html = '<h1>Vous devez être connecté pour pouvoir liker un touite</h1>';
                header('location: ?action=gate');
            }
        }
        return $html;
    }
}