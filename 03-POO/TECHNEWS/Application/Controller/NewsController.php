<?php

namespace Application\Controller;

use Application\Model\Article\ArticleDb;
use Application\Model\Categorie\CategorieDb;
use Core\Controller\AppController;

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

    public function articleAction() {
        $this->render('news/article');
    }

}