<?php

namespace touiteur\action;
use touiteur\Home\Home;

require_once 'vendor/autoload.php';
class ActionHome{
    public function execute(): string{

        return isset($_SESSION['user']) ? Home::afficherTouitesSuivie() : Home::afficherTouit();

    }

}