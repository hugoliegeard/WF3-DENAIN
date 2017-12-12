<?php

namespace Application\Model\Auteur;

class Auteur
{
    private $IDAUTEUR,
            $NOMAUTEUR,
            $PRENOMAUTEUR,
            $EMAILAUTEUR;

    /**
     * @return int
     */
    public function getIDAUTEUR()
    {
        return $this->IDAUTEUR;
    }

    /**
     * @return string
     */
    public function getNOMAUTEUR()
    {
        return $this->NOMAUTEUR;
    }

    /**
     * @return string
     */
    public function getPRENOMAUTEUR()
    {
        return $this->PRENOMAUTEUR;
    }

    /**
     * @return string
     */
    public function getEMAILAUTEUR()
    {
        return $this->EMAILAUTEUR;
    }
}
