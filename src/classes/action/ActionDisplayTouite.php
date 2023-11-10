<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;
use touiteur\renderer\TouiteRenderer;
use touiteur\touites\Touite;

class ActionDisplayTouite extends Action
{

    public function execute(): string
    {


        $id = filter_var( $_GET['idTouite'], FILTER_SANITIZE_NUMBER_INT);
        $db = ConnectionFactory::makeConnection();
        $query = 'SELECT * FROM Touite WHERE id = ?';
        $st = $db->prepare($query);
        $st->bindParam(1, $id);
        $st->execute();
        $result = $st->fetch();
        $touite = new Touite($result['id'], $result['text'], $result['date'], $result['author'], $result['img']);
        return (new TouiteRenderer($touite))->render(3);
    }
}