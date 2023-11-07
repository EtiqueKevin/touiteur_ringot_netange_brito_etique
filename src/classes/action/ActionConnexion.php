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
        $html= '<form method="post"><table>';
        $html.= em_aff_ligne_input( 'Votre pseudo :', array('type' => 'text', 'name' => 'pseudo', 'value' => '', 'required' => null));
        $html.= em_aff_ligne_input('Votre mot de passe :', array('type' => 'password', 'name' => 'pass1', 'value' => '', 'required' => null));

        $html.= '<tr>
				<td colspan="2" > <input  type="submit" name="btnConnexion" value="Connexion" /></td>
			</tr>
			</tbody>
		</table>
		</form>
		<p>Pas encore de compte?<a href="./index.php?action=inscription"> Inscrivez-vous</a> sans tarder!<br>';
        return $html;
    }

}