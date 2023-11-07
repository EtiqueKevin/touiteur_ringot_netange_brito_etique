<?php

namespace touiteur;

class Connexion{

    public static function aff_formulaire(){
        // réaffichage des données soumises en cas d'erreur, sauf les mots de passe
        if (isset($_POST['btnSInscrire'])){
            $values = em_html_proteger_sortie($_POST);
        }
        else{
            $values['pseudo'] = $values['nomprenom'] = $values['email'] = $values['naissance'] = '';
        }

        echo '<form method="post">
		<table>';
        em_aff_ligne_input( 'Votre pseudo :', array('type' => 'text', 'name' => 'pseudo', 'value' => '', 'required' => null));
        em_aff_ligne_input('Votre mot de passe :', array('type' => 'password', 'name' => 'pass1', 'value' => '', 'required' => null));

        echo'<tr>
				<td colspan="2" > <input  type="submit" name="btnConnexion" value="Connexion" /></td>
			</tr>
			</tbody>
		</table>
		</form>
		<p>Pas encore de compte?<a href="./index.php?action=inscription"> Inscrivez-vous</a> sans tarder!<br>';
    }

}