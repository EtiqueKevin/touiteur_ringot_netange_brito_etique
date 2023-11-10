<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;

class ActionFollowTag extends Action
{

    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_SESSION['user'])) {
                $tag = $_GET['idTag']; //on recupere l'id du tag à suivre
                $tag = filter_var($tag, FILTER_SANITIZE_NUMBER_INT);
                $user = unserialize($_SESSION['user'])->email; //on recupere l'email du suiveur
                $bd = ConnectionFactory::makeConnection();
                //on verifie si l'utilisateur connecté suit deja le tag à suivre
                $sql = "SELECT * FROM FollowTag where email = ? and idTag = ?";
                $st = $bd->prepare($sql);
                $st->bindParam(1, $user);
                $st->bindParam(2, $tag);
                $st->execute();
                $result = $st->fetch();
                if (!$result) { //si non, on l'ajoute dans la base de donnee
                    $sql = "INSERT INTO FollowTag (email, idTag) VALUES (?, ?)";
                } else { //si oui, on le supprime de la base de donnee
                    $sql = "DELETE FROM FollowTag WHERE email = ? and idTag = ?";
                }
                $st = $bd->prepare($sql);
                $st->bindParam(1, $user);
                $st->bindParam(2, $tag);
                $st->execute();

                header('location: ?action=tag-list-touite&idTag=' . $tag . '&page=1'); //permet de revenir sur la page du tag
            }
        } else { //si l'utilisateur n'est pas connecte on le renvoie dans le portail
            $html = '<h1>Vous devez être connecté pour pouvoir suivre quelqu un</h1>';
            header('location: ?action=gate');
        }
        return $html;
    }
}