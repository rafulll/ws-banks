<?php
require_once "vendor/autoload.php";
require_once "env.php";
require_once "app/config/constants.php";

use Slim\App;
use Config\Config;
use Config\Routes;

$app = new App(Config::getSlimConfig());

new Routes($app);

$app->run();