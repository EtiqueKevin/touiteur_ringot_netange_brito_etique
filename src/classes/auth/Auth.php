<?php

namespace touiteur\auth;

use PDO;
use touiteur\DataBase\ConnectionFactory;
use User;
use touiteur\auth\AuthException;
class Auth {
    /**
     * @throws AuthException
     */
    public static function authenticate(string $email, string $passwd) :string{
        $bd = ConnectionFactory::makeConnection();

        $query = 'SELECT `passwd` FROM `User` WHERE `email` = ?';
        $st = $bd->prepare($query);
        $st->bindParam(1, $email);
        $st->execute();

        $user = $st->fetchColumn();
        if ($user === false) {
            throw new AuthException("Utilisateur non trouvé");
        }
        if (!password_verify($passwd, $user)) {

            throw new AuthException("Mot de passe incorrect");
        }
        else{
            return "Utilisateur trouvé";
        }

    }

    public static function register(string $email, string $passwd): void{
        $bd = ConnectionFactory::makeConnection();

        //Vérification si un pseudo existe deja
        $query = 'SELECT * FROM `User` WHERE `email` = ?';
        $st = $bd->prepare($query);
        $st->bindParam(1, $email);
        $st->execute();


        if ($st->rowCount() == 1) {
            throw new AuthException("Un compte existe déjà avec cet identifiant.");
        }

        $pseudoOK= self::checkPseudo($_POST['pseudo']);
        $pwdOK= self::checkPasswordStrength($_POST['passe1'], 10);
        $emailOK= self::checkEmail($_POST['email']);

        //Si tous est valide alors on enregistre dans la base de données
        if ($pwdOK && $pseudoOK && $emailOK){
            $passwd_hash = password_hash($passwd, PASSWORD_DEFAULT, ['cost' => 12]);
            $query = 'INSERT INTO `User` (`email`, `passwd`, `role`) VALUES (?, ?, 1)';
            $st = $bd->prepare($query);
            $st->bindParam(1, $email);
            $st->bindParam(2, $passwd_hash);
            $st->execute();
        }

    }

    public static function loadProfile(string $email): void{
        $bd = ConnectionFactory::makeConnection();

        $query = 'SELECT * FROM `User` WHERE `email` = ?';
        $st = $bd->prepare($query);
        $st->bindParam(1, $email);
        $st->execute();
        $st->setFetchMode(PDO::FETCH_ASSOC);

        $row = $st->fetch();
        $user = new User($row['email'], $row['passwd'], $row['role']);
        $_SESSION['user'] = serialize($user);
    }

    public static function checkAccess(string $role): void{
        if (!isset($_SESSION['user'])) {
            throw new AuthException("Vous devez être connecté pour accéder à cette page.");
        }
        $user = unserialize($_SESSION['user']);
        if ($user->role != $role) {
            throw new AuthException("Vous n'avez pas les droits pour accéder à cette page.");
        }
    }

    public static function checkAccountOwner(string $email): void{
        if (!isset($_SESSION['user'])) {
            throw new AuthException("Vous devez être connecté pour accéder à cette page.");
        }
        $user = unserialize($_SESSION['user']);
        if ($user->email != $email) {
            throw new AuthException("Vous n'avez pas les droits pour accéder à cette page.");
        }
    }

    public function checkPasswordStrength(string $pass, int $minimumLength): bool {

        $length = (strlen($pass) < $minimumLength); // longueur minimale
        $digit = preg_match("#[\d]#", $pass); // au moins un digit
        $special = preg_match("#[\W]#", $pass); // au moins un car. spécial
        $lower = preg_match("#[a-z]#", $pass); // au moins une minuscule
        $upper = preg_match("#[A-Z]#", $pass); // au moins une majuscule
        if (!$length || !$digit || !$special || !$lower || !$upper)return false;
        return true;
    }

    public function checkPseudo(string $pseudo): bool{
        //Vérification de la validité du pseudo
        $l = mb_strlen($_POST['pseudo'], 'UTF-8');
        if ($l < 4 || $l > 32 || !mb_ereg_match('^[[:alnum:]]{1,32}$', $pseudo)){
            return false;
        }
        return true;
    }

    public function checkEmail(string $email): bool{
        if (empty($email)){
            return false;
        }
        else {
            if (mb_strlen($email, 'UTF-8') > 80){
                return false;
            }
            // la validation faite par le navigateur en utilisant le type email pour l'élément HTML input
            // est moins forte que celle faite ci-dessous avec la fonction filter_var()
            // Exemple : 'l@i' passe la validation faite par le navigateur et ne passe pas
            // celle faite ci-dessous
            if(! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
        }
        return true;
    }


}
