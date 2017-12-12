<?php
/**
 * Created by PhpStorm.
 * User: Hugo LIEGEARD
 * Date: 11/12/2017
 * Time: 12:33
 */

namespace Application\Model\Auteur;


class AuteurDb
{
    protected $_table           = 'auteur';
    protected $_primary         = 'IDAUTEUR';
    protected $_classToMap      = __NAMESPACE__ . '\\Auteur';
}