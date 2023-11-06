<?php

include_once('bibli_generale.php');
include_once('bibli_cuiteur.php');



$s = "SELECT blID, blTexte, blDate, blHeure, usPseudo, usNom, usID, usAvecPhoto
	FROM users INNER JOIN blablas ON usID=blIDAuteur
	WHERE usPseudo = '{$_GET['pseudo']}'
	ORDER BY blID DESC";

$S2 = "SELECT usPseudo, usNom, usID, usAvecPhoto
	FROM users 
	WHERE usPseudo = '{$_GET['pseudo']}'
	";
	
	

$V=em_bd_connect();
$R=em_bd_send_request($V, $s);

$r2=em_bd_send_request($V, $S2);
$info = mysqli_fetch_assoc($r2);


$bool=true;

em_aff_debut('Cuiteur | Cuiteur', '../styles/cuiteur.css');

em_aff_entete(null);
/*echo '<form action="../index.html" method="POST">
            <textarea name="txtMessage"></textarea>
            <input type="submit" name="btnPublier" value="" title="Publier mon message">
        </form>';
   */     
//em_aff_infos();
cb_info();
echo'<main>';
while($T= mysqli_fetch_assoc($R)){
	
	if($bool == true){
		echo 
			
			'<ul id="bcMessages">';
		$bool = false;
	}
	if($info['usAvecPhoto'] == 0){
		echo 
			"<li>",
				'<img src="../images/anonyme.jpg','" class="imgAuteur" alt="photo de l\'auteur">',
				$T['usPseudo'],' ',$T['usNom'],'<br>',
		        $T['blTexte'],'<br>',
		        '<p class="finMessage">',em_amj_clair($T['blDate']),' à ',em_heure_clair($T['blHeure']),'<a href="../index.html">Répondre</a><a href="../index.html">Recuiter</a></p>',              
			"</li>";
		
	}else{
	echo 
		"<li>",
			'<img src="../upload/',$T['usID'],'.jpg','" class="imgAuteur" alt="photo de l\'auteur">',
			$T['usPseudo'],' ',$T['usNom'],'<br>',
		    $T['blTexte'],'<br>',
		    '<p class="finMessage">',em_amj_clair($T['blDate']),' à ',em_heure_clair($T['blHeure']),'<a href="../index.html">Répondre</a><a href="../index.html">Recuiter</a></p>',              
		"</li>";
	}
}
cb_message();
echo '</ul>
	 <img  src="../images/speaker.png" alt="speaker"><a class="speaker" href="">Plus de blablas</a></main>';

em_aff_pied();

em_aff_fin();

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
		<h3>Utilisateur</h3>
		<ul>
		        <li>
		            <img src="../upload/',"{$info['usID']}",'.jpg" "alt="photo de l\'utilisateur">
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
	
	}
}

function cb_message(){
	$V=em_bd_connect();
	if(isset($_POST['btnPublier'])){
		$y = array('btnPublier','txtMessage');
		
		if(! em_parametres_controle('post',$y)){
			echo 'BOOM !!!';
		
		}
		$Errs = array();
		$S = "SELECT usID, usPseudo
			FROM users 
			WHERE usPseudo = '{$_GET['pseudo']}'
			";
		$r=em_bd_send_request($V, $S);
		
		$blabla = trim($_POST['txtMessage']);
		$noTags2 = strip_tags($blabla);
		if ($blabla != $noTags2){
			$Errs['blabla'] = 'La zone bio ne peut pas contenir du cade HTML';
			header("Location: http://cuiteur.com/index.html?blabla=FF");
			exit;
		}
		while($T= mysqli_fetch_assoc($r)){
			$id = $T['usID'];
			$pseudo = $T['usPseudo'];
			$date = date("Ymd");
			$heure = date("h:m:s");
			
			$R = "INSERT INTO blablas (blIDAuteur, blDate, blHeure, blTexte, blIDAutOrig)
				VALUES 
				('$id', '$date', '$heure', '$blabla', '$id')";
					
			$C=mysqli_query($V, $R);
						
			header('Location: http://cuiteur.com/php/cuiteur.php?pseudo='.$pseudo);
				
		}
	}

}
?>
