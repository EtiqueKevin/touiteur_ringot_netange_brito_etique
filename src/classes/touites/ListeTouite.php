<?php

namespace touiteur\touites;

class ListeTouite{
    private $listeTouite;

    public function __construct()
    {
        $this->listeTouite = array();
    }

    public function addTouite(Touite $touite){
        array_push($this->listeTouite, $touite);
    }

    public function addPlusieursTouites($t = array()){
        foreach($t as $touite){
            $this->addTouite($touite);
        }
    }

    public function removeTouite(int $index){
        unset($this->listeTouite[$index]);
    }

    public function getTouite(int $index){
        return $this->listeTouite[$index];
    }

    public function getTouitesListe(){
        return $this->listeTouite;
    }

    public function getTouitesByTag(string $tag){
        $listeTouiteByTag = array();
        foreach($this->listeTouite as $touite){
            if($touite->getTag() == $tag){
                array_push($listeTouiteByTag, $touite);
            }
        }
        return $listeTouiteByTag;
    }

    public function getTouitesByDate(string $date){
        $listeTouiteByDate = array();
        foreach($this->listeTouite as $touite){
            if($touite->getDate() == $date){
                array_push($listeTouiteByDate, $touite);
            }
        }
        return $listeTouiteByDate;
    }

}