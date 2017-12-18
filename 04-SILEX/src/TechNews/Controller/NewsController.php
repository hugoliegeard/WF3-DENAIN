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

}
