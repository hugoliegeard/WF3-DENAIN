<?php

namespace TechNews\Controller;

use Silex\Application;

class NewsController
{
    /**
     * Affichage de la Page d'Accueil
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Application $app) {
        return $app['twig']->render('index.html.twig');
    }

    /**
     * Affichage des Articles d'une Catégorie
     * @param $libellecategorie
         * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categorieAction($libellecategorie) {
        return "<h1>Catégorie : $libellecategorie</h1>";
    }

    /**
     * Affichage de la Page Article
     * @param $libellecategorie
     * @param $slugarticle
     * @param $idarticle
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function articleAction($libellecategorie, $slugarticle, $idarticle) {
        # index.php/business/une-formation-innovante-a-denain_98426852.html
        return "<h1>Article n°$idarticle | $slugarticle</h1>";
    }

}
