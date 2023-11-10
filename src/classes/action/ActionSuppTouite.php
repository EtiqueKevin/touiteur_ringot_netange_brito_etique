<?php

namespace touiteur\action;

use touiteur\touites\Touite;

class ActionSuppTouite extends Action{

    public function execute(): string{

        $id= $_GET['id'];
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        Touite::supprimerTouite($id);

        header('location: ?action=home-page&page=1');
        return 'supp';
    }
}