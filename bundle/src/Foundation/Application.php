<?php

namespace Bundle\Foundation;

use Bundle\Database\Connection;
use Bundle\Http\Request;
use Bundle\Http\Response;
use Bundle\Routing\Controller;
use Bundle\Routing\Router;

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
     * @var string
     */
    public string $layout = '_base';

    /**
     * @var Connection
     */
    public Connection $connection;


    /**
     * construct and initialize router.
     */
    public function __construct($rootPath,array $config)
    {
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->connection = new Connection($config['DB']);
    }


    /**
     * The `run()` function is the entry point of the application.
     * It calls the `resolve()` function of the `Router` class,
     * which is responsible for resolving the request
     */
    public function run(): void
    {
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
