<?php

namespace Leader\Core;

abstract class Controller
{
    private string $name;
    private string $currentMethod = "GET";
    private array $methods;

    public function __construct(string $name, string $currentMethod = "GET", array $methods = [])
    {
        $this->currentMethod = $currentMethod;
        $this->methods = $methods;

        foreach ($methods as $method) {
            if (!method_exists($this, $method)) {
                throw new \Error("Method $method is not implemented in " . get_class($this));
            }
        }
        $this->name = $name;
    }

    public function run()
    {
        if (in_array($this->currentMethod, $this->methods)) {
            $this->{$this->currentMethod}();
        } else {
            http_response_code(404);
            include('../pages/404.php');
        }
    }

    public function getPageFilePath (string $name = ""): string
    {
        $pageName = $name ?: $this->name;
        return ROOT_DIR . '/pages/' . $pageName . '.php';
    }

    protected function loadModelFromPostOrGetRequest(string $class)
    {
        if($this->currentMethod != 'POST' && $this->currentMethod != 'GET') {
            throw new \Error("This method supports only POST and GET method.");
        }

        $requestData = $this->currentMethod == "POST" ? $_POST : $_GET;
        $keys = call_user_func($class . "::getKeys");


        $dataToLoad = [];

        foreach ($keys as $key) {
            if (isset($requestData[$key]) && !empty($requestData[$key])) {
                $dataToLoad[$key] = $requestData[$key];
            } else {
                $dataToLoad[$key] = "";
            }
        }

        return new $class(...$dataToLoad);
    }

}
