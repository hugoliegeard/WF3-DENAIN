<?php

namespace Application\Controller;

use Application\Model\Article\ArticleDb;
use Application\Model\Categorie\Categorie;
use Application\Model\Categorie\CategorieDb;
use Core\Controller\AppController;
use Core\Model\DbFactory;
use Core\Model\ORM;

class NewsController extends AppController {

    public function indexAction() {

        # Connexion à la BDD
        $ArticleDb = new ArticleDb;

        # Récupération des Articles
        $articles = $ArticleDb->fetchAll();

        # Récupération des Articles en Spotlight
        $spotlight = $ArticleDb->fetchAll('SPOTLIGHTARTICLE = 1');

        # Affichage de la vue
        $this->render('news/index', [
            'articles'  => $articles,
            'spotlight' => $spotlight
        ]);
        # include_once PATH_VIEWS . '/news/index.php';
    }

    public function businessAction() {

        # Connexion à la BDD
        $ArticleDb = new ArticleDb;

        # Récupération des Articles
        $articles = $ArticleDb
            ->fetchAll('IDCATEGORIE = 2');

        # Transmission à la Vue
        $this->render('news/categorie', [
            'articles' => $articles
        ]);
    }

    public function computingAction() {
        # Connexion à la BDD
        $ArticleDb = new ArticleDb;

        # Récupération des Articles
        $articles = $ArticleDb
            ->fetchAll('IDCATEGORIE = 3');

        # Transmission à la Vue
        $this->render('news/categorie', [
            'articles' => $articles
        ]);
    }

    public function techAction() {
        # Connexion à la BDD
        $ArticleDb = new ArticleDb;

        # Récupération des Articles
        $articles = $ArticleDb
            ->fetchAll('IDCATEGORIE = 4');

        # Transmission à la Vue
        $this->render('news/categorie', [
            'articles' => $articles
        ]);
    }

    /**
     * Test de fonctionnement avec Idiorm
     */
    public function idiormAction() {

        # Récupération des Catégories
        DbFactory::IdiormFactory();
        $categories = ORM::for_table('categorie')
            ->find_result_set();
            #->find_array(); -- Affichage JSON : renderJson()

        $this->debug($categories);
        $this->debug($categories);
        # $this->renderJson($categories);

        foreach ($categories as $categorie) :
            echo $categorie->LIBELLECATEGORIE . '<br>';
        endforeach;

        # Afficher la liste des Auteurs du site dans un Tableau HTML
        $auteurs = ORM::for_table('auteur')->find_result_set();

        echo '<hr><table border="1">';
            foreach ($auteurs as $auteur) :
                echo '<tr>';
                    echo '<td>' . $auteur->IDAUTEUR . '</td>';
                    echo '<td>' . $auteur->PRENOMAUTEUR . '</td>';
                    echo '<td>' . $auteur->NOMAUTEUR . '</td>';
                    echo '<td>' . $auteur->EMAILAUTEUR. '</td>';
                echo '</tr>';
            endforeach;
        echo '</table>';
    }

    public function articleAction() {

        # Récupération de l'IDARTICLE
        $idarticle = $_GET['idarticle'];

        # Récupération de l'Article
        $article = ORM::for_table('view_articles')
            ->find_one($idarticle);

        # Récupération des Articles de la Catégorie (suggestions)
        $suggestions = ORM::for_table('view_articles')
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

        $this->render('news/article', [
            'article'       => $article,
            'suggestions'   => $suggestions
        ]);
    }

}
