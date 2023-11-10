<?php

namespace touiteur\renderer;

use touiteur\touites\ListeTouite;
use touiteur\touites\Touite;

class ListeTouitesRenderer{

    private $listeTouite;

    public function __construct(ListeTouite $listeTouite){
        $this->listeTouite = $listeTouite;
    }

    public function render(): string{
        $tab = $this->listeTouite->getTouitesListe();
        $tab2 = Touite::pagination($tab);

        $html = "<div class='liste-touite'>";

        foreach ($tab2 as $touite) {
            $html .= (new TouiteRenderer($touite))->render(1);
        }

        $html .= "</div>";

        if (($_SESSION['nbTouite'] < TOUITE_PAR_PAGE) || ($_SESSION['nbTouite'] - TOUITE_PAR_PAGE) > 0) {
            if($_SESSION['nbTouite'] < TOUITE_PAR_PAGE && ($_GET['page'] == 1)){
                $html .= $_GET['page'];
            }else{
                if($_GET['page'] == 1 && ($_SESSION['nbTouite'] > TOUITE_PAR_PAGE)){
                    $html .=$_GET['page'].'  <a href="?action='.$_GET['action'].'&page='. ($_GET['page'] + 1). '">Page suivante</a>';
                }else{
                    if(sizeof($tab2) <= TOUITE_PAR_PAGE * $_GET['page'] ){
                        $html .= '<a href="?action='.$_GET['action'].'&page='. ($_GET['page'] - 1). '">Page précédente</a>'.$_GET['page'];
                    }else{
                        $html .= '<a href="?action='.$_GET['action'].'&page='. ($_GET['page'] - 1). '">Page précédente</a> '.$_GET['page'].'<a href="?action='.$_GET['action'].'&page='. ($_GET['page'] + 1). '"> Page suivante</a>';
                    }
                }
            }
        }

        return $html;
    }



}