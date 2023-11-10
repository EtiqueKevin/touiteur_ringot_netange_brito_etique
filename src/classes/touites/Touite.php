<?php

namespace touiteur\touites;
/**
 *
 */
define('TOUITE_PAR_PAGE', 10);

use touiteur\DataBase\ConnectionFactory;
use touiteur\exception\InvalidPropertyNameException;
use touiteur\exception\InvalidPropertyValueException;


/**
 *
 */
class Touite{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $texte;
    /**
     * @var string
     */
    private $date;
    /**
     * @var string
     */
    private $auteur;

    /**
     * @var int
     */
    private $likes;

    /**
     * @var mixed|null
     */
    private $photo;

    /**
     * constructeur
     *
     * @param int $id
     * @param string $texte
     * @param string $date
     * @param string $auteur
     * @param $photo
     */
    public function __construct(int $id, string $texte, string $date, string $auteur, $photo = null){
        $this->id = $id;
        $this->texte = $texte;
        $this->date = $date;
        $this->auteur = $auteur;
        $this->likes = 0;
        $this->photo = $photo;
    }

    /**
     * like un touite
     *
     * @param $id
     * @return void
     */
    public static function like($id) : void{
        $id = $_GET['id'];
        $bd = ConnectionFactory::makeConnection();
        $sql = "UPDATE touites SET likes = likes + 1 WHERE id = ?";
        $st = $bd->prepare($sql);
        $st->bindParam(1, $id);
        $st->execute();

    }

    /**
     * vérifie si le touite a déjà été liké par l'utilisateur
     *
     * @param $id
     * @return int|mixed
     */
    public static function getLikes($id) : int{
        $bd = ConnectionFactory::makeConnection();
        $query = 'SELECT likes FROM Touite WHERE id = ?';
        $st = $bd->prepare($query);
        $st->bindParam(1, $id);
        $st->execute();
        $result = $st->fetch();
        return $result === false ? 0 : $result['likes'];
    }

    /**
     * @param array $tab
     * @return array
     */
    public static function pagination(array $tab): array{

        // Récupérer la page actuelle
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        // Calculer l'offset pour la requête SQL
        $offset = ($page - 1) * TOUITE_PAR_PAGE;

        $_SESSION['nbTouite'] = sizeof($tab);

        return array_slice($tab, $offset, $offset + TOUITE_PAR_PAGE);
    }

    /**
     * permet de supprimer un touite
     *
     * @param $id
     * @return void
     */
    public static function supprimerTouite($id) : void{
        $bd = ConnectionFactory::makeConnection();
        $sql = "DELETE FROM HasLiked WHERE idTouite = ?";
        $st = $bd->prepare($sql);
        $st->bindParam(1, $id);
        $st->execute();

        $sql = "DELETE FROM TouiteTag WHERE idTouite = ?";
        $st = $bd->prepare($sql);
        $st->bindParam(1, $id);
        $st->execute();

        $sql = "DELETE FROM Touite WHERE id = ?";
        $st = $bd->prepare($sql);
        $st->bindParam(1, $id);
        $st->execute();
    }

    /**
     * getter
     *
     * @param $property
     * @return mixed
     * @throws InvalidPropertyValueException
     */
    public function __get($property): mixed{
        if ($property === 'id' || $property === 'texte' || $property === 'date' || $property === 'auteur' || $property === 'likes' || $property === 'photo') {
            return $this->$property;
        } else {
            throw new InvalidPropertyValueException("Property $property is not readable for a Touite.");
        }
    }

    /**
     * setter
     *
     * @param $property
     * @param $value
     * @return void
     * @throws InvalidPropertyNameException
     */
    public function __set($property, $value): void{
        if ($property === 'texte' || $property === 'date' || $property === 'auteur') {
            $this->$property = $value;
        } else {
            throw new InvalidPropertyNameException("Property $property is not editable for a Touite.");
        }
    }

    /**
     * Transformation d'un date en clair.
     *
     * Aucune vérification n'est faite sur la validité de la date car
     * on considère que c'est bien une date valide sous la forme aaaammjj
     *
     *
     * @return string            La date sous la forme jj mois aaaa (1 janvier 2000)
     */
    public function aff_date(): string{

        $mois = array('', ' janvier ', ' février ', ' mars ', ' avril ', ' mai ', ' juin',
            ' juillet ', ' aôut ', ' septembre ', ' octobre ', ' novembre ', ' décembre ');

        $jj = (int)substr($this->date, 8, 2);
        $mm = (int)substr($this->date, 5, 2);
        $aaaa = substr($this->date, 0, 4);

        $h = (int)substr($this->date, 10, 3);
        $m = substr($this->date, 14, 2);

        if (!is_numeric($m) && ($m == (int)$m)) { //$heure est une chaîne provenant de la BdD, donc méfiance
            $m = '00';
        }
        $heure = "{$h}h{$m}";

        return $jj . $mois[$mm] . $aaaa . '  ' . $heure;
    }

}
