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
            $nouveauTouite = null;
            if($touite['img'] == null){
                $nouveauTouite = new Touite($touite['id'], $touite['text'], $touite['date'], $touite['pseudo']);
                $listeTouite->addTouite($nouveauTouite);}
            else{
            $nouveauTouite = new Touite($touite['id'], $touite['text'], $touite['date'], $touite['pseudo'], $touite['img']);
            $listeTouite->addTouite($nouveauTouite);}
        }
        $listeTouiteRenderer = new ListeTouitesRenderer($listeTouite);
        return $listeTouiteRenderer->render(1);
    }

    public static function afficherTouitesSuivie(): string{
        $db = ConnectionFactory::makeConnection();

        $st1= $db->prepare("Select followed from FollowedUser where follower = ?");
        $st1->bindParam(1, $_SESSION['user']->email);
        $st1->execute();
        $row1 = $st1->fetch();
        $emailRes = implode(',', $row1);

        $st2= $db->prepare("Select id from FollowTag inner join TouiteTag on FollowTag.tag = TouiteTag.tag where FollowTag.email = ?");
        $st2->bindParam(1, $_SESSION['user']->email);
        $st2->execute();
        $row2 = $st2->fetch();
        $idRes = implode(',', $row2);

        $statement = $db->prepare("Select * from Touite where id IN ? OR author IN ? order by date desc");
        $statement->bindParam(1, $idRes);
        $statement->bindParam(2, $emailRes);
        $statement->execute();
        $touites = $statement->fetchAll();

        $listeTouite = new ListeTouite();

        foreach ($touites as $touite) {
            $nouveauTouite = null;
            if($touite['img'] == null){
                $nouveauTouite = new Touite($touite['id'], $touite['text'], $touite['date'], $touite['pseudo']);
                $listeTouite->addTouite($nouveauTouite);}
            else{
                $nouveauTouite = new Touite($touite['id'], $touite['text'], $touite['date'], $touite['pseudo'], $touite['img']);
                $listeTouite->addTouite($nouveauTouite);}
        }
        $listeTouiteRenderer = new ListeTouitesRenderer($listeTouite);
        return $listeTouiteRenderer->render(1);
    }
}
