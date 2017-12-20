<?php

use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use TechNews\Extension\TechNewsTwigExtension;

#1 : Activation du Debuggage
$app['debug'] = true;

#2 : Gestion des Routes
require PATH_SRC . '/routes.php';

#3 : Activation de Twig
# : composer require twig/twig
# : composer require twig/bridge
$app->register(new TwigServiceProvider(), [
    'twig.path' => [
        __DIR__ . '/../ressources/views',
        __DIR__ . '/../ressources/layout'
    ]
]);

#4 : Ajout des Extentions TechNews pour Twig (Accroche et Slugify)
$app->extend('twig', function($twig, $app) {
    $twig->addExtension(new TechNewsTwigExtension());
    return $twig;
});

#5 : Activation de Asset
$app->register(new AssetServiceProvider());

#6 : Permet le rendu d'un controller dans la vue
$app->register(new Silex\Provider\HttpFragmentServiceProvider());

#7 : Configuration de la BDD
require PATH_RESSOURCES . '/config/database.config.php';

#8 : Sécurisation de l'Application
require PATH_RESSOURCES . '/config/security.php';

return $app;