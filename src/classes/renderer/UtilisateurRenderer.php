<?php

namespace touiteur\renderer;

use touiteur\exception\InvalidPropertyValueException;
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
                    $html .= '<div class="profil-head">
                <img class="profil-pdp" src='.$pdp.' alt="pdp"><br>
                <h2 class="profil-pseudo">'.$this->user->__get('pseudo').'</h2><br>
                
                <p class="profil-bio">'.$this->user->__get('bio').'</p><br>
                </div>';
                }
                catch (InvalidPropertyValueException $e){
                    echo "prob";
                }
                break;
        }

       return $html;     
    }   
    
}