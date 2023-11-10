<?php

use touiteur\renderer\UtilisateurRenderer;
use touiteur\utilisateur\Utilisateur;

require_once 'vendor/autoload.php';

$u1 = new Utilisateur("toto", "toto@mail.com", 1234);

$renderu1 = new UtilisateurRenderer($u1);

echo $renderu1->render(1);

?>
