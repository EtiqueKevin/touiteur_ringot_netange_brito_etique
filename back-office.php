<?php

session_start();

ConnectionFactory::setConfig("conf/config.ini");
$bdd = \iutnc\deefy\db\ConnectionFactory::makeConnection();


$action = $_GET['action'] ?? 'connexion';

$html = '';

switch ($action){
    case 'connexion':
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $passwd = filter_var($_POST['passwd'], FILTER_SANITIZE_STRING);

            $query = 'SELECT `mdp`, `role` FROM Utilisateur WHERE `email` = ?';
            $st = $bdd->prepare($query);
            $st->bindParam(1, $email);
            $st->execute();

            $user = $st->fetchColumn();
            if ($user === false and $user['role'] != 100) {
                throw new Exception("erreur connexion");
            }
            if (!password_verify($passwd, $user)) {
                throw new Exception("erreur connexion");
            }
            else{
                $html="Utilisateur trouvé";
                $_SESSION['admin'] = true;
            }
        }
        else {
            $html = <<<HTML
            <form method="post" action="index.php?action=auth-user">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
                <label for="passwd">Mot de passe</label>
                <input type="password" name="passwd" id="passwd" required>
                <input type="submit" value="Envoyer">
            HTML;
        }
    break;
    case 'most-followed':
        $query = 'SELECT COUNT(emailFollower) as nbFollow, emailFollowed FROM FollowUser GROUP BY emailFollowed ORDER BY nbFollow DESC LIMIT 10;';
        $st = $bdd->prepare($query);
        $st->execute();

        $html = '<table>';
        while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
            $html .= '<tr><td>' . $row['emailFollowed'] . '</td><td>' . $row['nbFollow'] . '</td></tr>';
        }
        $html .= '</table>';
        break;
    case 'most-tagFollowed':
        $query = 'SELECT COUNT(email) as nbTag, idTag FROM FollowTag GROUP BY idTag ORDER BY nbTag LIMIT 10';
        $st = $bdd->prepare($query);
        $st->execute();

        $html = '<table>';
        while ($row = $st->fetch(PDO::FETCH_ASSOC)) {
            $html .= '<tr><td>' . $row['idTag'] . '</td><td>' . $row['nbTag'] . '</td></tr>';
        }
        $html .= '</table>';
    break;
    case 'deconnexion':
        unset($_SESSION['admin']);
    break;
    default:
        $html = '<h1>ERROR</h1>';
    break;
}


$k = '';
if (isset($_SESSION['admin'])) {
    $k=<<<HTML
            <a href="?action=most-followed"><button class="button">Influenceur</button></a>
            <a href="?action=most-tagFollowed"><button class='button'>tag les plus utilisés</button></a>
            <a href="?action=deconnexion"><button class='button'>Déconnexion</button></a>
HTML;
}

echo <<<HTML
<!DOCTYPE html>
<html lang='fr' >
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='styles/index.css'>
<title>Touiteur</title>
</head>

    <body>
    <nav class='navbar'>
        <div id='logo' >
            <a href="?action=home-page"><img src='ressources/logo_blanc.png' alt='logo' > </a>
        </div>
        <div id='profil'>
HTML.$k.<<<HTML
        </div>
    </nav>
HTML.$html.<<<HTML
    </body>
</html>
HTML;