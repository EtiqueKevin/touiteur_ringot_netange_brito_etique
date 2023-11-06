<?php

namespace touiteur\auth;

use PDO;
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

        $query = 'SELECT * FROM `User` WHERE `email` = ?';
        $st = $bd->prepare($query);
        $st->bindParam(1, $email);
        $st->execute();


        if ($st->rowCount() == 1) {
            throw new AuthException("Un compte existe déjà avec cet identifiant.");
        }

        $passwd_hash = password_hash($passwd, PASSWORD_DEFAULT, ['cost' => 12]);
        $query = 'INSERT INTO `User` (`email`, `passwd`, `role`) VALUES (?, ?, 1)';
        $st = $bd->prepare($query);
        $st->bindParam(1, $email);
        $st->bindParam(2, $passwd_hash);
        $st->execute();
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


}
