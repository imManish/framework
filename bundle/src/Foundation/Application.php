<?php

namespace Bundle\Foundation;

use Bundle\Contracts\Foundation\Application as ApplicationContract;
use Bundle\Database\Connection;
use Bundle\Http\Request;
use Bundle\Http\Response;
use Bundle\Routing\Controller;
use Bundle\Routing\Router;

class Application extends Container
{

    public const VERSION = '1.0.0';

    public Router $router;

    public Request $request;

    public static string $ROOT_DIR;

    public Response $response;

    public Controller $controller;

    public string $layout = '_base';

    public Connection $connection;

    /**
     * construct and initialize router.
     *
     * @param mixed $rootPath
     */
    public function __construct($rootPath, array $config)
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
     * which is responsible for resolving the request.
     */
    public function run(): void
    {
        echo $this->router->resolve();
    }

    /**
     * > This function returns the controller.
     *
     * @return Controller the controller object
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * > This function sets the controller property to the controller object passed in.
     *
     * @param Controller controller The controller that is being called
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version()
    {

    }
}
