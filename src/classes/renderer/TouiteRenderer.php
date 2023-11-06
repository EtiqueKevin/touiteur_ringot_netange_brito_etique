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
                    $html .= "<h2>{$this->touite->__get('auteur')}</h2>";
                    $html .= "<p>{$this->touite->__get('texte')}</p>";
                } catch (InvalidPropertyValueException $e) {
                    echo $e->getMessage();
                }

            break;
            case 2:
                try {
                    $html .= "<h2>{$this->touite->__get('auteur')}</h2> ";
                    $html .= "<p>{$this->touite->__get('texte')}</p>";
                    $html .= "<p>{$this->touite->__get('date')} | {$this->touite->__get('like')} | {$this->touite->__get('dislike')}  </p>";
                } catch (InvalidPropertyValueException $e) {
                    echo $e->getMessage();
                }

            break;
            default:
                try {
                    $html .= "<h2>{$this->touite->__get('auteur')}</h2> </h3>";
                    $html .= "<p>{$this->touite->__get('texte')}</p>";
                    $html .= "<p>{$this->touite->__get('date')}</p>";
                } catch (InvalidPropertyValueException $e) {
                    echo $e->getMessage();
                }

            break;
        }
        return $html;
    }



}