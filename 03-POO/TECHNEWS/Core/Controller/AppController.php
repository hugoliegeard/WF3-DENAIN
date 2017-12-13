<?php

namespace Core\Controller;

use Core\Model\DbFactory;
use Core\Model\Helper;

class AppController
{
    use Helper;

    private $_viewparams;

    /**
     * Permet d'initialiser la connexion à la BDD pour
     * l'ensemble des Actions de mes Controllers.
     * AppController constructor.
     */
    public function __construct()
    {
        # Initialisation de IdiormFactory à la construction
        # de AppController
        DbFactory::IdiormFactory();
    }

    /**
     * Permet de générer l'affichage de la vue passée en paramètre.
     * @param $view Vue à afficher
     * @param string $viewparam Données à passer à la vue
     */
    protected function render($view, Array $viewparam = []) {

        # Récupération et Affectation des Paramètres de la Vue
        $this->_viewparams = $viewparam;

        # Inclusion de la Vue
        $view = PATH_VIEWS . '/' . $view . '.php';
        if( file_exists($view) ) :

            # Chargement du Header
            include_once PATH_HEADER;

            # La Vue
            include_once $view;

            # Chargement du Footer
            include_once PATH_FOOTER;

        else :
            # Si la vue n'existe pas, on retourne une erreur 404
            $this->render('error/404', [
                'message' => 'Aucune vue correspondante'
            ]);
        endif;
    }

    /**
     * Effectue un rendu JSON du Tableau passé en paramètre
     * @param array $param
     */
    protected function renderJson(Array $param) {
        header('Content-Type: application/json');
        echo json_encode($param);
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
