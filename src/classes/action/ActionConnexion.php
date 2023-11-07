<?php

namespace touiteur\action;

use touiteur\action\Action;
use touiteur\auth\Auth;
use touiteur\auth\AuthException;

class ActionConnexion extends Action{

    public function execute(): string{
        // réaffichage des données soumises en cas d'erreur, sauf les mots de passe
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                Auth::authenticate($_POST['pseudo'], $_POST['passe']);
                Auth::loadProfile($_POST['email']);
                $html = "<p>Connexion réussie</p>";
                $html .= "<a href='?action=home'> RETOUR</a>";
            } catch (AuthException $e) {
                $html = "<p> ERROR</p>";
                $html .= "<a href='?action=gate'> RETOUR</a>";
            }
        }
        else{
                $html = '<div id="auth"> 
                <h1>Connexion</h1> 
                <form method="post">';
                $html .= '<label for="pseudo">Votre pseudo</label><input type="text" name="pseudo" id="pseudo" placeholder="Minimum 4 caractères"><br>';
                $html .= '<label for="passe1">Votre mot de passe</label><input type="password" name="passe" id="passe" placeholder="Minimum 8 caractères"><br><br>';
                $html .= '
				<input class="button" type="submit" name="btnConnexion" value="Connexion" />
		
		</form>
		<br>
		<a href="?action=inscription"><button class="button">Pas encore de compte, inscrivez-vous sans tarder!</button></a><br></div>';

            }
        return $html;
    }


}