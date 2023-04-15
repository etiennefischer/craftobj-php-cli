<?php 
 
 namespace Etienne\Craftobj; 
 
 class Fruit 
 { 
    private string $plante; 
    private string $espece; 
    private string $famille; 
    private string $origine; 
    private string $vitamines; 
    private string $mineraux; 
 
    public function __construct() 
    { 
    } 
 
    public function sample(): Fruit 
    { 
        return (new self())
            ->setPlante('Pommier')
            ->setEspece('Malus domestica')
            ->setFamille('Rosaceae')
            ->setOrigine('Asie centrale')
            ->setVitamines('A, B1, B2, B3, B5, B6, B9, C, E et K')
            ->setMineraux('Calcium, fer, magnésium, manganèse, phosphore, potassium, sodium et zinc')
        ;
    } 
 
    public function getPlante(): string 
    { 
        return $this->plante;
    } 
 
    public function setPlante(string $plante): self 
    { 
        $this->plante = $plante;
 
        return $this;
    } 
 
    public function getEspece(): string 
    { 
        return $this->espece;
    } 
 
    public function setEspece(string $espece): self 
    { 
        $this->espece = $espece;
 
        return $this;
    } 
 
    public function getFamille(): string 
    { 
        return $this->famille;
    } 
 
    public function setFamille(string $famille): self 
    { 
        $this->famille = $famille;
 
        return $this;
    } 
 
    public function getOrigine(): string 
    { 
        return $this->origine;
    } 
 
    public function setOrigine(string $origine): self 
    { 
        $this->origine = $origine;
 
        return $this;
    } 
 
    public function getVitamines(): string 
    { 
        return $this->vitamines;
    } 
 
    public function setVitamines(string $vitamines): self 
    { 
        $this->vitamines = $vitamines;
 
        return $this;
    } 
 
    public function getMineraux(): string 
    { 
        return $this->mineraux;
    } 
 
    public function setMineraux(string $mineraux): self 
    { 
        $this->mineraux = $mineraux;
 
        return $this;
    } 
 
} 
