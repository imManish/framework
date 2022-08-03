<?php

namespace Bundle\Container;

use Psr\Container\NotFoundExceptionInterface;
use Exception;

class EntryNotFoundException extends Exception implements NotFoundExceptionInterface
{

}