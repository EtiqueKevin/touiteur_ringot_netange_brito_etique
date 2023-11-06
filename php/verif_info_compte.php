<?php
include_once('bibli_generale.php');
include_once('bibli_cuiteur.php');

function cb_traitement_compte():array{
	$V=em_bd_connect();
	if(isset($_POST['btnValider1'])){
		$y = array('btnValider1','ville','bio');
		$f = array('nom','naissance');
		if(! em_parametres_controle('post',$y,$f)){
			echo 'BOOM !!!';
		
		}
		$Errs = array();
		
		/*Verification de la ville*/
		$ville = trim($_POST['ville']);
		$noTags = strip_tags($ville);
		if ($ville != $noTags){
			$Errs['Ville'] = 'La zone Votre pseudo ne peut pas contenir du cade HTML';
			header("Location: http://cuiteur.com/index.html");
			exit;
		}elseif (! preg_match('/^[a-zA-Z][a-zA-Z\' -]{3,31}$/', $ville)){
			$Errs['Ville'] = 'Le pseudo ne doit contenir que des caractères alphanumériques.';
		}
		
		/*Verification nom prenom*/
		$nom = trim($_POST['nom']);
		$noTags2 = strip_tags($nom);
		
		if ($nom != $noTags2){
			$Errs['nom'] = 'La zone nom prenom ne peut pas contenir du cade HTML';
			header("Location: http://cuiteur.com/index.html");
			exit;
		}elseif (! preg_match('/^[a-zA-Z][a-zA-Z\' -]{3,61}$/', $nom)){
			$Errs['nom'] = 'La zone nom prenom n\'est pas valide';
		}
		echo $nom;
		/*Verification de la bio*/
		$bio = $_POST['bio'];
		$noTags2 = strip_tags($bio);
		
		if ($bio != $noTags2){
			$Errs['bio'] = 'La zone bio ne peut pas contenir du cade HTML';
			header("Location: http://cuiteur.com/index.html");
			exit;
		}
		/*Verification de la date de naissance*/
		$date = $_POST['naissance'];
		$date = str_replace('-','',$date);
		$J = $date%100;
		$M = (($date-$J)/100)%100;
		$Y = ($date-($date%10000))/10000;
		if(!checkdate($M, $J, $Y)){
			$Errs['dateNaissance'] = 'La date n\'es pas valide.';
		}
		$anneeCourante = date("Y"); 
		$age = $anneeCourante - $Y;
		if( $age < 18 || $age > 120){
			$Errs['age'] = 'Vous devez avoir au moins 18 ans pour vous inscrire.';
		}
		
		$test = "SELECT *
				FROM users
				WHERE usNom = '$nom'";
					
		$r = mysqli_query($V, $test);
		
		while($T= mysqli_fetch_assoc($r)){
			$id = $T['usID'];
			$pseudo = $T['usPseudo'];
			
				$R = "UPDATE users
				SET 
				usNom = '$nom',
				usVille = '$ville',
				usBio = '$bio',
				usDateNaissance = '$date'
				WHERE usID=$id";
				
				$C=mysqli_query($V, $R);
					
				header('Location: http://cuiteur.com/php/cuiteur.php?pseudo='.$pseudo);
			
		}
	}
/***********************************************************************************************/
	if(isset($_POST['btnValider2'])){
		$y2 = array('btnValider2','email','web');
		$f2 = array('nom');
		
		if(! em_parametres_controle('post',$y2,$f2)){
			echo 'BOOM !!!';
		
		}
		$Errs = array();
		/*Verification du mail*/
		$mail = $_POST['email'];
		if(! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$Errs['email'] = 'L\'adresse email n\'est pas valide';
		}
		/*Verification du site web*/
		$web = trim($_POST['web']);
		
		if (filter_var($web,FILTER_VALIDATE_URL) == false){
			$Errs['web'] = 'La zone Votre pseudo ne peut pas contenir du cade HTML';
			echo var_dump($web);
			header("Location: http://cuiteur.com/index.html");
			exit;
		}
		$pseudo = $_GET['pseudo'];
		$nom = $_POST['nom'];
		$test = "SELECT *
				FROM users
				WHERE usNom = '$nom'";
					
		$r = mysqli_query($V, $test);
		
		while($T= mysqli_fetch_assoc($r)){
			$id = $T['usID'];
			$pseudo = $T['usPseudo'];
			
				$R = "UPDATE users
				SET 
				usMail = '$mail',
				usWeb = '$web'
				WHERE usID=$id";
				
				$C=mysqli_query($V, $R);
					
				header('Location: http://cuiteur.com/php/cuiteur.php?pseudo='.$pseudo);
			
		}
	}
/***********************************************************************************************/
		/*Verification du mot de pass*/
		/*$pwd = trim($_POST['pass1']);
		$noTags = strip_tags($pwd);
		$nb = strlen($pwd);
		$pass = null;
		if($nb > 0){
			if ($pwd != $noTags){
				$Errs['pwd'] = 'La zone Votre pseudo ne peut pas contenir du cade HTML';
				header("Location: http://cuiteur.com/index.html?pwd=FF");
				exit;
			}
			if($nb < 4 || $nb > 20){
				$Errs ['password'] = 'Le mot de passe doit contitué de 4 à 20 caractères.';
			}
			$pwd2 = trim($_POST['pass2']);
			$noTags = strip_tags($pwd2);
			if ($pwd2 != $noTags){
				$Errs['pwd'] = 'La zone Votre pseudo ne peut pas contenir du cade HTML';
				header("Location: http://cuiteur.com/index.html?pwd=FF");
				exit;
			}
			if( $pwd != $pwd2 ){
				$Errs['confPassword'] = 'Les mots de passe doivent être identique.';
			}else{
				$pass = password_hash($pwd2,PASSWORD_DEFAULT);
			}
		}
		*/
		
		
		
		/*Verification de la date de naissance*/
		/*$date = $_POST['naissance'];
		$date = str_replace('-','',$date);
		$J = $date%100;
		$M = (($date-$J)/100)%100;
		$Y = ($date-($date%10000))/10000;
		if(!checkdate($M, $J, $Y)){
			$Errs['dateNaissance'] = 'La date n\'es pas valide.';
		}
		$anneeCourante = date("Y"); 
		$age = $anneeCourante - $Y;
		if( $age < 18 || $age > 120){
			$Errs['age'] = 'Vous devez avoir au moins 18 ans pour vous inscrire.';
		}
		
		
		$utilphoto = $_POST['Utilphoto'];
			$dateJour = date("Ymd");
			
			
			$test = "SELECT *
					FROM users
					WHERE usNom = '$nom'";
					
			$r = mysqli_query($V, $test);
			$nber = 0;
			while($T= mysqli_fetch_assoc($r)){
				if($T['usNom'] == $nom && $pass == null){
					$R = "UPDATE users
					SET 
					usNom = REPLACE(usNom,{$T['usNom']},$nom),
					usVille = REPLACE(usVille,{$T['usVille']},$ville),
					usWeb = REPLACE(usWEB,{$T['usWeb']},$web),
					usMail = REPLACE(usMail,{$T['usMail']},$mail),
					
					usBio = REPLACE(usBio,{$T['usBio']},$bio),
					usDateNaissance = REPLACE(usDateNaissance,{$T['usDateNaissance']},$date),
					usAvecPhoto = REPLACE(usAvecPhoto,{$T['usAvecPhoto']},$utilphoto)";
					
					$C=mysqli_query($V, $R);
					
					header("Location: http://cuiteur.com/cuiteur.php");
				}else{
					$R = "UPDATE users
					SET 
					usNom = REPLACE(usNom','{$T['usNom']}','$nom'),
					usVille = REPLACE(usVille','{$T['usVille']}','$ville'),
					usWeb = REPLACE(usWeb','{$T['usWeb']}','$web'),
					usMail = REPLACE(usMail','{$T['usMail']}','$mail'),
					usPasse = REPLACE(usPasse','{$T['usPasse']}','$pass'),
					usBio = REPLACE(usBio','{$T['usBio']}','$bio'),
					usDateNaissance = REPLACE(usDateNaissance','{$T['usDateNaissance']}','$date'),
					usAvecPhoto = REPLACE(usAvecPhoto','{$T['usAvecPhoto']}','$utilphoto')";
					
					$C=mysqli_query($V, $R);
					
					header("Location: http://cuiteur.com/cuiteur.php");
				
				}
				
			}
			
				
			
		}*/

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
