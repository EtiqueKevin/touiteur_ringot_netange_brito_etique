<?php

namespace touiteur\action;

use PDO;
use touiteur\DataBase\ConnectionFactory;
use touiteur\Home\HomeTouite;

class ActionCreerTouite extends Action
{

    public function execute(): string
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $text = filter_var($_POST['txtMessage'], FILTER_SANITIZE_STRING);
            $d = date('Y-m-d H:i:s');
            $mail = unserialize($_SESSION['user'])->email; //recuperation de l'email de l'utilisateur connecté


            $bd = ConnectionFactory::makeConnection();

            $query = 'SELECT MAX(id) FROM `Touite`';
            $st = $bd->prepare($query);
            $st->execute();
            $st->setFetchMode(PDO::FETCH_ASSOC);
            $row = $st->fetch();
            $idT = $row['MAX(id)'] + 1; //recuperation de l'id du nouveau touite

            //code pour intégrer une image au touite
            $img = $_FILES['img'];
            if ($img['size'] > 0) {
                $fileDestination = 'ressources/' . $idT;
                //
                $fileType = $_FILES['img']['type'];
                if ($fileType === 'image/png' || $fileType === 'image/jpeg' || $fileType === 'image/jpg' || $fileType === 'image/gif') {
                    switch ($fileType) {
                        case 'image/png':
                            $fileDestination .= '.png';
                            break;
                        case 'image/jpeg':
                            $fileDestination .= '.jpeg';
                            break;
                        case 'image/jpg':
                            $fileDestination .= '.jpg';
                            break;
                        case 'image/gif':
                            $fileDestination .= '.gif';
                            break;
                        default:
                            $fileDestination .= '.png';
                            break;
                    }

                    move_uploaded_file($img['tmp_name'], $fileDestination);

                } else {
                    $fileDestination = "ressources/Z.png";
                }
            } else {
                $fileDestination = null;
            }

            //insertion du touite dans la base de données
            $query = 'INSERT INTO `Touite` (`text`, `date`, `author`,`img`) VALUES (?, ?, ?, ?)';
            $stt = $bd->prepare($query);
            $stt->bindParam(1, $text);
            $stt->bindParam(2, $d);
            $stt->bindParam(3, $mail);
            $stt->bindParam(4, $fileDestination);
            $stt->execute();


            //selection des tags dans la base de données
            $query = 'SELECT tag FROM `Tag`';
            $st = $bd->prepare($query);
            $st->execute();
            $st->setFetchMode(PDO::FETCH_ASSOC);
            $row = $st->fetchAll();

            //recuperation des tags depuis le texte du touite
            $tab = HomeTouite::recup_tag($text);
            foreach ($tab as $tg) {

                $q = 'SELECT * FROM `Tag` WHERE `tag` = ?';
                $s = $bd->prepare($q);
                $s->bindParam(1, $tg);
                $s->execute();
                $s->setFetchMode(PDO::FETCH_ASSOC);
                $rowCount = $s->rowCount();
                //si il y a un nouveau tag, on l'ajoute dans la base de données
                if ($rowCount == 0) {
                    $query = 'INSERT INTO `Tag` (`tag`) VALUES (?)';
                    $st = $bd->prepare($query);
                    $st->bindParam(1, $tg);
                    $st->execute();
                }
                $query = 'INSERT INTO `TouiteTag` (`idTouite`, `idTag`) VALUES (?, (SELECT `id` FROM `Tag` WHERE `tag` = ?))';
                $st = $bd->prepare($query);
                $st->bindParam(1, $idT);
                $st->bindParam(2, $tg);
                $st->execute();
            }

            $html = "Touite publié";
            header('location: ?action=home-page&page=1'); //redirection vers la page d'accueil
        } else {
            $html = HomeTouite::formulaire_touite(); //formulaire de touite à afficher dans le cas d'une méthode get
        }
        return $html;

    }
}