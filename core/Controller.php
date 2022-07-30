<?php

namespace App\Core;

class Controller
{
    /**
     * @param $view
     * @param $param
     * @return array|false|string|string[]
     */
    public function view($view, $param= [])
    {
        return Application::$app->router->renderView($view, $param);
    }

}