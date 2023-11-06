<?php

use touiteur\touites\Touite;
use touiteur\touites\ListeTouite;
use touiteur\renderer\ListeTouitesRenderer;

require_once 'vendor/autoload.php';

$t1 = new Touite(1, "Hello World!", "2023-01-01", "Brito");
$t2 = new Touite(2, "Hello YOU", "2077-05-05", "Clement");
$t3 = new Touite(3, "Hello EARTH!", "2022-09-09", "KEKE");
$t4 = new Touite(4, "Hello MARS!", "2022-10-10", "Mathias");

$listeTouite = new ListeTouite();
$listeTouite->addTouite($t1);
$listeTouite->addTouite($t2);
$listeTouite->addTouite($t3);
$listeTouite->addTouite($t4);

$listeTouiteRenderer = new ListeTouitesRenderer($listeTouite);

echo $listeTouiteRenderer->render(1);

?>
