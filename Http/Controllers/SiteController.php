<?php
namespace app\http\controllers;


use app\core\Application;

class SiteController
{
    public function contact()
    {
        //var_dump('here');
        return Application::$app->router->renderView('contacts');
    }

    public function handle()
    {
        return 'Handling submited data';
    }
}