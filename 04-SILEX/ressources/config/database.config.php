<?php

use Silex\Provider\DoctrineServiceProvider;

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