<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Bundle\Application;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SiteController;

$app = new Application(dirname(__DIR__));

$app->router->get('/', 'home');

$app->router->get('/contacts', [SiteController::class, 'contact']);
$app->router->post('/contacts', [SiteController::class, 'handle']);

// @todo - configure more routes with Bundle
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->run();
