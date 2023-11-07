<?php

use touiteur\action\ActionConnexion;
use touiteur\touites\Touite;
use touiteur\touites\ListeTouite;
use touiteur\renderer\ListeTouitesRenderer;

require_once 'vendor/autoload.php';
require_once 'src/classes/action/lib_touiteur.php';

$t1 = new Touite(1, "Hello World!", "20230101", "Brito");
$t2 = new Touite(2, "Hello YOU", "20770505", "Clement");
$t3 = new Touite(3, "Hello EARTH!", "20220909", "KEKE");
$t4 = new Touite(4, "Hello MARS!", "20221010", "Mathias");

$listeTouite = new ListeTouite();
$listeTouite->addTouite($t1);
$listeTouite->addTouite($t2);
$listeTouite->addTouite($t3);
$listeTouite->addTouite($t4);

$listeTouiteRenderer = new ListeTouitesRenderer($listeTouite);

$ac = new ActionConnexion();
echo $ac->execute();

echo $listeTouiteRenderer->render(1);

?>
