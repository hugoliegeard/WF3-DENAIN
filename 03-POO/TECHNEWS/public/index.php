<?php

use Core\Core;

# Chargement du Bootstrap
require_once 'bootstrap.php';

# Front Controller
$core = new Core($_GET);
