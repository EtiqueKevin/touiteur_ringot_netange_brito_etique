<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;

//Action permettant de modifier la bio
class ActionModifBio extends Action{


    public function execute(): string{

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bio = $_POST['bio']; //recuperation de la nouvelle biographie
            $mail = unserialize($_SESSION['user'])->email; //recuperation de l'email de l'utilisateur
            $bd = ConnectionFactory::makeConnection();
            //mise à jour de la biographie dans la base de donnee
            $sql = "UPDATE Utilisateur SET bio = ? WHERE email = ?";
            $st = $bd->prepare($sql);
            $st->bindParam(1, $bio);
            $st->bindParam(2, $mail);
            $st->execute();
            $html = "<p>Modification réussie</p>";
            header('location: ?action=page-utilisateur&page=1'); //redirection vers la page de l'utilisateur
        }
        else{ //formulaire de modification de la biographie
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