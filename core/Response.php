<?php

namespace App\Core;

class Response
{
    /**
     * @param $code
     * @return bool|int
     */
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }
}