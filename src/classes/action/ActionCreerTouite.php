<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;
use touiteur\Home\HomeTouite;

class ActionCreerTouite extends Action{

    public function execute(): string{

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $text = filter_var($_POST['txtMessage'], FILTER_SANITIZE_STRING);
            //
            if (!empty($_FILES['img']['name'])){
                $fileSource = $_FILES['img']['name'];
                $fileDestination = 'ressources/' . $fileSource;
                //
                $fileType = $_FILES['img']['type'];
                if ($fileType === 'image/png' || $fileType === 'image/jpeg' || $fileType === 'image/jpg' || $fileType === 'image/gif') {
                    move_uploaded_file($_FILES['img']['tmp_name'], $fileDestination);
                }
                else{
                    return "Le fichier n'est pas une image";
                }
            }
            else{
                $fileDestination = null;
            }



            $d = date('Y-m-d H:i:s');
            $mail = unserialize($_SESSION['user'])->email;



            $bd = ConnectionFactory::makeConnection();

            $query = 'SELECT `MAX(id)` FROM `Touite`';
            $st = $bd->prepare($query);
            $st->execute();
            $st->setFetchMode(PDO::FETCH_ASSOC);
            $row = $st->fetch();
            $idT = $row['MAX(id)'] + 1;

            $query = 'INSERT INTO `Touite` (`text`, `date`, `author`,`img`) VALUES (?, ?, ?, ?)';
            $stt = $bd->prepare($query);
            $stt->bindParam(1, $text);
            $stt->bindParam(2, $d);
            $stt->bindParam(3, $mail);
            $stt->bindParam(4, $fileDestination);
            $stt->execute();

            $query = 'SELECT tag FROM `Tag`';
            $st = $bd->prepare($query);
            $st->execute();
            $st->setFetchMode(PDO::FETCH_ASSOC);
            $row = $st->fetch();


            $tab = HomeTouite::recup_tag($text);
            foreach ($tab as $tg){
                if(!in_array($tg, $row)){
                    $query = 'INSERT INTO `Tag` (`tag`) VALUES (?)';
                    $st = $bd->prepare($query);
                    $st->bindParam(1, $tag);
                    $st->execute();
                }
                $query = 'INSERT INTO `TouiteTag` (`idTouite`, `idTag`) VALUES (?, (SELECT `idTag` FROM `Tag` WHERE `tag` = ?))';
                $st = $bd->prepare($query);
                $st->bindParam(1, $idT);
                $st->bindParam(2, $tg);
                $st->execute();
            }

            $html = "Touite publié";
            $html .= "<a href='?action=home-page'>Retour</a>";
        }
        else{
            $html = HomeTouite::formulaire_touite();
        }
        return $html;

    }
}