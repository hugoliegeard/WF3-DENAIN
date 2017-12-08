<?php

namespace Application\Model\Categorie;

class Categorie
{
    private $_IDCATEGORIE,
            $_LIBELLECATEGORIE,
            $_ROUTECATEGORIE;

    /**
     * @return int
     */
    public function getIDCATEGORIE()
    {
        return $this->_IDCATEGORIE;
    }

    /**
     * @return string
     */
    public function getLIBELLECATEGORIE()
    {
        return $this->_LIBELLECATEGORIE;
    }

    /**
     * @return string
     */
    public function getROUTECATEGORIE()
    {
        return $this->_ROUTECATEGORIE;
    }
}
