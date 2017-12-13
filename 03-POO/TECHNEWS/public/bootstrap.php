<?php

# Quelques constantes utiles...
define('PATH_ROOT', dirname(__DIR__));
define('PATH_PUBLIC', dirname($_SERVER['SCRIPT_NAME']));
define('PATH_APPLICATION', PATH_ROOT . '/Application');
define('PATH_LAYOUT', PATH_APPLICATION . '/Layout');
define('PATH_VIEWS', PATH_APPLICATION . '/Views');
define('PATH_HEADER', PATH_LAYOUT . '/header.inc.php');
define('PATH_FOOTER', PATH_LAYOUT . '/footer.inc.php');
define('PATH_SIDEBAR', PATH_LAYOUT . '/sidebar.inc.php');

# Chargement de la config
require_once 'config.php';

# Chargement de l'Autoload
require_once 'autoloader.php';
Autoloader::register();
