<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;
use touiteur\Home\Home;
use touiteur\utilisateur\Utilisateur;

class ActionTag extends Action
{

    public function execute(): string
    {
        $button = "";
        $idTag = $_GET['idTag'];
        $db = ConnectionFactory::makeConnection();
        $query = 'SELECT * FROM Tag WHERE id = ?';
        $st = $db->prepare($query);
        $st->bindParam(1, $idTag);
        $st->execute();
        $result = $st->fetch();
        $tagName = $result['tag'];
        $query = 'SELECT * FROM Tag WHERE id = ?';
        $st = $db->prepare($query);
        $st->bindParam(1, $idTag);
        $st->execute();
        $result = $st->fetch();
        $tagName = $result['tag'];
        $query = 'SELECT * FROM FollowTag WHERE idTag = ?';
        $st = $db->prepare($query);
        $st->bindParam(1, $idTag);
        $st->execute();
        $result = $st->fetchAll();
        $follow = count($result);
        if (isset($_SESSION['user'])) {
            $user = unserialize($_SESSION['user']);

            $button .= Utilisateur::hasFollowTag($user->email, $_GET['idTag']) ? '<a href="?action=followTag&idTag=' . $_GET['idTag'] . '">
            <p class="button">Unfollow</p></a></div></div> ' : '<a href="?action=followTag&idTag=' . $_GET['idTag'] . '"><p class="button">Follow</p></a></div></div>';
        }


        $html = '<div class="tag-page">';
        $html .= '<div id="tag-page">
                   <div id="tag-top">
                  <div id="tag-head">
                <p class="tag-name"> #' . $tagName . '</p></div><br>
                <div id="follow-tag">';

        $html .= '<p class="number-follow">' . $follow . ' Followers</p>';
        $html .= $button;
        $html .= '</div></div></div>';
        $html .= Home::afficherTouitTag($idTag);

        return $html;
    }
}