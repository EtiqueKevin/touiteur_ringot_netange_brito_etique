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
            $img = $touite['img'] == null ? null : $touite['img'];
            $nouveauTouite = new Touite($touite['id'], $touite['text'], $touite['date'], $touite['pseudo'], $touite['img']);
            $listeTouite->addTouite($nouveauTouite);}

        $listeTouiteRenderer = new ListeTouitesRenderer($listeTouite);
        return $listeTouiteRenderer->render();
    }

    public static function afficherTouitesSuivie(): string{
        $db = ConnectionFactory::makeConnection();

        $st1= $db->prepare("Select emailfollowed from FollowUser where emailfollower = ?");
        //var_dump(unserialize($_SESSION['user'])->email);
        $mail = unserialize($_SESSION['user'])->email;

        $statement = $db->prepare("Select * from Touite inner join Utilisateur on Touite.author = Utilisateur.email where id IN (Select idTouite from Followtag inner join TouiteTag on Followtag.idTag = TouiteTag.idTag where Followtag.email = ?) OR author IN (Select emailfollowed from FollowUser where emailfollower = ?) order by date desc");
        $statement->bindParam(1, $mail);
        $statement->bindParam(2, $mail);
        $statement->execute();
        $touites = $statement->fetchAll();

        $listeTouite = new ListeTouite();

        foreach ($touites as $touite) {
            $nouveauTouite = null;
            $img = $touite['img'] == null ? null : $touite['img'];
            $nouveauTouite = new Touite($touite['id'], $touite['text'], $touite['date'], $touite['pseudo'], $touite['img']);
            $listeTouite->addTouite($nouveauTouite);
        }

        $listeTouiteRenderer = new ListeTouitesRenderer($listeTouite);
        return $listeTouiteRenderer->render();
    }
    public static function afficherTouitEmail($email): string{
        $db = ConnectionFactory::makeConnection();
        $statement = $db->prepare("Select * from Touite inner join Utilisateur on Touite.author = Utilisateur.email where email = ? order by date desc");
        $statement->bindParam(1, $email);
        $res = $statement->execute();
        $touites = $statement->fetchAll();
        $listeTouite = new ListeTouite();
        foreach ($touites as $touite) {
            $nouveauTouite = null;
            $img = $touite['img'] == null ? null : $touite['img'];
            $nouveauTouite = new Touite($touite['id'], $touite['text'], $touite['date'], $touite['pseudo'], $touite['img']);
            $listeTouite->addTouite($nouveauTouite);}

        $listeTouiteRenderer = new ListeTouitesRenderer($listeTouite);
        return $listeTouiteRenderer->render();
    }

    public static function afficherTouitTag($tag): string{
        $db = ConnectionFactory::makeConnection();
        $statement = $db->prepare("Select id, text, date, author, img from Touite inner join TouiteTag on Touite.id = TouiteTag.idTouite where TouiteTag.idTag = ? order by date desc");
        $statement->bindParam(1, $tag);
        $res = $statement->execute();
        $touites = $statement->fetchAll();
        $listeTouite = new ListeTouite();
        foreach ($touites as $touite) {
            $statement = $db->prepare("Select pseudo from Utilisateur where email = ?");
            $statement->bindParam(1, $touite['author']);
            $res = $statement->execute();
            $pseudo = $statement->fetch()['pseudo'];
            $nouveauTouite = null;
            $img = $touite['img'] == null ? null : $touite['img'];
            $nouveauTouite = new Touite($touite['id'], $touite['text'], $touite['date'], $pseudo, $img);
            $listeTouite->addTouite($nouveauTouite);}

        $listeTouiteRenderer = new ListeTouitesRenderer($listeTouite);
        return $listeTouiteRenderer->render();
    }
}
