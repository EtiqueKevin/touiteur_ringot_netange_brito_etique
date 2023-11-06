<?php
include_once('bibli_generale.php');
include_once('bibli_cuiteur.php');

function cb_traitement_connexion():array{

	$V=cb_bd_connect();
	if(isset($_POST['btnConnexion'])){
		$y = array('btnSInscrire','pseudo','pass1','pass2','nomprenom','email','naissance');
		
		if(! cb_parametres_controle('post',$y)){
			echo 'BOOM !!!';
		
		}
		$Errs = array();
		
		
		/*Vérification la connexion*/
		$pseudo = trim($_POST['pseudo']);
		$noTags = strip_tags($pseudo);
		if ($pseudo != $noTags){
			$Errs['Pseudo'] = 'La zone Votre pseudo ne peut pas contenir du cade HTML';
			header("Location: http://cuiteur.com/index.html");
			exit;
		}elseif (! preg_match('/^[a-zA-Z][a-zA-Z\' -]{3,31}$/', $pseudo)){
			$Errs['Pseudo'] = 'Le pseudo ne doit contenir que des caractères alphanumériques.';
		}
		
		$pwd = trim($_POST['pass1']);
		$noTags = strip_tags($pwd);
		$nb = strlen($pwd);
		if ($pwd != $noTags){
			$Errs['pwd'] = 'La zone Votre pseudo ne peut pas contenir du cade HTML';
			header("Location: http://cuiteur.com/index.html");
			exit;
		}
		
		$pass = password_hash($pwd1,PASSWORD_DEFAULT);
		$test = "SELECT usPass
				FROM users
				WHERE usPseudo = $pseudo";
				
		$r = mysqli_query($V, $test);
		$nber = 0;
		$T= mysqli_fetch_assoc($r);
		
		if(password_verify($pwd, $T['usPasse']) == true){
			header("Location: http://cuiteur.com/presentation_3.html");
		}else{
			header("Location: http://cuiteur.com/index.html");
		}
			
			
		
	}
	
	if(empty($Errs)){
		$Errs = array();
	}
	return $Errs;
		

}

?>
