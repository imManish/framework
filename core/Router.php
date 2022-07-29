<?php
namespace app\core;
use Exception;

class Router
{
    /**
     * @var array
     */
    protected array $routes = [];

    /**
     * @var string
     */
    private string $method = 'get';

    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        //var_dump($this->method);
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $this->method = $this->request->getMethod();

        $callback = $this->routes[$this->method][$path] ?? false;
        //var_dump($callback);

        if($callback === false) {
            $this->response->setStatusCode(404);
            return $this->renderView('error/_404');
        }

        if(is_string($callback))
        {
            return $this->renderView($callback);
        }
        var_dump($callback);
        return call_user_func($callback);
    }

    public function renderView($view)
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view);

        return str_replace('{{content}}',$viewContent, $layoutContent);
    }

    // deprecated
    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}',$viewContent,$layoutContent);
    }

    protected function layoutContent()
    {
        ob_start();
        include_once Application::$ROOT_DIR."/resources/views/layouts/layout.knight.html";
        return ob_get_clean();
    }

    protected function renderOnlyView($view)
    {
        ob_start();
        include_once Application::$ROOT_DIR."/resources/views/$view.knight.html";
        return ob_get_clean();
    } 

}