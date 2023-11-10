<?php

namespace touiteur\renderer;

use touiteur\DataBase\ConnectionFactory;
use touiteur\exception\InvalidPropertyValueException;
use touiteur\Home\HomeTouite;
use touiteur\touites\Touite;
use touiteur\utilisateur\Utilisateur;

class TouiteRenderer
{

    private $touite;

    public function __construct(Touite $touite)
    {
        $this->touite = $touite;
    }

    public function render(int $selector): string
    {
        $droit = false;
        if (isset($_SESSION['user'])) {
            $userLog = unserialize($_SESSION['user']);

            $droit = $this->touite->auteur === $userLog->pseudo || $userLog->role === '100';
        }else {
            $selector = $selector == 3 ? 4 : 2;
        }

        $text = HomeTouite::active_tag($this->touite->texte);
        $corbeille = $droit ? '<div ><a href="?action=delete&id=' . $this->touite->id . '&page=1"><img id="corbeille" src="ressources/corbeille.png"></a></div>': "";
        $html = "<div class='touite'>";
        switch ($selector) {
            case 1:
                try {
                    $user = unserialize($_SESSION['user']);
                    $html .= '<div id="block-touite">
                <div id="touite">
                <div id="touite-head">
                <h2 class="touite-author"><a href="?action=ActionUtilisateur&pseudo=' . $this->touite->auteur . '&page=1">' . $this->touite->auteur . '</a></h2><br></div>
                <p class="touite-content">' . $text . '</p><a class="display" href="?action=display-touite&idTouite=' . $this->touite->id . '">afficher plus<br>';
                    $html .= $this->touite->photo != null ? "image..." : "";
                    $html .= '</a></div><div id="likes-counter"><a href="?action=like&id=' . $this->touite->id . '&page=1">';
                    $html .= Utilisateur::hasLiked($user->email, $this->touite->id) ? '<img id="unlike" src="ressources/Heart.png" alt=""></a></p></div>' : '<img id="like" src="ressources/Heart.png" alt=""></a></p></div>';


                } catch (InvalidPropertyValueException $e) {
                    echo $e->getMessage();
                }

                break;
            case 2:
                try {
                    $html .= '<div id="block-touite">
                <div id="touite">
                <div id="touite-head">
                <h2 class="touite-author"><a href="?action=ActionUtilisateur&pseudo=' . $this->touite->auteur . '&page=1">' . $this->touite->auteur . '</a></h2><br></div>
                <p class="touite-content">' . $text . '</p><a class="display" href="?action=display-touite&idTouite=' . $this->touite->id . '">afficher plus<br>';
                    $html .= $this->touite->photo != null ? "image..." : "";
                    $html .= '</a></div></div>';
                } catch (InvalidPropertyValueException $e) {
                    echo $e->getMessage();
                }

                break;
            case 3:
                try {
                    $likes = Touite::getLikes($this->touite->id);;
                    $user = unserialize($_SESSION['user']);
                    $html .= '<div id="block-touite">
                <div id="touite">
                <div id="touite-head">
                <h2 class="touite-author"><a href="?action=ActionUtilisateur&pseudo=' . $this->touite->auteur . '&page=1">' . $this->touite->auteur . '</a></h2><h2>' . $this->touite->aff_date() . '</h2><br></div>
                <p class="touite-content-full">' . $text . '</p><br>';
                    $html .= $this->touite->photo != null ? '<img src="' . $this->touite->photo . '">' : "";
                    $html .= '</div> <div id="likes-counter"> <p class="number-likes">' . $likes . ' Likes</p><a href="?action=like&id=' . $this->touite->id . '&page=1">';
                    $html .= Utilisateur::hasLiked($user->email, $this->touite->id) ? '<img id="unlike" src="ressources/Heart.png" alt=""></a></p></div>' : '<img id="like" src="ressources/Heart.png" alt=""></a></p></div>';
                    $html .= $corbeille;
                    $html .= '</div>';


                } catch (InvalidPropertyValueException $e) {
                    echo $e->getMessage();
                }

                break;
            case 4:
                try {

                    $html .= '<div id="block-touite">
                <div id="touite">
                <div id="touite-head">
                <h2 class="touite-author"><a href="?action=ActionUtilisateur&pseudo=' . $this->touite->auteur . '&page=1">' . $this->touite->auteur . '</a></h2><h2>' . $this->touite->aff_date() . '</h2><br></div>
                <p class="touite-content-full">' . $text . '</p><br>';
                    $html .= $this->touite->photo != null ? '<img src="' . $this->touite->photo . '">' : "";
                    $html .= '</div> <div id="likes-counter"> <p class="number-likes">' . Touite::getLikes($this->touite->id) . ' Likes</p></div>';
                    $html .= $corbeille;
                    $html .= '</div>';


                } catch (InvalidPropertyValueException $e) {
                    echo $e->getMessage();
                }
                break;

        }
        return $html;
    }


}