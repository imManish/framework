<?php

namespace App\Core\Routing\Traits;

trait GetTrait
{
    /**
     * @param $path
     * @param $callback
     * @return void
     */
    public function get($path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }
}
