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
        $query = 'SELECT * FROM Touite WHERE id = ?';
        $st = $db->prepare($query);
        $st->bindParam(1, $id);
        $st->execute();
        $result = $st->fetch();
        //on recupere le pseudo
        $sql = 'SELECT * FROM Utilisateur WHERE email = ?';
        $st = $db->prepare($sql);
        $st->bindParam(1, $result['author']);
        $st->execute();
        $row = $st->fetch();
        //on cree un objet touite avec le resultat de la requete
        $touite = new Touite($result['id'], $result['text'], $result['date'], $row['pseudo'], $result['img']);
        //on retourne le rendu du touite avec un renderer
        return (new TouiteRenderer($touite))->render(3);
    }
}