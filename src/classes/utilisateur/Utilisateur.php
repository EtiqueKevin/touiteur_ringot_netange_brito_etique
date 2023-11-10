<?php

namespace touiteur\utilisateur;

use touiteur\DataBase\ConnectionFactory;
use touiteur\exception\InvalidPropertyValueException;

class Utilisateur{

    private string $pseudo;
    private string $email;
    private string $mdp;
    private string $photo;
    private string $bio;
    private string $role;

    public function __construct(string $pseudo, string $email, string $mdp, string $role,string $photo ="ressources/Z.png", string $bio="Exprimez-vous"){
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->mdp = $mdp;
        $this->role = $role;
        $this->photo = $photo;
        $this->bio = $bio;
    }

    public function __get($property): mixed{
        if ($property === 'pseudo' || $property === 'email' || $property === 'mdp' || $property === 'photo' || $property === 'bio') {
            return $this->$property;
        }else
        {
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
    public static function hasLiked($email, $idTouite): bool{
        $booleen = true;
        $bd = ConnectionFactory::makeConnection();
        $query = 'SELECT * FROM HasLiked WHERE email = ? AND idTouite = ?';
        $st = $bd->prepare($query);
        $st->bindParam(1, $email);
        $st->bindParam(2, $idTouite);
        $st->execute();

        return $st->fetch() !==  false;
    }

    public static function getFollower($email){
        $bd = ConnectionFactory::makeConnection();
        $query = 'SELECT count(*) FROM FollowUser WHERE emailFollowed = ?';
        $st = $bd->prepare($query);
        $st->bindParam(1, $email);
        $st->execute();
        $result = $st->fetch();
        return $result['count(*)'];
    }

    public static function hasFollow($emailFollower, $emailFollowed): bool{
        $bd = ConnectionFactory::makeConnection();
        $query = 'SELECT * FROM FollowUser WHERE emailFollower = ? AND emailFollowed = ?';
        $st = $bd->prepare($query);
        $st->bindParam(1, $emailFollower);
        $st->bindParam(2, $emailFollowed);
        $st->execute();
        return $st->fetch() !==  false;
    }

    public function afficherFollowers(){
        $bd = ConnectionFactory::makeConnection();
        $query = 'SELECT * FROM Utilisateur INNER JOIN FollowUser on Utilisateur.email = FollowUser.email WHERE email = ?';
        $st = $bd->prepare($query);
        $st->bindParam(1, $this->email);
        $st->execute();
        $html = '';
        foreach ($st->fetch() as $follower) {
        }
    }
    public static function hasFollowTag($emailFollower, $idTag){
        $bd = ConnectionFactory::makeConnection();
        $query = 'SELECT * FROM FollowTag WHERE email = ? AND idTag = ?';
        $st = $bd->prepare($query);
        $st->bindParam(1, $emailFollower);
        $st->bindParam(2, $idTag);
        $st->execute();
        return $st->fetch() !==  false;
    }
}