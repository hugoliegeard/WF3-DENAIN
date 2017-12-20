<?php
/**
 * Gestion des Routes de l'Application
 */

use TechNews\Provider\AdminControllerProvider;
use TechNews\Provider\NewsControllerProvider;

$app->mount('/', new NewsControllerProvider());
$app->mount('/admin', new AdminControllerProvider());