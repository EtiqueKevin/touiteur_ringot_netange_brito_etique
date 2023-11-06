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

}