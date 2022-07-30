<?php

namespace App\Core;

class Request
{

    public array $body = [];


    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path,'?');
        return ($position === false) ? $path : substr($path,0, $position);
    }

    public function method()
    {
        //var_dump(__METHOD__);
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function all()
    {
        if($this->method() === 'get')
            foreach($_GET as $key => $value)
                $this->body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);

        if($this->method() === 'post')
            foreach($_POST as $key => $value)
                $this->body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);

        //var_dump($this->body);
        return $this->body;
    }
}