<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TwigServiceProvider;
use TechNews\Extension\TechNewsTwigExtension;
use TechNews\Provider\AdminControllerProvider;
use TechNews\Provider\NewsControllerProvider;

#1 : Importation de l'autoload
require_once __DIR__ . '/../vendor/autoload.php';

#2 : Instanciation de l'Application
$app = new Application();

#3 : Activation du Debuggage
$app['debug'] = true;

#4 : Gestion de Nos Controllers
$app->mount('/', new NewsControllerProvider());
$app->mount('/admin', new AdminControllerProvider());

#5 : Activation de Twig
 # : composer require twig/twig
$app->register(new TwigServiceProvider(), [
   'twig.path' => [
        __DIR__ . '/../ressources/views',
        __DIR__ . '/../ressources/layout'
   ]
]);

#5.1 : Ajout des Extentions TechNews pour Twig (Accroche et Slugify)
$app->extend('twig', function($twig, $app) {
   $twig->addExtension(new TechNewsTwigExtension());
   return $twig;
});

#5.2 : Activation de Asset
$app->register(new AssetServiceProvider());

#6 : Doctrine DBAL & Idiorm
$app->register(new DoctrineServiceProvider(), [
    'db.options' => [
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'technews-denain',
        'user'      => 'root',
        'password'  => '',
    ],
]);

$app->register(new \Idiorm\Silex\Provider\IdiormServiceProvider(), array(
    'idiorm.db.options' => array(
        'connection_string' => 'mysql:host=localhost;dbname=technews-denain',
        'username' => 'root',
        'password' => '',
        'id_column_overrides' => array(
            'view_articles' =>  'IDARTICLE'
        )
    )
));

# 6.1 Récupération des Catégories
$app['tn_categories'] = function() use($app) {
    return $app['db']->fetchAll('SELECT * FROM categorie');
};

# 6.2 Récupération des Tags
$app['tn_tags'] = function() use($app) {
    return $app['db']->fetchAll('SELECT * FROM tags');
};

# 6.3 Récupération des catégories avec Idiorm
$app['idiorm_categories'] = function() use($app) {
    return $app['idiorm.db']->for_table('categorie')
                            ->find_result_set();
};

#7 : Permet le rendu d'un controller dans la vue
$app->register(new Silex\Provider\HttpFragmentServiceProvider());

#8 : Execution de l'Application
$app->run();
