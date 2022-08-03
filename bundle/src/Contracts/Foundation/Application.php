<?php

namespace Bundle\Contracts\Foundation;

use Bundle\Contracts\Container\Container;

interface Application extends Container
{
    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version();

}
