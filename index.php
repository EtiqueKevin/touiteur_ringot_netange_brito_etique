<?php

use touiteur\action\ActionConnexion;
use touiteur\action\ActionInscription;
use touiteur\dispatch\Dispatcher;

require_once 'vendor/autoload.php';
require_once 'src/classes/action/lib_touiteur.php';

$dispatcher = new Dispatcher();
$dispatcher->run();


