<?php

namespace Bundle\Http;

class Request
{
    // Declaring a property of the class.
    public array $body = [];

    /**
     * It returns the path of the request.
     *
     * @return mixed the path of the request
     */
    public function getPath(): mixed
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');

        return (false === $position) ? $path : substr($path, 0, $position);
    }

    /**
     * > This function returns the request method as a string.
     *
     * @return string the method of the request
     */
    public function method(): string
    {
        // var_dump(__METHOD__);
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * If the request method is GET, then loop through the $_GET array and assign the key and value to the $this->body
     * array.
     *
     * @return array an array of the body of the request
     */
    public function all(): array
    {
        if ('get' === $this->method()) {
            foreach ($_GET as $key => $value) {
                $this->body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ('post' === $this->method()) {
            foreach ($_POST as $key => $value) {
                $this->body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        // var_dump($this->body);
        return $this->body;
    }
}
