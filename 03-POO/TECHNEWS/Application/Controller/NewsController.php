<?php

namespace Application\Controller;

use Core\Controller\AppController;

class NewsController extends AppController {

    public function indexAction() {
        # Affichage de la vue
        $this->render('news/index', [
            "titre"     => "WF3 Denain...",
            "accroche"  => "Partez-tous !"
        ]);
        # include_once PATH_VIEWS . '/news/index.php';
    }

    public function categorieAction() {
        $this->render('news/categorie');
    }

    public function articleAction() {
        $this->render('news/article');
    }

}