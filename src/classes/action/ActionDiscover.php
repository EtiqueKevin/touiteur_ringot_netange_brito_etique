<?php

namespace touiteur\action;

use touiteur\Home\Home;

require_once 'vendor/autoload.php';

class ActionDiscover
{
    public function execute(): string
    {

        return Home::afficherTouit();  //affichage de la page des decouverte

    }

}