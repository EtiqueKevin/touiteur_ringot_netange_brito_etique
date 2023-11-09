<?php

namespace touiteur\renderer;

use touiteur\exception\InvalidPropertyValueException;
use touiteur\Home\Home;
use touiteur\utilisateur\Utilisateur;

class UtilisateurRenderer{
    private $user;

    public function __construct(Utilisateur $user){
        $this->user = $user;
    }

    public function render(int $selector): string{
        $html = '<div class="utilisateur">';
        switch ($selector) {
            case 1:
                try {

                    $pdp = $this->user->__get('photo');
                    $html .= '<div id="profil-page">
                   <div id="profil-top">
                  <div id="profil-head">
                <img class="profil-pdp" src='.$pdp.' alt="pdp"><p class="profil-pseudo">'.$this->user->__get('pseudo').'</p></div><br>
                <div id="follow-profil">
                <p class="number-follow">0 Follow</p> <a href="truc.php"><p class="button">Follows</p></a></div></div>
                <p class="profil-bio">'.$this->user->__get('bio').'</p><br>
                </div>';
                    $html .= Home::AfficherTouitEmail($this->user->__get('email'));
                }
                catch (InvalidPropertyValueException $e){
                    echo "prob";
                }
                break;
        }

       return $html;     
    }   
    
}