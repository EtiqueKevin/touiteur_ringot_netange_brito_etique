<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;
use touiteur\utilisateur\Utilisateur;


//Action permettant de modifier la photo de profil
class ActionModifPP extends Action{

    public function execute(): string{

        $bd = ConnectionFactory::makeConnection();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $html = "<p>Modification réussie</p>";
            $pseudo = unserialize($_SESSION['user'])->pseudo;
            $mail = unserialize($_SESSION['user'])->email;
            $old_pdp = unserialize($_SESSION['user'])->photo;
            $img = $_FILES['photo'];

            if ($img['size'] > 0){
                $fileDestination = 'ressources/' .$pseudo;
                //
                $fileType = $img['type'];
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
                    $row = $st->fetch();
                    if($row['pdp'] !== null){
                        if (file_exists('ressources/'.$row['pdp'])){
                        unlink('ressources/'.$row['pdp']);
                        }
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

            $sql = "UPDATE Utilisateur SET pdp = ? WHERE email = ?";
            $st = $bd->prepare($sql);
            $st->bindParam(1, $fileDestination);
            $st->bindParam(2, $mail);
            $st->execute();

            $sql = "SELECT * FROM Utilisateur WHERE email = ?";
            $st = $bd->prepare($sql);
            $st->bindParam(1, $mail);
            $st->execute();
            $row = $st->fetch();
            $pdp = $row['pdp'] !== null ? $row['pdp'] : "ressources/Z.png";
            $_SESSION['user'] = serialize(new Utilisateur($row['pseudo'], $row['email'], $row['mdp'], $row['role'], $pdp, $row['bio']));
            header('location: ?action=page-utilisateur&page=1');

        }
        else{
            $html =<<<HTML
            <div>
            
            <form method="post" enctype="multipart/form-data"><div id="form-edit">
            <h1>Modifier votre photo de profil</h1>
                <label for="photo">Photo de profil</label>
                <input type="file" name="photo" id="photo" required accept="image/gif , image/jpeg, image/png, image/jpg"><br><br>
                <input type="submit" value="Envoyer">
            </div><div></form>
HTML;

        }
        return $html;
    }
}