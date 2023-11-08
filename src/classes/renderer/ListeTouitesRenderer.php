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
            if ($touite->photo == null){
                $html .= (new TouiteRenderer($touite))->render(1);
            }
            else{
                $html .= (new TouiteRenderer($touite))->render(2);

            }
        }

        $html .= "</div>";

        return $html;
    }



}