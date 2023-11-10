<?php

namespace touiteur\touites;

/**
 *
 */
class ListeTouite
{
    /**
     * @var array
     */
    private $listeTouite;

    /**
     *
     */
    public function __construct(){
        $this->listeTouite = array();
    }

    /**
     * permet d'ajouter plusieurs touites à la liste
     *
     * @param $t
     * @return void
     */
    public function addPlusieursTouites($t = array()){
        foreach ($t as $touite) {
            $this->addTouite($touite);
        }
    }

    /**
     * permet d'ajouter un touite à la liste
     *
     * @param Touite $touite
     * @return void
     */
    public function addTouite(Touite $touite) : void{
        array_push($this->listeTouite, $touite);
    }

    /**
     * permet de supprimer un touite de la liste
     *
     * @param int $index
     * @return void
     */
    public function removeTouite(int $index) : void{
        unset($this->listeTouite[$index]);
    }

    /**
     * permet de récupérer un touite de la liste
     *
     * @param int $index
     * @return mixed
     */
    public function getTouite(int $index) : Touite{
        return $this->listeTouite[$index];
    }

    /**
     * permet de récupérer la liste de touite
     *
     * @return array
     */
    public function getTouitesListe() : array{
        return $this->listeTouite;
    }
}