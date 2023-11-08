<?php

namespace touiteur\Home;

use touiteur\DataBase\ConnectionFactory;
use touiteur\renderer\ListeTouitesRenderer;
use touiteur\touites\ListeTouite;
use touiteur\touites\Touite;

class Home{
    public static function afficherTouit(): string{
        $db = ConnectionFactory::makeConnection();
        $statement = $db->prepare("Select * from Touite inner join Utilisateur on Touite.author = Utilisateur.email order by date desc");
        $res = $statement->execute();
        $touites = $statement->fetchAll();
        $listeTouite = new ListeTouite();
        foreach ($touites as $touite) {
            $img = $touite['img'] != null ? $touite['img'] : null;
            $nouveauTouite = new Touite($touite['id'], $touite['text'], $touite['date'], $touite['pseudo'], $img);
            $listeTouite->addTouite($nouveauTouite);
        }
        $listeTouiteRenderer = new ListeTouitesRenderer($listeTouite);
        return $listeTouiteRenderer->render();
    }
}
