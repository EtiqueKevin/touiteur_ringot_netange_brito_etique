<?php

namespace touiteur\utilisateur;

use touiteur\exception\InvalidPropertyValueException;

class Utilisateur{

    private string $pseudo;
    private string $email;
    private string $mdp;
    private string $photo;
    private string $bio;

    public function __construct(string $pseudo, string $email, string $mdp, string $photo ="ressources/Z.png", string $bio="Exprimez-vous"){
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->mdp = $mdp;
        $this->photo = $photo;
        $this->bio = $bio;
    }

    public function __get($property): mixed{
        if ($property === 'pseudo' || $property === 'email' || $property === 'mdp' || $property === 'photo' || $property === 'bio') {
            return $this->$property;
        } else {
            throw new InvalidPropertyValueException("Property $property is not readable for a Utilisateur.");
        }
    }

    public function __set($property, $value): void{
        if ($property === 'pseudo' || $property === 'email' || $property === 'mdp' || $property === 'photo' || $property === 'bio') {
            $this->$property = $value;
        } else {
            throw new InvalidPropertyValueException("Property $property is not editable for a Utilisateur.");
        }
    }


}