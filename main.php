<?php

use touiteur\action\ActionConnexion;
use touiteur\touites\Touite;
use touiteur\touites\ListeTouite;
use touiteur\renderer\ListeTouitesRenderer;
use touiteur\renderer\TouiteRenderer;
use touiteur\utilisateur\Utilisateur;
use touiteur\renderer\UtilisateurRenderer;

require_once 'vendor/autoload.php';
require_once 'src/classes/action/lib_touiteur.php';

$u1 = new Utilisateur("toto", "toto@mail.com", 1234);

$renderu1 = new UtilisateurRenderer($u1);

echo $renderu1->render(1);

?>
