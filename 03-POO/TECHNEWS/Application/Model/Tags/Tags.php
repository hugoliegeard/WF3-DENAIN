<?php

namespace Application\Model\Tags;

class Tags
{
    private $IDTAGS,
        $LIBELLETAGS;

    /**
     * @return mixed
     */
    public function getIDTAGS()
    {
        return $this->IDTAGS;
    }

    /**
     * @return mixed
     */
    public function getLIBELLETAGS()
    {
        return $this->LIBELLETAGS;
    }
}
