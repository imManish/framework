<?php

namespace Bundle\Routing;

use Bundle\Application;
use Bundle\Http\Request;
use Bundle\Http\Response;
use Bundle\Routing\Traits\GetTrait;
use Bundle\Routing\Traits\PostTrait;

class Router
{
    use GetTrait;
    use PostTrait;

    public Request $request;

    public Response $response;

    protected array $routes = [];

    private string $method = 'get';

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return array|false|mixed|string|string[]
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $this->method = $this->request->method();
        $callback = $this->routes[$this->method][$path] ?? false;
        // check callback false
        if (false === $callback) {
            $this->response->setStatusCode(404);

            return $this->renderView('error/_404');
        }
        // check callback is string
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        // check callback clouser
        return call_user_func($this->isCheck($callback), $this->request);
    }

    /**
     * @param $view
     * @param array $params
     * @return array|false|string|string[]
     */
    public function renderView($view, array $params = []): array|bool|string
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    // deprecated
    public function renderContent($viewContent): array|bool|string
    {
        $layoutContent = $this->layoutContent();

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * @return false|string
     */
    protected function layoutContent(): bool|string
    {
        $layout = (Application::$app->controller ?? false) === false
            ? Application::$app->layout
            : Application::$app->controller->layout;

        ob_start();

        include_once Application::$ROOT_DIR . "/resources/views/layouts/{$layout}.knight.html";

        return ob_get_clean();
    }

    /**
     * @param $view
     * @param mixed $params
     *
     * @return false|string
     */
    protected function renderOnlyView($view, $params): bool|string
    {
        foreach ($params as $key => $value) {
            ${$key} = $value;
        }
        // var_dump($name);

        ob_start();

        include_once Application::$ROOT_DIR . "/resources/views/{$view}.knight.html";

        return ob_get_clean();
    }

    /**
     * @param $callback
     */
    private function isCheck($callback): mixed
    {
        if (is_array($callback)) {
            $callback[0] = Application::$app->controller = new $callback[0]();
        }

        return $callback;
    }
}
