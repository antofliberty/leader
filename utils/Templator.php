<?php

namespace Leader\Utils;

class Templator
{
    public function render(string $path, array $params = []) {
        if ($params) {
            extract($params);
        }
        include $path;
    }

    public function jsonResponse(array $params = []) {
        echo json_encode($params);
    }
}