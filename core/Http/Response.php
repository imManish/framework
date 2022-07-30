<?php

namespace App\Core\Http;

// A class that is used to set the status code of the response.
class Response
{
    /**
     * @param int $code
     * @return bool|int
     */
    public function setStatusCode(int $code): bool|int
    {
        return http_response_code($code);
    }
}
