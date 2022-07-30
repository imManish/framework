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

    /**
     * @var Request
     */
    public Request $request;

    /**
     * @var Response
     */
    public Response $response;

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @param $path
     * @param $callback
     * @return void
     */
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * @param $path
     * @param $callback
     * @return void
     */
    public function post($path, $callback)
    {
        //var_dump($this->method);
        $this->routes['post'][$path] = $callback;
    }

    /**
     * @return array|false|mixed|string|string[]
     */
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

        return call_user_func([new $callback[0], $callback[1]]);

    }

    /**
     * @param $view
     * @return array|false|string|string[]
     */
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

    /**
     * @return false|string
     */
    protected function layoutContent()
    {
        ob_start();
        include_once Application::$ROOT_DIR."/resources/views/layouts/layout.knight.html";
        return ob_get_clean();
    }

    /**
     * @param $view
     * @return false|string
     */
    protected function renderOnlyView($view)
    {
        ob_start();
        include_once Application::$ROOT_DIR."/resources/views/$view.knight.html";
        return ob_get_clean();
    } 

}