<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Application;
use App\Http\Controllers\SiteController;

$app = new Application(dirname(__DIR__));


$app->router->get('/', 'home');
// @todo - handle array property for rendering views from controller.
$app->router->get('/contacts', [SiteController::class, 'contact']); //
$app->router->post('/contacts', [ SiteController::class, 'handle']);

$app->router->get('/login', [ SiteController::class, 'authLogin']);
$app->router->post('/login', [ SiteController::class, 'authLogin']);
$app->router->post('/contacts', [ SiteController::class, 'handle']);
$app->router->post('/contacts', [ SiteController::class, 'handle']);

$app->run();
