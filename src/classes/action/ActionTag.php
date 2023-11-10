<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;

class ActionTag extends Action
{

    public function execute(): string
    {
        $idTag = $_GET['idTag'];
        $db = ConnectionFactory::makeConnection();
        $query = 'SELECT * FROM Tag WHERE id = ?';
        $st = $db->prepare($query);
        $st->bindParam(1, $idTag);
        $st->execute();
        $result = $st->fetch();
        $tag = new Tag($result['id'], $result['nom']);
        return (new TagRenderer($tag))->render(1);
    }
}