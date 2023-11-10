<?php

namespace touiteur\action;

use touiteur\DataBase\ConnectionFactory;
use touiteur\renderer\TouiteRenderer;
use touiteur\touites\Touite;

class ActionDisplayTouite extends Action
{

    public function execute(): string
    {

        //permet l'affichage en grand d'un seul touite
        //on recupere l'id du touite a afficher
        $id = filter_var( $_GET['idTouite'], FILTER_SANITIZE_NUMBER_INT);
        $db = ConnectionFactory::makeConnection();
        //on recupere le touite dans la base de donnee depuis son id
        $query = 'SELECT * FROM Touite WHERE id = ?';
        $st = $db->prepare($query);
        $st->bindParam(1, $id);
        $st->execute();
        $result = $st->fetch();
        //on cree un objet touite avec le resultat de la requete
        $touite = new Touite($result['id'], $result['text'], $result['date'], $result['author'], $result['img']);
        //on retourne le rendu du touite avec un renderer
        return (new TouiteRenderer($touite))->render(3);
    }
}