<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;


//Action permettant de modifier la photo de profil
class ActionModifPP extends Action{

    public function execute(): string{

        $bd = ConnectionFactory::makeConnection();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $pseudo = unserialize($_SESSION['user'])->pseudo;
            $mail = unserialize($_SESSION['user'])->email;

            $img = $_FILES['photo'];

            if ($img['size'] > 0){
                $fileDestination = 'ressources/' .$pseudo;
                //
                $fileType = $_FILES['photo']['type'];
                if ($fileType === 'image/png' || $fileType === 'image/jpeg' || $fileType === 'image/jpg' || $fileType === 'image/gif') {
                    switch ($fileType) {
                        case 'image/png':
                            $fileDestination .='.png';
                            break;
                        case 'image/jpeg':
                            $fileDestination .='.jpeg';
                            break;
                        case 'image/jpg':
                            $fileDestination .='.jpg';
                            break;
                        case 'image/gif':
                            $fileDestination .='.gif';
                            break;
                        default:
                            $fileDestination .='.png';
                            break;
                    }

                    $query = 'SELECT * FROM Utilisateur WHERE email = ?';
                    $st = $bd->prepare($query);
                    $st->bindParam(1, $mail);
                    $st->execute();
                    $row = $st->fetchAll();

                    if (file_exists('ressources/'.$row['pdp'])){
                        unlink('ressources/'.$row['pdp']);
                    }
                    move_uploaded_file($img['tmp_name'], $fileDestination);

                }
                else{
                    $fileDestination = "ressources/Z.png";
                }
            }
            else{
                $fileDestination = null;
            }

            $sql = "UPDATE Utilisateur SET photo = ? WHERE email = ?";
            $st = $bd->prepare($sql);
            $st->bindParam(1, $fileDestination);
            $st->bindParam(2, $mail);

        }
        else{
            $html =<<<HTML
            <div>
            <h1>Modifier votre photo de profil</h1>
            <form method="post" enctype="multipart/form-data">
                <label for="bio">Photo de profil</label>
                <input type="file" name="photo" id="photo" required><br><br>
                <input type="submit" value="Envoyer">
            </div>
HTML;

        }
        return $html;
    }
}