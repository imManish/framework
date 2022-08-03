<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SiteController;
use Bundle\Foundation\Application;

require_once __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'DB' => [
        'DB_DRIVER' => $_ENV['DB_DRIVER'],
        'DB_HOST' => $_ENV['DB_HOST'],
        'DB_PORT' => $_ENV['DB_PORT'],
        'DB_DATABASE' => $_ENV['DB_DATABASE'],
        'DB_USERNAME' => $_ENV['DB_USERNAME'],
        'DB_PASSWORD' => $_ENV['DB_PASSWORD'],
    ],
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', 'home');

$app->router->get('/contacts', [SiteController::class, 'contact']);
$app->router->post('/contacts', [SiteController::class, 'handle']);

// @todo - configure more routes with bundle
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->run();
