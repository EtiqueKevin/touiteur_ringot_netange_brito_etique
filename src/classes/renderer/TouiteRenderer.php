<?php

namespace touiteur\renderer;

use touiteur\exception\InvalidPropertyValueException;
use touiteur\touites\Touite;

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
                    $html .= '<li>
                <h2><a href="utilisateur.php">'.$this->touite->__get('auteur').'</a> </h2>'.$this->touite->aff_date().'<br>
                <p>'.$this->touite->__get('auteur').'</p><br>
                <p><a href="../index.html">Répondre</a> <a href="../index.html">like</a></p>
                </li>';
                } catch (InvalidPropertyValueException $e) {
                    echo $e->getMessage();
                }

                break;
            case 2:
                try {
                    $html .= '<li>
                    <h2><a href="utilisateur.php">'.$this->touite->__get('auteur').'</a></h2> '.$this->touite->aff_date().'<br>
                    <p>'.$this->touite->__get('texte').'</p><br>'.
                        '<img src="'. 'upload/'.$this->touite->__get('photo').'.jpg"'.
                        ' class="imgAuteur" alt="photo de l\'auteur">'.
                        '<p><a href="../index.html">Répondre</a> <a href="../index.html">like</a></p>
                    </li>';
                } catch (InvalidPropertyValueException $e) {
                    echo $e->getMessage();
                }

                break;
            default:
                try {
                    $html .= '<li>
                <a href="utilisateur.php">'.$this->touite->__get('auteur').'</a> '.$this->touite->aff_date().'<br>
                <p>'.$this->touite->__get('texte').'</p><br>'.
                        '<img src="'. 'upload/'.$this->touite->__get('photo').'.jpg"'.
                        ' class="imgAuteur" alt="photo de l\'auteur">'.'<p><a href="../index.html">Répondre</a> <a href="../index.html">like</a></p>
                </li>';
                } catch (InvalidPropertyValueException $e) {
                    echo $e->getMessage();
                }

                break;
        }
        return $html;
    }



}