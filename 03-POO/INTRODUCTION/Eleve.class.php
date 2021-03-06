<?php

class Eleve {

    # Propriétés
    private $NomEleve,
            $PrenomEleve,
            $AgeEleve;

    /**
     * Eleve constructor.
     * @param $NomEleve
     * @param $PrenomEleve
     * @param $AgeEleve
     */
    public function __construct($NomEleve, $PrenomEleve, $AgeEleve)
    {
        $this->NomEleve     = $NomEleve;
        $this->PrenomEleve  = $PrenomEleve;
        $this->AgeEleve     = $AgeEleve;
    }

    /**
     * @return mixed
     */
    public function getNomEleve()
    {
        return $this->NomEleve;
    }

    /**
     * @param mixed $NomEleve
     * @return Eleve
     */
    public function setNomEleve($NomEleve)
    {
        $this->NomEleve = $NomEleve;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrenomEleve()
    {
        return $this->PrenomEleve;
    }

    /**
     * @param mixed $PrenomEleve
     * @return Eleve
     */
    public function setPrenomEleve($PrenomEleve)
    {
        $this->PrenomEleve = $PrenomEleve;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAgeEleve()
    {
        return $this->AgeEleve;
    }

    /**
     * @param mixed $AgeEleve
     * @return Eleve
     */
    public function setAgeEleve($AgeEleve)
    {
        $this->AgeEleve = $AgeEleve;
        return $this;
    }

    /**
     * Retourne le Prénom et le Nom de l'élève
     * @return string Prénom + Nom
     */
    public function getNomComplet() {
        return $this->PrenomEleve.' '.$this->NomEleve;
    }

}