<?php
namespace App\Core;
use App\Core\Traits\GetTrait;
use App\Core\Traits\PostTrait;

class Router
{
    use GetTrait, PostTrait;

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
     * @return array|false|mixed|string|string[]
     */
    public function resolve()
    {

        $path = $this->request->getPath();
        $this->method = $this->request->method();
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
        return call_user_func($this->isCheck($callback), $this->request);
    }

    /**
     * @param $view
     * @return array|false|string|string[]
     */
    public function renderView($view, array $params = [])
    {

        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);

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
    protected function renderOnlyView($view, $params)
    {
        foreach($params as $key => $value)
            $$key = $value;
        //var_dump($name);

        ob_start();
        include_once Application::$ROOT_DIR."/resources/views/$view.knight.html";
        return ob_get_clean();
    }

    /**
     * @param $callback
     * @return mixed
     */
    private function isCheck($callback)
    {
        if(is_array($callback))
            $callback[0] = new $callback[0];

        return $callback;
    }

}