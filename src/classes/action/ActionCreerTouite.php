<?php

namespace touiteur\action;

class ActionCreerTouite
{
    function formulaire_touite(): string
    {
        $html = "";
        $html .= '<form action="test.php" method="POST">
            <textarea name="txtMessage"></textarea>
            <input type="submit" value="Publier" title="Publier mon message">
            <label for="avatar">Ajouter une photo: </label><input type="file" id="avatar" name="avatar" accept="image/png, image/jpeg" /><br>
            </form>';
        return $html;
    }

    /**
     * Récupère toutes les tags d'un touite
     *
     * @param string $text texte du touite
     * @return array Tableau contenant les tags
     */
    function recup_tag(string $text): array
    {
        preg_match_all('/#([a-zA-Z0-9éâîôùèçàïû]+)/', $text, $matches, PREG_SET_ORDER);
        return array_column($matches, 1);
    }

    /**
     * Ajoute les liens vers les tags dans le texte
     *
     * @param string $cuit texte du blaba
     * @return string Texte du blaba avec les liens
     */
    function active_tag(string $touite): string
    {
        return preg_replace_callback('/(?<=([^&])|^)#([a-zA-Z0-9éâîôùèçàïû]+)/',
            function ($matches) {
                return '<a id="tag" href="?tag=' . urlencode($matches[2]) . '">#' . $matches[2] . '</a>';
            },
            $touite
        );

    }

}