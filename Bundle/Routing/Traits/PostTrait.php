<?php

namespace App\Core\Routing\Traits;

trait PostTrait
{
    /**
     * @param $path
     * @param $callback
     * @return void
     */
    public function post($path, $callback): void
    {

        $this->routes['post'][$path] = $callback;
    }
}
