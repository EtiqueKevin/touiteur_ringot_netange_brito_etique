<?php

namespace touiteur\action;
use touiteur\Home\Home;

require_once 'vendor/autoload.php';
class ActionHome{
    public function execute(): string{
        $html = <<<HTML
        <h1>Home page</h1>
        HTML;
        $html .= Home::afficherTouit();
        return $html;
    }

}