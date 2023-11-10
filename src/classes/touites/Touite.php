<?php

namespace touiteur\touites;

use touiteur\DataBase\ConnectionFactory;
use touiteur\exception\InvalidPropertyNameException;
use touiteur\exception\InvalidPropertyValueException;
use PDO;


class Touite{
    private $id;
    private $texte;
    private $date;
    private $auteur;

    private $likes;

    private $photo;

    public function __construct(int $id, string $texte, string $date, string $auteur, $photo  = null)
    {
        $this->id = $id;
        $this->texte = $texte;
        $this->date = $date;
        $this->auteur = $auteur;
        $this->likes = 0;
        $this->photo = $photo;
    }

    public static function like($id){
            $id = $_GET['id'];
            $bd = ConnectionFactory::makeConnection();
            $sql = "UPDATE touites SET likes = likes + 1 WHERE id = ?";
            $st = $bd->prepare($sql);
            $st->bindParam(1, $id);
            $st->execute();

    }

    public function __get($property): mixed{
        if ($property === 'id' || $property === 'texte' || $property === 'date' || $property === 'auteur'|| $property === 'likes' || $property === 'photo') {
            return $this->$property;
        } else {
            throw new InvalidPropertyValueException("Property $property is not readable for a Touite.");
        }
    }

    public function __set($property, $value): void{
        if ($property === 'texte' || $property === 'date' || $property === 'auteur') {
            $this->$property = $value;
        } else {
            throw new InvalidPropertyNameException("Property $property is not editable for a Touite.");
        }
    }


    /**
     * Transformation d'un date en clair.
     *
     * Aucune vérification n'est faite sur la validité de la date car
     * on considère que c'est bien une date valide sous la forme aaaammjj
     *
     *
     * @return string            La date sous la forme jj mois aaaa (1 janvier 2000)
     */
    public function aff_date():string{
        $mois = array('', ' janvier ', ' février ', ' mars ', ' avril ', ' mai ', ' juin',
            ' juillet ', ' aôut ', ' septembre ', ' octobre ', ' novembre ', ' décembre ');

        $jj = (int)substr($this->date, -2);
        $mm = (int)substr($this->date, -4, 2);

        return $jj.$mois[$mm].substr($this->date, 0, -4); //fonctionne même si l'année est inférieure à 1000

    }

    public static function getLikes($id){
        $bd = ConnectionFactory::makeConnection();
        $query = 'SELECT likes FROM Touite WHERE likes = ?';
        $st = $bd->prepare($query);
        $st->bindParam(1, $email);
        $st->execute();
        $result = $st->fetch();
        return $result === false ? 0 : $result['likes'];
    }
}
