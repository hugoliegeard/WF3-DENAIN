<?php

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
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

#6 : Execution de l'Application
$app->run();
