<?php

namespace touiteur\utilisateur;

use touiteur\DataBase\ConnectionFactory;
use touiteur\exception\InvalidPropertyValueException;

/**
 *
 */
class Utilisateur
{

    /**
     * @var string
     */
    private string $pseudo;
    /**
     * @var string
     */
    private string $email;
    /**
     * @var string
     */
    private string $mdp;
    /**
     * @var string
     */
    private string $photo;
    /**
     * @var string
     */
    private string $bio;
    /**
     * @var string
     */
    private string $role;

    /**
     * @param string $pseudo
     * @param string $email
     * @param string $mdp
     * @param string $role
     * @param string $photo
     * @param string $bio
     */
    public function __construct(string $pseudo, string $email, string $mdp, string $role, string $photo = "ressources/Z.png", string $bio = "Exprimez-vous"){
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->mdp = $mdp;
        $this->role = $role;
        $this->photo = $photo;
        $this->bio = $bio;
    }

    /**
     * vérifie si l'utilisateur a déjà liké le touite
     *
     * @param $email
     * @param $idTouite
     * @return bool
     */
    public static function hasLiked($email, $idTouite): bool{
        $booleen = true;
        $bd = ConnectionFactory::makeConnection();
        $query = 'SELECT * FROM HasLiked WHERE email = ? AND idTouite = ?';
        $st = $bd->prepare($query);
        $st->bindParam(1, $email);
        $st->bindParam(2, $idTouite);
        $st->execute();

        return $st->fetch() !== false;
    }

    /**
     *  retourne les utilisateurs qui suivent l'utilisateur
     *
     * @param $email
     * @return mixed
     */
    public static function getFollower($email){
        $bd = ConnectionFactory::makeConnection();
        $query = 'SELECT count(*) FROM FollowUser WHERE emailFollowed = ?';
        $st = $bd->prepare($query);
        $st->bindParam(1, $email);
        $st->execute();
        $result = $st->fetch();
        return $result['count(*)'];
    }

    /**
     * vérifie si l'utilisateur suit un autre utilisateur
     *
     * @param $emailFollower
     * @param $emailFollowed
     * @return bool
     */
    public static function hasFollow($emailFollower, $emailFollowed): bool{
        $bd = ConnectionFactory::makeConnection();
        $query = 'SELECT * FROM FollowUser WHERE emailFollower = ? AND emailFollowed = ?';
        $st = $bd->prepare($query);
        $st->bindParam(1, $emailFollower);
        $st->bindParam(2, $emailFollowed);
        $st->execute();
        return $st->fetch() !== false;
    }

    /**
     * vérifie si l'utilisateur suit un tag
     *
     * @param $emailFollower
     * @param $idTag
     * @return bool
     */
    public static function hasFollowTag($emailFollower, $idTag){
        $bd = ConnectionFactory::makeConnection();
        $query = 'SELECT * FROM FollowTag WHERE email = ? AND idTag = ?';
        $st = $bd->prepare($query);
        $st->bindParam(1, $emailFollower);
        $st->bindParam(2, $idTag);
        $st->execute();
        return $st->fetch() !== false;
    }

    /**
     * getter
     *
     * @param $property
     * @return mixed
     * @throws InvalidPropertyValueException
     */
    public function __get($property): mixed{
        if ($property === 'pseudo' || $property === 'email' || $property === 'mdp' || $property === 'photo' || $property === 'bio' || $property === 'role') {
            return $this->$property;
        } else {
            throw new InvalidPropertyValueException("Property $property is not readable for a Utilisateur.");
        }
    }

    /**
     * setter
     *
     * @param $property
     * @param $value
     * @return void
     * @throws InvalidPropertyValueException
     */
    public function __set($property, $value): void{
        if ($property === 'pseudo' || $property === 'email' || $property === 'mdp' || $property === 'photo' || $property === 'bio') {
            $this->$property = $value;
        } else {
            throw new InvalidPropertyValueException("Property $property is not editable for a Utilisateur.");
        }
    }


    /**
     * affiche les utilisateurs qui suivent l'utilisateur
     *
     * @return void
     */
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
}