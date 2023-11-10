<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;
use touiteur\Home\Home;

class ActionTag extends Action
{

    public function execute(): string
    {
        $idTag = $_GET['idTag'];
        $db = ConnectionFactory::makeConnection();
        $query = 'SELECT * FROM Tag WHERE id = ?';
        $st = $db->prepare($query);
        $st->bindParam(1, $idTag);
        $st->execute();
        $result = $st->fetch();
        $html = '<div class="utilisateur">';
        $html .= '<div id="profil-page">
                   <div id="profil-top">
                  <div id="profil-head">
                <img class="profil-pdp" src='.$pdp.' alt="pdp"><p class="profil-pseudo">'.$this->user->__get('pseudo').'</p></div><br>
                <div id="follow-profil">
                <p class="number-follow">'. $follow . ' Followers</p>';
        $user = unserialize($_SESSION['user']);
                    $html .= Utilisateur::hasFollow($user->email, $this->user->email) ? '
                 <a href="?action=follow&email='.$this->user->email.'"><p class="button">Unfollow</p></a></div></div>
                ' : '<a href="?action=follow&email='.$this->user->email.'"><p class="button">Follow</p></a></div></div>';

        $html .= '<p class="profil-bio">'.$this->user->__get('bio').'</p><br>
                </div>';
        $html .= Home::AfficherTouitTag($_GET['idTag']);












        return "1";
    }
}