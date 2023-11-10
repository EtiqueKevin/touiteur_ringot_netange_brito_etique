<?php

namespace touiteur\touites;

class ListeTouite
{
    private $listeTouite;

    public function __construct()
    {
        $this->listeTouite = array();
    }

    public function addPlusieursTouites($t = array())
    {
        foreach ($t as $touite) {
            $this->addTouite($touite);
        }
    }

    public function addTouite(Touite $touite)
    {
        array_push($this->listeTouite, $touite);
    }

    public function removeTouite(int $index)
    {
        unset($this->listeTouite[$index]);
    }

    public function getTouite(int $index)
    {
        return $this->listeTouite[$index];
    }

    public function getTouitesListe()
    {
        return $this->listeTouite;
    }
}