<?php
namespace App\Core;

class Application
{
    /**
     * @var Router
     */
    public Router $router;

    /**
     * @var Request
     */
    public Request $request;

    /**
     * @var string
     */
    public static string $ROOT_DIR;

    /**
     * @var Response
     */
    public Response $response;

    /**
     * @var Application
     */
    public static Application $app;

    /**
     * @var Controller
     */
    public Controller $controller;

    /**
     * construct and initialize router.
     */
    public function __construct($rootPath) {
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    /**
     * @return void
     */
    public function run() {
        echo $this->router->resolve();
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

}