<?php

namespace touiteur\action;
use touiteur\DataBase\ConnectionFactory;

class ActionLike extends Action
{

    public function execute(): string
    {
        $html = '';
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'];
            $bd = ConnectionFactory::makeConnection();
            $sql = "UPDATE touites SET likes = likes + 1 WHERE id = ?";
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
        }
        return $html;
    }
}