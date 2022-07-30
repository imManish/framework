<?php
namespace App\Core\Traits;

trait PostTrait {

    /**
     * @param $path
     * @param $callback
     * @return void
     */
    public function post($path, $callback)
    {

        $this->routes['post'][$path] = $callback;
    }
}