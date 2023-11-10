<?php

session_start();

use touiteur\DataBase\ConnectionFactory;
use touiteur\dispatch\Dispatcher;

require_once 'vendor/autoload.php';

ConnectionFactory::setConfig("conf/config.ini");

$dispatcher = new Dispatcher();
$dispatcher->run();


