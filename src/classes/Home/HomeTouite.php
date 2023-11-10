<?php

namespace touiteur\Home;

use touiteur\DataBase\ConnectionFactory;

class HomeTouite{

    public static function formulaire_touite(): string{
        $html = '<form method="post" enctype="multipart/form-data">
            <textarea name="txtMessage"></textarea>
            <label for="img">Ajouter une photo: </label>
            <input type="file" id="img" name="img" accept="image/png, image/jpeg" /><br>
            <input type="submit" value="Publier" title="Publier mon message">
            </form>';
        return $html;
    }

    /**
     * Récupère toutes les tags d'un touite
     *
     * @param string $text texte du touite
     * @return array Tableau contenant les tags
     */
    public static function recup_tag(string $text): array{
        preg_match_all('/#([a-zA-Z0-9éâîôùèçàïû]+)/', $text, $matches, PREG_SET_ORDER);
        return array_column($matches, 1);
    }

    /**
     * Ajoute les liens vers les tags dans le texte
     *
     * @param string $cuit texte du blaba
     * @return string Texte du blaba avec les liens
     */
    public static function active_tag(string $touite): string{
        return preg_replace_callback('/(?<=([^&])|^)#([a-zA-Z0-9éâîôùèçàïû]+)/',
            function ($matches) {
                $b = ConnectionFactory::makeConnection();
                $query = 'SELECT id FROM `Tag` WHERE tag = ?';
                $st = $b->prepare($query);
                $st->bindParam(1, $matches[2]);
                $st->execute();


                return '<a id="tag" href="?action=ActionTag&idTag=' . $st->fetch()['id'] . '">#' . $matches[2] . '</a>';
            },
            $touite
        );

    }

}