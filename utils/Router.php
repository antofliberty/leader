<?php
namespace Leader\Utils;

class Router {

    private array $routes;
    private string $path;
    private string $requestMethod;
    private array $availableMethods;
    private string $projectNamespace;

    public function __construct(array $routes, string $projectNamespace)
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $this->path = parse_url($url, PHP_URL_PATH);
        $this->path = substr($this->path, 1);
        $this->routes = $routes;
        $this->projectNamespace = $projectNamespace;
    }

    public function run()
    {
        if (isset($this->routes[$this->path])) {
            $this->setAvailableRoutes();
            $fileName = $this->getControllerFileName();

            if (file_exists($fileName)) {
                $this->loadController();
            } else {
                throw new \Error("Controller cannot be loaded because file $fileName does not exist");
            }

        } elseif ($this->path == '') {
            $this->path = "index";
            $this->setAvailableRoutes();
            $this->loadController();
        } else {
            include '../pages/404.php';
        }
    }

    private function loadController()
    {
        $class = "\\" . $this->projectNamespace . "\Controllers\\" . ucfirst($this->path) . 'Controller';
        $controller = new $class($this->requestMethod, $this->availableMethods);
        $controller->run();
    }

    private function getControllerFileName(): string
    {
        return ROOT_DIR . '/controllers/' . ucfirst($this->path) . 'Controller.php';
    }

    private function setAvailableRoutes()
    {
        $this->availableMethods = $this->routes[$this->path];
    }
}
