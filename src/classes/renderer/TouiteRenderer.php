<?php

namespace touiteur\renderer;

use touiteur\exception\InvalidPropertyValueException;
use touiteur\touites\Touite;
use touiteur\utilisateur\Utilisateur;

class TouiteRenderer{

    private $touite;

    public function __construct(Touite $touite){
        $this->touite = $touite;
    }

    public function render(int $selector): string {
        $html="<div class='touite'>";
        switch ($selector){
            case 1:
                try {
                    $user = unserialize($_SESSION['user']);
                    $html .= '<div id="block-touite">
                <div id="touite">
                <div id="touite-head">
                <h2 class="touite-author"><a href="utilisateur.php">'.$this->touite->auteur.'</a></h2><br></div>
                <p class="touite-content">'.$this->touite->texte.'</p><br>';
                $html .= $this->touite->photo != null ? "image..." : "";
                $html .= Utilisateur::hasLiked($user->email, $this->touite->id) ? '</div> <a href="?action=like&id='.$this->touite->id.'"><img id="unlike" src="ressources/Heart.png"></a></p></div>' : '</div> <a href="?action=like&id='.$this->touite->id.'"><img id="like" src="ressources/Heart.png"></a></p></div>';


                } catch (InvalidPropertyValueException $e) {
                    echo $e->getMessage();
                }

                break;
            case 2:
                try {
                    $html .= '<div id="touite">
                    <h2 class="touite-author"><a href="utilisateur.php">'.$this->touite->auteur.'</a></h2> '.$this->touite->aff_date().'<br>
                    <p class="touite-content">'.$this->touite->texte.'</p><br>'.
                        '<img class="imgAuteur" src="'. 'upload/'.$this->touite->photo.'.jpg  alt="photo de l\'auteur">'.
                        '<p><a href="../index.html">Répondre</a> <a href="?action=like&id='.$this->touite->id.'">like</a></p>
                    ';
                } catch (InvalidPropertyValueException $e) {
                    echo $e->getMessage();
                }

                break;
            default:
                try {
                    $html .= '
                <h2 class="touite-author"><a href="utilisateur.php">'.$this->touite->__get('auteur').'</a></h2> '.$this->touite->aff_date().'<br>
                <p class="touite-content">'.$this->touite->__get('texte').'</p><br>'.
                        '<img src="'. 'upload/'.$this->touite->__get('photo').'.jpg"'.
                        ' class="imgAuteur" alt="photo de l\'auteur">'.'<p><a href="../index.html">Répondre</a> <a href="?action=like&id='.$this->touite->id.'">like</a></p>
                ';
                } catch (InvalidPropertyValueException $e) {
                    echo $e->getMessage();
                }

                break;
        }
        return $html;
    }



}