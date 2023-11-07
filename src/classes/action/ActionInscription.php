<?php

namespace touiteur\action;

use touiteur\action\Action;
use touiteur\auth\Auth;
use touiteur\auth\AuthException;
class ActionInscription extends Action {

    public function execute(): string{

        // réaffichage des données soumises en cas d'erreur, sauf les mots de passe
        if (isset($_POST['btnSInscrire'])){
            $values = em_html_proteger_sortie($_POST);
        }
        else{
            $values['pseudo'] = $values['nomprenom'] = $values['email'] = $values['naissance'] = '';
        }

        $html ='<div id="auth">
        <h1>Inscription</h1>    
        <p>Pour vous inscrire, merci de fournir les informations suivantes. </p>
        <form method="post" action="inscription.php">
        ';
        $html.='<label for="pseudo">Votre pseudo</label><input type="text" name="pseudo" id="pseudo" placeholder="Minimum 4 caractères"><br>';
        $html.='<label for="passe1">Votre mot de passe</label><input type="password" name="passe1" id="passe1" placeholder="Minimum 8 caractères"><br>';
        $html.='<label for="passe2">Répétez le mot de passe</label><input type="password" name="passe2" id="passe2" placeholder="Minimum 8 caractères"><br>';
        $html.='<label for="nomprenom">Votre nom et prénom</label><input type="text" name="nomprenom" id="nomprenom" placeholder="Votre nom et prénom"><br>';
        $html.='<label for="email">Votre adresse email</label><input type="email" name="email" id="email" placeholder="Votre adresse email"><br><br>';

        $html.=
        '
        <input class=button type="submit" name="btnSInscrire" value="S\'inscrire">
        <input class=button type="reset" value="Réinitialiser">
        
        </form>
        <br><a href="./index.php?action=connexion"><button class="button">Déjà inscrit(e), connectez-vous</button</a></div>';

        return $html;
    }
}