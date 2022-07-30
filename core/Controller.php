<?php

namespace App\Core;
use BadMethodCallException;

abstract class Controller
{
    public string $layout = '_base';
    /**
     * Routing render view method.
     *
     * @param $view
     * @param $param
     * @return array|false|string|string[]
     */
    public function view($view, $param= [])
    {
        return Application::$app->router->renderView($view, $param);
    }


    /**
     * Routing Controller
     *
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        throw new BadMethodCallException(sprintf(
            'Method %s::%s does not exist.', static::class, $method
        ));
    }

    public function layout(string $layout)
    {
        $this->layout = $layout;
    }
}