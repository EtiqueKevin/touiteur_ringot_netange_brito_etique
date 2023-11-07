<?php

namespace touiteur\touites;

use touiteur\exception\InvalidPropertyNameException;
use touiteur\exception\InvalidPropertyValueException;

class Touite{
    private $id;
    private $texte;
    private $date;
    private $auteur;

    private $likes;

    private $dislikes;

    private $tag;

    public function __construct(int $id, string $texte, string $date, string $auteur)
    {
        $this->id = $id;
        $this->texte = $texte;
        $this->date = $date;
        $this->auteur = $auteur;
        $this->likes = 0;
        $this->dislikes = 0;
    }

    public function like(): void{
        $this->likes++;
    }

    public function dislike(): void{
        $this->dislikes++;
    }

    public function __get($property): mixed{
        if ($property === 'id' || $property === 'texte' || $property === 'date' || $property === 'auteur'|| $property === 'likes' || $property === 'dislikes') {
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
}