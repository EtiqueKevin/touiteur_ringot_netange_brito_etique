<?php

namespace touiteur\action;

use touiteur\action\Action;
class ActionConnexion extends Action{

    public function execute(): string{
        // réaffichage des données soumises en cas d'erreur, sauf les mots de passe
        if (isset($_POST['btnSInscrire'])){
            $values = em_html_proteger_sortie($_POST);
        }
        else{
            $values['pseudo'] = $values['nomprenom'] = $values['email'] = $values['naissance'] = '';
        }
        $html= '<div id="auth"> 
        <h1>Connexion</h1> 
        <form method="post">';
        $html.='<label for="pseudo">Votre pseudo</label><input type="text" name="pseudo" id="pseudo" placeholder="Minimum 4 caractères"><br>';
        $html.='<label for="passe1">Votre mot de passe</label><input type="password" name="passe" id="passe" placeholder="Minimum 8 caractères"><br><br>';

        $html.= '
				<input class="input" type="submit" name="btnConnexion" value="Connexion" />
		
		</form>
		<br>
		<a href="./index.php?action=inscription"><button>Pas encore de compte, inscrivez-vous sans tarder!</button></a><br></div>';
        return $html;
    }

}