<?php

namespace Core\Model;

abstract class DbTable
{

    # Nom de la Table
    protected $_table;

    # Clé Primaire
    protected $_primary;

    # Classe à Mapper
    protected $_classToMap;

    # Objet PDO, BDD
    private $_db;

    public function __construct()
    {
        # Je récupère l'instance de PDO
        $this->_db = DbFactory::PdoFactory();
    }

    /**
     * Fonction qui sera chargée de récupérer toutes
     * les informations d'une table dans la BDD
     */
    public function fetchAll(
        $where      = '',
        $orderby    = '',
        $limit      = '',
        $offset     = ''
    ) {

        $sql = "SELECT * FROM " . $this->_table;

        # Si $where n'est pas vide, alors je l'inclus dans ma requète
        if($where != '') :
            $sql .= ' WHERE ' . $where;
        endif;

        # Pareil pour le reste
        if($orderby != '') :
            $sql .= ' ORDER BY ' . $orderby;
        endif;

        if($limit != '') :
            $sql .= ' LIMIT ' . (int) $limit;
        endif;

        if($offset != '') :
            $sql .= ' OFFSET ' . (int) $offset;
        endif;

        $sth = $this->_db->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(\PDO::FETCH_CLASS,
            $this->_classToMap);

    }

    /**
     * Récupère un enregistrement dans la BDD
     * pour l'ID et la colonne passé en paramètre.
     * @param $id
     * @param string $column
     */
    public function fetchOne($id, $column = '') {

        if($column == '') :
            $column = $this->_primary;
        endif;

        $sth = $this->_db->prepare('SELECT * FROM ' . $this->_table
            . ' WHERE ' . $column . ' = :id');

        $sth->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $sth->execute();
        $sth->setFetchMode(\PDO::FETCH_CLASS, $this->_classToMap);
        return $sth->fetch();
    }

}


