<?php

namespace Application\Model\Categorie;

class Categorie
{
    private $IDCATEGORIE,
            $LIBELLECATEGORIE,
            $ROUTECATEGORIE;

    /**
     * @return int
     */
    public function getIDCATEGORIE()
    {
        return $this->IDCATEGORIE;
    }

    /**
     * @return string
     */
    public function getLIBELLECATEGORIE()
    {
        return $this->LIBELLECATEGORIE;
    }

    /**
     * @return string
     */
    public function getROUTECATEGORIE()
    {
        return $this->ROUTECATEGORIE;
    }
}
