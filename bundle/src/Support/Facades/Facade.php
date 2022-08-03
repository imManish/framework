<?php

namespace Bundle\Support\Facades;

//use Bundle\Foundation\Application;
use Bundle\Foundation\Application;
use RuntimeException;

abstract class Facade
{
    /**
     * The application instance being facaded.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected static $app;
    

    /**
     * Indicates if the resolved instance should be cached.
     *
     * @var bool
     */
    protected static $cached = true;

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param string $method
     * @param array  $args
     *
     * @throws \RuntimeException
     *
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        static::$app = Application::$app;
        $instance = static::getFacadeRoot();
        if (!$instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return $instance->{$method}(...$args);
    }


    /**
     * Get the registered name of the component.
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        throw new RuntimeException('Facade does not implement getFacadeAccessor method.');
    }
}
