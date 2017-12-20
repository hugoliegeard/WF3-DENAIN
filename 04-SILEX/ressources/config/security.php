<?php

use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SessionServiceProvider;
use TechNews\Provider\AuteurProvider;

$app->register(new SessionServiceProvider());

$app->register(new SecurityServiceProvider(), [

    /**
     * Ici je crée mon firewall pour l'application.
     */

    'security.firewalls' => [
        'main'  => [
            'pattern'   => '^/',
            'http'      => true,
            'anonymous' => true,
            'form'      => [
                'login_path' => '/connexion.html',
                'check_path' => '/connexion.html/login_check',
            ], # form
            'logout'    => [
                'logout_path' => '/deconnexion.html'
            ], # logout
            'users'     => function() use($app) {
                return new AuteurProvider($app['idiorm.db']);
            }
        ] # main
    ], # security.firewalls

    /**
     * Je définis mes règles d'accès, à savoir,
     * quelles routes pour quels rôles.
     */

    'security.access_rules' => [
        ['^/admin', 'ROLE_ADMIN', 'http'],
        ['^/auteur', 'ROLE_AUTEUR', 'http'],
    ], # security.access_rules

    /**
     * Je définis la hiérarchie d'accès.
     * Ex. Un ROLE_ADMIN à aussi un ROLE_AUTEUR
     */

    'security.role_hierarchy' => [
        'ROLE_AUTEUR' => ['ROLE_MEMBRE'],
        'ROLE_ADMIN' => ['ROLE_AUTEUR']
    ] # security.role_hierarchy
]);