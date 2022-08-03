<?php

namespace Bundle\Foundation;

// use Illuminate\Container\EntryNotFoundException;
// use Illuminate\Contracts\Container\CircularDependencyException;
use ArrayAccess;
use Bundle\Container\EntryNotFoundException;
use Bundle\Contracts\Container\CircularDependencyException;
use Bundle\Contracts\Container\Container as ContainerContract;
use Illuminate\Contracts\Container\BindingResolutionException;

class Container
{
    public static Application $app;

}
