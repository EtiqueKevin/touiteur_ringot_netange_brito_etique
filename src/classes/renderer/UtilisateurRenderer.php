<?php

namespace touiteur\renderer;

use touiteur\exception\InvalidPropertyValueException;
use touiteur\Home\Home;
use touiteur\utilisateur\Utilisateur;

class UtilisateurRenderer
{
    private $user;

    public function __construct(Utilisateur $user)
    {
        $this->user = $user;
    }

    public function render(int $selector): string
    {
        $userLog = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
        $selector = $this->user->email === $userLog->email ? 3 : $selector;

        $html = '<div class="utilisateur">';
        $follow = Utilisateur::getFollower($this->user->email);
        $pdp = $this->user->__get('photo');

        switch ($selector) {
            case 1:
                try {
                    $html .= '<div id="profil-page">
                   <div id="profil-top">
                  <div id="profil-head">
                <img class="profil-pdp" src=' . $pdp . ' alt="pdp"><p class="profil-pseudo">' . $this->user->__get('pseudo') . '</p></div><br>
                <div id="follow-profil">
                <p class="number-follow">' . $follow . ' Followers</p>
                 </div></div>
                ';

                } catch (InvalidPropertyValueException $e) {
                    echo "prob";
                }
                break;
            case 2:
                try {
                    $html .= '<div id="profil-page">
                   <div id="profil-top">
                  <div id="profil-head">
                <img class="profil-pdp" src=' . $pdp . ' alt="pdp"><p class="profil-pseudo">' . $this->user->__get('pseudo') . '</p></div><br>
                <div id="follow-profil">
                <p class="number-follow">' . $follow . ' Followers</p>';
                    $user = unserialize($_SESSION['user']);
                    $html .= Utilisateur::hasFollow($user->email, $this->user->email) ? '
                 <a href="?action=follow&email=' . $this->user->email . '"><p class="button">Unfollow</p></a></div></div>
                ' : '<a href="?action=follow&email=' . $this->user->email . '"><p class="button">Follow</p></a></div></div>';

                } catch (InvalidPropertyValueException $e) {
                    echo "prob";
                }
                break;
            case 3 :{
                $html .= '<div id="profil-page">
                   <div id="profil-top">
                  <div id="profil-head">
                <img class="profil-pdp" src=' . $pdp . ' alt="pdp"><p class="profil-pseudo">' . $this->user->__get('pseudo') . '</p></div><br>
                <div id="follow-profil">
                <p class="number-follow">' . $follow . ' Followers</p>
                 </div></div>
                 <div id="edit-profil">
                 <a href="?action=edit-pdp"><button class="button">Changer de pdp</button></a>
                 <a href="?action=edit-bio"><button class="button">Changer de bio</button></a>
</div>
                ';

            }
        }
        $html .= '<p class="profil-bio">' . $this->user->__get('bio') . '</p><br>
                </div>';
        $html .= Home::AfficherTouitEmail($this->user->__get('email'));

        return $html;
    }

}