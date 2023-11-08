<?php

namespace touiteur\Home;

use touiteur\DataBase\ConnectionFactory;
use touiteur\renderer\ListeTouitesRenderer;
use touiteur\touites\ListeTouite;
use touiteur\touites\Touite;

class Home{
    public static function afficherTouit(): string{
        $db = ConnectionFactory::makeConnection();
        $statement = $db->prepare("Select * from Touite");
        $res = $statement->execute();
        $touites = $statement->fetchAll();
        $listeTouite = new ListeTouite();
        foreach ($touites as $touite) {
            $nouveauTouite = null;
            if($touite['photo'] == null){
                $nouveauTouite = new Touite($touite['id'], $touite['text'], $touite['date'], $touite['author'],$touite['photo']);
                $listeTouite->addTouite($nouveauTouite);}
            else{
            $nouveauTouite = new Touite($touite['id'], $touite['text'], $touite['date'], $touite['author'], $touite['photo']);
            $listeTouite->addTouite($nouveauTouite);}
        }
        $listeTouiteRenderer = new ListeTouitesRenderer($listeTouite);
        return $listeTouiteRenderer->render(1);
    }
}