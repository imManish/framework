<?php
namespace app\core;

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

    public Response $response;

    public static Application $app;


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
        return $this->router->resolve();
    }

}