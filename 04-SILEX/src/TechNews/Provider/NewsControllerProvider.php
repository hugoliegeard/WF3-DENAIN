<?php

namespace TechNews\Provider;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

class NewsControllerProvider implements ControllerProviderInterface
{

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        # Récupérer l'instance de Silex\ControllerCollection
        # https://silex.symfony.com/doc/2.0/organizing_controllers.html
        # https://silex.symfony.com/api/master/Silex/ControllerCollection.html
        $controllers = $app['controllers_factory'];

            # Page d'Accueil
            $controllers
                # On associe une route à un Controller et une Action
                ->get('/', 'TechNews\Controller\NewsController::indexAction')
                # En option, je peux donner un nom à la route, qui servira
                # plus tard pour la création de liens
                ->bind('news_index');

            # Page Catégorie
            $controllers
                ->get('/categorie/{libellecategorie}',
                    'TechNews\Controller\NewsController::categorieAction')
                # Je spécifie le type de paramètre attendu avec une Regex
                ->assert('libellecategorie', '[^/]+')
                # Je peux attribuer une valeur par défaut
                ->value('libellecategorie', 'computer')
                # Nom de ma Route
                ->bind('news_categorie');

            # Page Article
            $controllers
                ->get('/{libellecategorie}/{slugarticle}_{idarticle}.html',
                    'TechNews\Controller\NewsController::articleAction')
                ->assert('idarticle', '\d+')
                ->bind('news_article');

        # Page Connexion & Inscription
        $controllers
            ->get('/inscription.html',
                'TechNews\Controller\NewsController::inscriptionAction')
                    ->bind('news_inscription');

        $controllers
            ->post('/inscription.html',
                'TechNews\Controller\NewsController::inscriptionPost')
            ->bind('news_inscription_post');

        $controllers
            ->get('/connexion.html',
                'TechNews\Controller\NewsController::connexionAction')
            ->bind('news_connexion');

        $controllers
            ->get('/deconnexion.html',
                'TechNews\Controller\NewsController::deconnexionAction')
            ->bind('news_deconnexion');

            # PHP Info
            # $controllers
            #    ->get('/infos',
            #        [ $this, 'infoAction' ]);

        return $controllers;
    }

    public function infoAction() {
        return phpinfo();
    }
}