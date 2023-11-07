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
                    $html .= '<div class="utilisateur-head">
                <h2 class="utilisateur-pseudo">'.$this->user->__get('pseudo').'</h2><br></div>';
                }
                catch (InvalidPropertyValueException $e){
                    echo "prob";
                }
                break;
        }
            
            
            
       return $html;     
    }   
    
}