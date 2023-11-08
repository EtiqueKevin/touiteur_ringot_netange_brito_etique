<?php

session_start();
use touiteur\action\ActionConnexion;
use touiteur\action\ActionInscription;
use touiteur\dispatch\Dispatcher;
use touiteur\DataBase\ConnectionFactory;

require_once 'vendor/autoload.php';
require_once 'src/classes/action/lib_touiteur.php';

ConnectionFactory::setConfig("conf/config.ini");

$dispatcher = new Dispatcher();
$dispatcher->run();


