<?php
/**
 * Created by PhpStorm.
 * User: Hugo LIEGEARD
 * Date: 14/12/2017
 * Time: 15:25
 */

namespace TechNews\Provider;


use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

class AdminControllerProvider implements ControllerProviderInterface
{

    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        # Récupérer l'instance de Silex\ControllerCollection
        # https://silex.symfony.com/api/master/Silex/ControllerCollection.html
        $controllers = $app['controllers_factory'];

        # Ajouter un Article en BDD
        $controllers
            ->match('/article/ajouter',
                'TechNews\Controller\AdminController::addarticleAction')
            ->method('GET|POST')
            ->bind('admin_addarticle');

        return $controllers;

    }
}