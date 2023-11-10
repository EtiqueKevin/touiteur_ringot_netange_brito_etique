<?php

namespace touiteur\action;

use touiteur\auth\Auth;
use touiteur\auth\AuthException;

class ActionInscription extends Action
{

    public function execute(): string
    {

        // réaffichage des données soumises en cas d'erreur, sauf les mots de passe
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                Auth::register($_POST['pseudo'], $_POST['passe1']);
                $html = "<p>inscription réussie</p>";
                header('location: ?action=gate&page=1');
            } catch (AuthException $e) {
                $html = "<p> ERROR</p>";
                header('location: ?action=inscription');
            }

        } else {

            $html = '<div id="auth">
        <h1>Inscription</h1>    
        <p>Pour vous inscrire, merci de fournir les informations suivantes. </p>
        <form method="post">
        ';
            $html .= '<label for="pseudo">Votre pseudo</label><input type="text" name="pseudo" id="pseudo" placeholder="Minimum 4 caractères"><br>';
            $html .= '<label for="passe1">Votre mot de passe</label><input type="password" name="passe1" id="passe1" placeholder="Minimum 8 caractères"><br>';
            $html .= '<label for="passe2">Répétez le mot de passe</label><input type="password" name="passe2" id="passe2" placeholder="Minimum 8 caractères"><br>';
            $html .= '<label for="nomprenom">Votre nom et prénom</label><input type="text" name="nomprenom" id="nomprenom" placeholder="Votre nom et prénom"><br>';
            $html .= '<label for="email">Votre adresse email</label><input type="email" name="email" id="email" placeholder="Votre adresse email"><br><br>';

            $html .=
                '
        <input class=button type="submit" value="Envoyer" >
        <input class=button type="reset" value="Réinitialiser">
        
        </form>
        <br><a href="./index.php?action=connexion"><button class="button">Déjà inscrit(e), connectez-vous</button</a></div>';


        }
        return $html;
    }
}