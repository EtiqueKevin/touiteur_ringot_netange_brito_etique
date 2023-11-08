<?php

namespace touiteur\renderer;

use touiteur\touites\ListeTouite;

class ListeTouitesRenderer{

    private $listeTouite;

    public function __construct(ListeTouite $listeTouite){
        $this->listeTouite = $listeTouite;
    }

    public function render(): string{
        $html = "<div class='liste-touite'>";

        foreach ($this->listeTouite->getTouitesListe() as $touite) {
                $html .= (new TouiteRenderer($touite))->render(1);


        }

        $html .= "</div>";

        return $html;
    }



}