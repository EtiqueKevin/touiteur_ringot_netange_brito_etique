<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;

//Action permettant de modifier la bio
class ActionModifBio extends Action{


    public function execute(): string{

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bio = $_POST['bio'];
            $mail = unserialize($_SESSION['user'])->email;
            $bd = ConnectionFactory::makeConnection();
            $sql = "UPDATE Utilisateur SET bio = ? WHERE email = ?";
            $st = $bd->prepare($sql);
            $st->bindParam(1, $bio);
            $st->bindParam(2, $mail);
            $st->execute();
            $html = "<p>Modification réussie</p>";
            header('location: ?action=page-utilisateur');
        }
        else{
            $html =<<<HTML
            <div>
            
            <form method="post">
                <div id="form-edit">
                <h1>Modifier votre bio</h1>
                <label for="bio">Bio</label>
                <textarea name="bio" id="bio" required maxlength="255" ></textarea><br><br>
                <input type="submit" value="Envoyer">
                </div>
            </div>
HTML;

        }

        return $html;
    }
}