<?php

namespace Bundle\Routing;

use BadMethodCallException;
use Bundle\Foundation\Application;

abstract class Controller
{
    public string $layout = '_base';

    /**
     * Routing Controller.
     *
     * @param $method
     * @param $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        throw new BadMethodCallException(sprintf(
            'Method %s::%s does not exist.',
            static::class,
            $method
        ));
    }

    /**
     * Routing render view method.
     *
     * @param $view
     *
     * @return array|false|string|string[]
     */
    public function view($view, array $param = []): array|bool|string
    {
        // @var Application $view
        return Application::$app->router->renderView($view, $param);
    }

    /**
     * > This function sets the layout to be used by the view.
     *
     * @param string layout The name of the layout file to use
     */
    public function layout(string $layout): void
    {
        $this->layout = $layout;
    }
}
