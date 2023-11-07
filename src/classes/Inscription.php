<?php

namespace touiteur;

class Inscription {

    public static function aff_formulaire(){

        // réaffichage des données soumises en cas d'erreur, sauf les mots de passe
        if (isset($_POST['btnSInscrire'])){
            $values = em_html_proteger_sortie($_POST);
        }
        else{
            $values['pseudo'] = $values['nomprenom'] = $values['email'] = $values['naissance'] = '';
        }

        echo '<aside class="form">',
        '<p>Pour vous inscrire, merci de fournir les informations suivantes. </p>',
        '<form method="post" action="inscription.php">',
        '<table>';

        em_aff_ligne_input('Votre pseudo :', array('type' => 'text', 'name' => 'pseudo', 'value' => $values['pseudo'],
            'placeholder' => 'Minimum 4 caractères alphanumériques', 'required' => null));
        em_aff_ligne_input('Votre mot de passe :', array('type' => 'password', 'name' => 'passe1', 'value' => '', 'required' => null));
        em_aff_ligne_input('Répétez le mot de passe :', array('type' => 'password', 'name' => 'passe2', 'value' => '', 'required' => null));
        em_aff_ligne_input('Nom et prénom :', array('type' => 'text', 'name' => 'nomprenom', 'value' => $values['nomprenom'], 'required' => null));
        em_aff_ligne_input('Votre adresse email :', array('type' => 'email', 'name' => 'email', 'value' => $values['email'], 'required' => null));
        em_aff_ligne_input('Votre date de naissance :', array('type' => 'date', 'name' => 'naissance', 'value' => $values['naissance'], 'required' => null));

        echo
        '<tr>',
        '<td colspan="2">',
        '<input type="submit" name="btnSInscrire" value="S\'inscrire">',
        '<input type="reset" value="Réinitialiser">',
        '</td>',
        '</tr>',
        '</table>',
        '</form>',
        '<br>Déjà inscrit(e),<a href="./index.php?action=connexion"> connectez-vous</a>.</aside>';
    }
}