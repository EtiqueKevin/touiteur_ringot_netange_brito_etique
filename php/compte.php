<?php
include_once('bibli_generale.php');
include_once('bibli_cuiteur.php');
include_once('verif_info_compte.php');


em_aff_debut('Cuiteur | Compte', '../styles/cuiteur.css');


em_aff_entete(em_html_proteger_sortie('Paramètres de mon compte'));


cb_info();
$tab = cb_traitement_compte();
echo'<main>';
cb_compte();
cb_aff_formulaire($tab);

em_aff_pied();
em_aff_fin();

function cb_compte(){
$V=em_bd_connect();
	$S = "SELECT *
		FROM users 
		WHERE usPseudo = '{$_GET['pseudo']}'
		";
	$r=em_bd_send_request($V, $S);
	$info = mysqli_fetch_assoc($r);
	echo 
	'Cette page vous permet de modifier les informations relatives à votre compte.
	
	
	
	<form method="post">
		<h5>Informations personnelles</h5>
		<table >',
			
			em_aff_ligne_input( 'Nom', array('type' => 'text', 'name' => 'nom', 'value' => $info['usNom'],'required' => null)),
			em_aff_ligne_input( 'Date de naissance', array('type' => 'date', 'name' => 'naissance', 'value' => cb_date($info['usDateNaissance']),'required' => null)),
			em_aff_ligne_input( 'Ville', array('type' => 'text', 'name' => 'ville', 'value' => $info['usVille'],'required' => null)),
			em_aff_ligne_input( 'Mini-bio', array('type' => 'textarea', 'name' => 'bio', 'value' => $info['usBio'],'required' => null)),
			
			'<tr>
				<td colspan="2" > <input  type="submit" name="btnValider1" value="Valider" /></td>
			</tr>
		</table>
	';
		
	echo'
	<h5>Informations sur votre compte Cuiteur</h5>
		<table>',
			
			em_aff_ligne_input('Adresse email ', array('type' => 'email', 'name' => 'email', 'value' => $info['usMail'], 'required' => null)),
			em_aff_ligne_input('Web ', array('type' => 'web', 'name' => 'web', 'value' => $info['usWeb'], 'required' => null)),
			'<tr>
				<td colspan="2"> <input  type="submit" name="btnValider2" value="Valider" /></td>
			</tr>
		</table>
		';
		
	echo'
	<h5>Paramètres de votre compte Cuiteur</h5>
		<table>
			<tr>
				<td > <label for="pass1">Changer le mot de passe</label></td>
				<td > <input type="password" name="pass1" value=""/></td>
			</tr>
			<tr>
				<td > <label for="pass2">Répéter le mot de passe</label></td>
				<td > <input  type="password" name="pass2" value=""/></td>
			</tr>
			<tr>
				<td > <label for="photo">Votre photo actuel</label></td>
				<td > <input  type="file" name="photo" accept="image/jpg"/></td>
			</tr>',
			cb_photo(),
			'<tr>
				<td colspan="2"> <input  type="submit" name="btnValider3" value="Valider" /></td>
			</tr>
		</table>
		</form>';
	
	


}



