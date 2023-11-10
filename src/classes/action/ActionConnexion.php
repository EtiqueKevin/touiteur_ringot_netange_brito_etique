<?php

namespace touiteur\action;

use touiteur\auth\Auth;
use touiteur\auth\AuthException;

class ActionConnexion extends Action
{

    public function execute(): string
    {
        // réaffichage des données soumises en cas d'erreur, sauf les mots de passe
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                Auth::authenticate($_POST['email'], $_POST['passe']); //authentification de l'utilisateur
                Auth::loadProfile($_POST['email']); //chargement du profil de l'utilisateur
                $html = "<p>Connexion réussie</p>";
                header('location: ?action=home-page&page=1'); //redirection vers la page d'accueil
            } catch (AuthException $e) { //en cas d'erreur lors de la connexion
                $html = "<p> Connexion échoué</p>";
                $html .= "<a href='?action=gate'>Ressayer</a>";
            }
        } else {
            //formulaire de connexion à afficher dans le cas d'une méthode get
            $html = '<div id="auth"> 
                <h1>Connexion</h1> 
                <form method="post">';
            $html .= '<label for="email">Votre email</label><input type="text" name="email" id="email" placeholder="email"><br>';
            $html .= '<label for="passe1">Votre mot de passe</label><input type="password" name="passe" id="passe" placeholder="Minimum 8 caractères"><br><br>';
            $html .= '
				<input class="button" type="submit" value="Connexion" />
		
		</form>
		<br>
		<a href="?action=inscription"><button class="button">Pas encore de compte, inscrivez-vous sans tarder!</button></a><br></div>';

        }
        return $html;
    }


}