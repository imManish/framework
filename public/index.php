<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\core\Application;
use app\http\controllers\SiteController;

$app = new Application(dirname(__DIR__));


$app->router->get('/', 'home');
// @todo - handle array property for rendering views from controller.
$app->router->get('/contacts', [SiteController::class, 'contact']); //
$app->router->post('/contacts', [ SiteController::class, 'handle']);

$app->run();