function cb_info(){
	$V=em_bd_connect();
	$S = "SELECT usPseudo, usNom, usID, usAvecPhoto
		FROM users 
		WHERE usPseudo = '{$_GET['pseudo']}'
		";
	$r=em_bd_send_request($V, $S);
	$info = mysqli_fetch_assoc($r);
	if($info['usAvecPhoto'] == 0){
		echo'<aside>
		<h3>Utilisateur</h3>
		<ul>
		        <li>
		            <img src="../images/anonyme.jpg" "alt="photo de l\'utilisateur">
		            <a href="../index.html" title="Voir mes infos">',"{$info['usPseudo']}</a>", " {$info['usNom']}",'
		        </li>
		        <li><a href="../index.html" title="Voir la liste de mes messages">100 blablas</a></li>
		        <li><a href="../index.html" title="Voir les personnes que je suis">123 abonnements</a></li>
		        <li><a href="../index.html" title="Voir les personnes qui me suivent">34 abonnés</a></li>                    
		    </ul>
		    <h3>Tendances</h3>
		    <ul>
		        <li>#<a href="../index.html" title="Voir les blablas contenant ce tag">info</a></li>
		        <li>#<a href="../index.html" title="Voir les blablas contenant ce tag">lol</a></li>
		        <li>#<a href="../index.html" title="Voir les blablas contenant ce tag">imbécile</a></li>
		        <li>#<a href="../index.html" title="Voir les blablas contenant ce tag">fairelafete</a></li> 
		        <li><a href="../index.html">Toutes les tendances</a><li>
		    </ul>
		    <h3>Suggestions</h3>                
		    <ul>
		        <li>
		            <img src="../images/yoda.jpg" alt="photo de l\'utilisateur">
		            <a href="../index.html" title="Voir mes infos">yoda</a> Yoda
		        </li>       
		        <li>
		            <img src="../images/paulo.jpg" alt="photo de l\'utilisateur">
		            <a href="../index.html" title="Voir mes infos">paulo</a> Jean-Paul Sartre
		        </li>
		        <li><a href="../index.html">Plus de suggestions</a></li>
		    </ul>               
		</aside>';
	}else{
		echo'<aside>
		<ul>
		        <li>
		            <img src="../upload/',$info['usID'],'.jpg" "alt="photo de l\'utilisateur">
		            <a href="../index.html" title="Voir mes infos">',"{$info['usPseudo']}</a>", " {$info['usNom']}",'
		        </li>
		        <li><a href="../index.html" title="Voir la liste de mes messages">100 blablas</a></li>
		        <li><a href="../index.html" title="Voir les personnes que je suis">123 abonnements</a></li>
		        <li><a href="../index.html" title="Voir les personnes qui me suivent">34 abonnés</a></li>                    
		    </ul>
		    <h3>Tendances</h3>
		    <ul>
		        <li>#<a href="../index.html" title="Voir les blablas contenant ce tag">info</a></li>
		        <li>#<a href="../index.html" title="Voir les blablas contenant ce tag">lol</a></li>
		        <li>#<a href="../index.html" title="Voir les blablas contenant ce tag">imbécile</a></li>
		        <li>#<a href="../index.html" title="Voir les blablas contenant ce tag">fairelafete</a></li> 
		        <li><a href="../index.html">Toutes les tendances</a><li>
		    </ul>
		    <h3>Suggestions</h3>                
		    <ul>
		        <li>
		            <img src="../upload/5.jpg" alt="photo de l\'utilisateur">
		            <a href="../index.html" title="Voir mes infos">yoda</a> Yoda
		        </li>       
		        <li>
		            <img src="../images/paulo.jpg" alt="photo de l\'utilisateur">
		            <a href="../index.html" title="Voir mes infos">paulo</a> Jean-Paul Sartre
		        </li>
		        <li><a href="../index.html">Plus de suggestions</a></li>
		    </ul>               
		</aside>';
	
	}
}

function cb_photo(){
	$V=em_bd_connect();
	$S = "SELECT  usAvecPhoto
		FROM users 
		WHERE usPseudo = '{$_GET['pseudo']}'
		";
	$r=em_bd_send_request($V, $S);
	$info = mysqli_fetch_assoc($r);
	if($info['usAvecPhoto'] == 0){
		echo '<tr>
			<td > <label for="Utilphoto">Utiliser votre photo</label></td>
			<td > <input type="radio" name="Utilphoto" value="0" checked/>non
			  	<input type="radio" name="Utilphoto" value="1"/>oui</td>
		</tr>';
	}else{
		echo '<tr>
			<td > <label for="Utilphoto">Utiliser votre photo</label></td>
			<td > <input type="radio" name="Utilphoto" value="0"/>non
				  <input type="radio" name="Utilphoto" value="1" checked/>oui</td>
		</tr>';
	}


}

?>
