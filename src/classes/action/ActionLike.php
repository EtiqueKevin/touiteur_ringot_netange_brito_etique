<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;

class ActionLike extends Action
{

    public function execute(): string
    {
        $html = '';
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_SESSION['user'])) {
                $user = unserialize($_SESSION['user'])->email;
                $id = $_GET['id'];
                $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
                $bd = ConnectionFactory::makeConnection();
                $sql = "SELECT * FROM HasLiked where email = ? and idTouite = ?";
                $st = $bd->prepare($sql);
                $st->bindParam(1, $user);
                $st->bindParam(2, $id);
                $st->execute();
                $result = $st->fetch();
                if (!$result) {
                    $sql = "INSERT INTO HasLiked (email, idTouite) VALUES (?, ?)";
                    $st = $bd->prepare($sql);
                    $st->bindParam(1, $user);
                    $st->bindParam(2, $id);
                    $st->execute();
                    $sql = "UPDATE Touite SET likes = likes + 1 WHERE id = ?";

                } else {
                    $sql = "DELETE FROM HasLiked WHERE email = ? and idTouite = ?";
                    $st = $bd->prepare($sql);
                    $st->bindParam(1, $user);
                    $st->bindParam(2, $id);
                    $st->execute();
                    $sql = "UPDATE Touite SET likes = likes - 1 WHERE id = ?";
                }
                $st = $bd->prepare($sql);
                $st->bindParam(1, $id);
                $st->execute();
                if ($_SESSION['position'] == 'home') {
                    $ah = new ActionHome();
                    $html = $ah->execute();
                } else if ($_SESSION['position'] == 'profile') {
                    $ap = new ActionProfile();
                    $html = $ap->execute();
                } else if ($_SESSION['position'] == 'discover') {
                    $ad = new ActionDiscover();
                    $html = $ad->execute();
                }
            } else {
                $html = '<h1>Vous devez être connecté pour pouvoir liker un touite</h1>';
                header('location: ?action=gate');
            }
        }
        return $html;
    }
}