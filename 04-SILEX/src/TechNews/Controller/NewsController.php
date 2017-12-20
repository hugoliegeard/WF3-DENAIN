<?php

namespace TechNews\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class NewsController
{
    /**
     * Affichage de la Page d'Accueil
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Application $app) {

        # Connexion à la BDD & Récupération des Articles
        $articles = $app['idiorm.db']->for_table('view_articles')
                                     ->find_result_set();

        # Récupération des Articles en Spotlight
        $spotlight = $app['idiorm.db']->for_table('view_articles')
                                      ->where('SPOTLIGHTARTICLE', 1)
                                      ->find_result_set();

        # Affichage dans la Vue
        return $app['twig']->render('index.html.twig', [
            'articles' => $articles,
            'spotlight' => $spotlight
        ]);
    }

    /**
     * Affichage des Articles d'une Catégorie
     * @param $libellecategorie
         * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categorieAction($libellecategorie, Application $app) {

        # Récupération des Articles de la Catégorie
        $articles = $app['idiorm.db']->for_table('view_articles')
            ->where('LIBELLECATEGORIE', ucfirst($libellecategorie))
            ->find_result_set();

        # Transmission à la Vue
        return $app['twig']->render('categorie.html.twig', [
            'articles' => $articles,
            'libellecategorie' => $libellecategorie
        ]);
    }

    /**
     * Affichage de la Page Article
     * @param $libellecategorie
     * @param $slugarticle
     * @param $idarticle
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function articleAction($libellecategorie, $slugarticle,
                                  $idarticle, Application $app) {
        # index.php/business/une-formation-innovante-a-denain_98426852.html
        # Récupération de l'Article
        $article = $app['idiorm.db']->for_table('view_articles')
            ->find_one($idarticle);

        # Récupération des Articles de la Catégorie (suggestions)
        $suggestions = $app['idiorm.db']->for_table('view_articles')
            # Je récupère uniquement, les articles de la même
            # catégorie que mon article
            ->where('IDCATEGORIE', $article->IDCATEGORIE)

            # Sauf mon article en cours
            ->where_not_equal('IDARTICLE', $idarticle)

            # 3 articles maximum
            ->limit(3)

            # Par ordre decroissant
            ->order_by_desc('IDARTICLE')

            # Je récupère les résultats
            ->find_result_set();

        return $app['twig']->render('article.html.twig', [
            'article'       => $article,
            'suggestions'   => $suggestions
        ]);
    }

    /**
     * Génération du Menu dans le Layout
     * @param Application $app
     */
    public function menu(Application $app) {

        # Récupération des Catégories
        $categories = $app['idiorm.db']->for_table('categorie')
            ->find_result_set();

        # Transmission à la Vue
        return $app['twig']->render('menu.html.twig', [
            'categories' => $categories
        ]);
    }

    public function sidebar(Application $app) {

        # Récupération des Informations pour la Sidebar
        $sidebar = $app['idiorm.db']->for_table('view_articles')
                                    ->order_by_desc('DATECREATIONARTICLE')
                                    ->limit(5)
                                    ->find_result_set();

        $special = $app['idiorm.db']->for_table('view_articles')
                                    ->where('SPECIALARTICLE', 1)
                                    ->find_result_set();

        # Transmission à la Vue
        return $app['twig']->render('sidebar.html.twig', [
            'sidebar'    => $sidebar,
            'special'    => $special
        ]);
    }

    /**
     * Affichage de la Page Inscription
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function inscriptionAction(Application $app) {
        return $app['twig']->render('inscription.html.twig');
    }

    /**
     * Traitement POST du Formulaire d'Inscription
     * @param Application $app
     * @param Request $request
     */
    public function inscriptionPost(Application $app, Request $request) {

        # Vérification et la Sécurisation des données POST
        # ...

        # Connexion à la BDD
        $auteur = $app['idiorm.db']->for_table('auteur')->create();

        # Affectation de Valeurs
        $auteur->PRENOMAUTEUR   = $request->get('PRENOMAUTEUR');
        $auteur->NOMAUTEUR      = $request->get('NOMAUTEUR');
        $auteur->EMAILAUTEUR    = $request->get('EMAILAUTEUR');
        $auteur->MDPAUTEUR      = $app['security.default_encoder']
            ->encodePassword($request->get('MDPAUTEUR'), '');
        $auteur->ROLEAUTEUR     = 'ROLE_MEMBRE';

        # On persiste en BDD
        $auteur->save();

        # On envoi un email de confirmation ou de bienvenue...
        # On envoi une notification à l'administrateur
        # ...

        # On redirige l'utilisateur sur la page de connexion
        return $app->redirect('connexion.html?inscription=success');

    }

    /**
     * Affichage de la Page Connexion
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function connexionAction(Application $app, Request $request) {
        return $app['twig']->render('connexion.html.twig', [
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username')
        ]);
    }

}
