<?php
namespace app\http\controllers;


use app\core\Application;

class SiteController
{
    public function contact()
    {
        return Application::$app->router->renderView('contact');
    }

    public function handle()
    {
        return 'Handling submited data';
    }
}