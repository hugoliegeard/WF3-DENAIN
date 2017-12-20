<?php

use Silex\Provider\AssetServiceProvider;
use Silex\Provider\CsrfServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Form\FormRenderer;
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

#9 : Importation pour les Formulaires
$app->register(new FormServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new CsrfServiceProvider());
$app->register(new LocaleServiceProvider());
$app->register(new TranslationServiceProvider(), [
    'translator.domains' => []
]);

# Unable to load the "Symfony\Component\Form\FormRenderer" runtime.
# https://github.com/symfony/symfony/issues/24533#issuecomment-352839791
$app->extend('twig.runtimes', function ($array) {
    $array[FormRenderer::class] = 'twig.form.renderer';
    return $array;
});

#10 : Chargement du Profiler Symfony
# https://github.com/silexphp/Silex-WebProfiler
if($app['debug']) :
    $app->register(new Silex\Provider\ServiceControllerServiceProvider());
    $app->register(new Silex\Provider\WebProfilerServiceProvider(), array(
        'profiler.cache_dir' => __DIR__.'/../cache/profiler',
        'profiler.mount_prefix' => '/_profiler', // this is the default
    ));
endif;
return $app;