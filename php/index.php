<?php

include_once('bibli_generale.php');
include_once('bibli_cuiteur.php');


em_aff_debut('Cuiteur | Index', '../styles/cuiteur.css');



em_aff_entete(em_html_proteger_sortie('Connectez-vous'));
em_aff_infos(false);

$tab = cb_traitement_connexion();

cb_aff_formulaire($tab);


echo ' Pour vous connecter, il faut vous identifier:';
echo '<form method="post">
		<table>';
			em_aff_ligne_input( 'Votre pseudo :', array('type' => 'text', 'name' => 'pseudo', 'value' => '', 'required' => null));
			 em_aff_ligne_input('Votre mot de passe :', array('type' => 'password', 'name' => 'pass1', 'value' => '', 'required' => null));
			
			echo'<tr>
				<td colspan="2" > <input class="taille2" type="submit" name="btnConnexion" value="Connexion" /></td>
			</tr>
			</tbody>
		</table>
		</form>
		<p class="texte">Pas encore de compte?<a href="./inscription.php"> Inscrivez-vous</a> sans tarder!<br>
		Vous hésitez à vous inscrire? Laissez-vous séduire par une <a href="../html/presentation.html">présentation</a> des possibilitées de Cuiteur.</p>';
		

em_aff_pied();
em_aff_fin();

function cb_traitement_connexion():array{

	$V=em_bd_connect();
	if(isset($_POST['btnConnexion'])){
		$y = array('btnConnexion','pseudo','pass1');
		
		if(! em_parametres_controle('post',$y)){
			echo 'BOOM !!!';
		
		}
		$Errs = array();
		
		
		/*Vérification la connexion*/
		$pseudo = trim($_POST['pseudo']);
		$noTags = strip_tags($pseudo);
		if ($pseudo != $noTags){
			$Errs['Pseudo'] = 'La zone Votre pseudo ne peut pas contenir du cade HTML';
			header("Location: http://cuiteur.com/index.html?pseudo=mauvais");
			exit;
		}elseif (! preg_match('/^[a-zA-Z][a-zA-Z\' -]{3,31}$/', $pseudo)){
			$Errs['Pseudo'] = 'Le pseudo ne doit contenir que des caractères alphanumériques.';
		}
		
		$pwd = trim($_POST['pass1']);
		$noTags = strip_tags($pwd);
		$nb = strlen($pwd);
		if ($pwd != $noTags){
			$Errs['pwd'] = 'La zone Votre pseudo ne peut pas contenir du cade HTML';
			header("Location: http://cuiteur.com/index.html?code=mauvais");
			exit;
		}
		
		$pass = password_hash($pwd,PASSWORD_DEFAULT);
		$test = "SELECT usPasse
				FROM users
				WHERE usPseudo = '{$pseudo}'";
				
		$r = mysqli_query($V, $test);
		
		$T= mysqli_fetch_assoc($r);
		if(password_verify($pwd, $T['usPasse']) === true){
			header("Location: http://cuiteur.com/php/cuiteur.php?pseudo=$pseudo");
		}/*else{				
			header("Location: http://cuiteur.com/index.html?pwd=incorecte");
		}*/
		
			
		
	}
	
	if(empty($Errs)){
		$Errs = array();
	}
	return $Errs;
		

}

function cb_aff_formulaire(array $tab){
	
	/*Affichage des erreurs de saisi*/
	if(! empty($tab)){
		echo '<ul class="info"> Les erreurs suivantes ont été détectées:';
		foreach ($tab as $val){
			echo '<pre> -', print_r($val, true),'</pre>';
		
	}
	echo '</ul>';
	}
}
?>
