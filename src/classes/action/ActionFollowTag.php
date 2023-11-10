<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;

class ActionFollowTag extends Action
{

    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_SESSION['user'])) {
                $tag = $_GET['idTag'];
                $tag = filter_var($tag, FILTER_SANITIZE_NUMBER_INT);
                $user = unserialize($_SESSION['user'])->email;
                $bd = ConnectionFactory::makeConnection();
                $sql = "SELECT * FROM FollowTag where email = ? and idTag = ?";
                $st = $bd->prepare($sql);
                $st->bindParam(1, $user);
                $st->bindParam(2, $tag);
                $st->execute();
                $result = $st->fetch();
                if (!$result) {
                    $sql = "INSERT INTO FollowTag (email, idTag) VALUES (?, ?)";
                } else {
                    $sql = "DELETE FROM FollowTag WHERE email = ? and idTag = ?";
                }
                $st = $bd->prepare($sql);
                $st->bindParam(1, $user);
                $st->bindParam(2, $tag);
                $st->execute();

                header('location: ?action=tag-list-touite&idTag=' . $tag . '&page=1');
            }
        } else {
            $html = '<h1>Vous devez être connecté pour pouvoir suivre quelqu un</h1>';
            header('location: ?action=gate');
        }
        return $html;
    }
}