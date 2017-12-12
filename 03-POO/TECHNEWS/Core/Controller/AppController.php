<?php

namespace Core\Controller;

class AppController
{
    private $_viewparams;

    /**
     * Permet de générer l'affichage de la vue passée en paramètre.
     * @param $view Vue à afficher
     * @param string $viewparam Données à passer à la vue
     */
    protected function render($view, Array $viewparam = []) {

        # Récupération et Affectation des Paramètres de la Vue
        $this->_viewparams = $viewparam;

        # Chargement du Header
        include_once PATH_HEADER;

        # Inclusion de la Vue
        include_once PATH_VIEWS . '/' . $view . '.php';

        # Chargement du Footer
        include_once PATH_FOOTER;
    }

    /**
     * Renvoi le tableau de paramètres de la vue
     * @return Array
     */
    public function getViewparams()
    {
        # http://php.net/manual/fr/class.arrayobject.php
        # Je vais pouvoir accéder à mon tableau comme un objet
        $object = new \ArrayObject($this->_viewparams);
        $object->setFlags(\ArrayObject::ARRAY_AS_PROPS);
        return $object;
    }

    /**
     * Vérifie l'existance de valeur dans $_GET['action']
     * et retourne l'action.
     * @return string Action
     */
    public function getAction() {
        if(empty($_GET['action'])) {
            return 'accueil';
        }
        return $_GET['action'];
    }

    # Debug des Paramètres de la Vue
    public function debugParams() {
        echo '<pre>';
            print_r($this->getViewparams());
        echo '</pre>';
    }

    # Debug du Paramètre passé
    public function debug($params) {
        echo '<pre>';
            print_r($params);
        echo '</pre>';
    }

}
