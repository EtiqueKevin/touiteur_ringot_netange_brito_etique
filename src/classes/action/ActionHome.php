<?php

namespace touiteur\action;

class ActionHome{
    public function execute(): string{
        $html = <<<HTML
        <h1>Home page</h1>
        HTML;
        return $html;
    }

}