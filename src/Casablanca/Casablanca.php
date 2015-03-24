<?php

namespace Casablanca;

use Casablanca\Container\Container;

class Casablanca implements Container
{
    private $aliases = array();

    public function bind($alias, $concrete)
    {
        $this->aliases[$alias] = $concrete;
    }

    public function make($alias)
    {
        if (isset($this->aliases[$alias]) and is_callable($this->aliases[$alias])) {
            return call_user_func($this->aliases[$alias]);
        }

        if (isset($this->aliases[$alias]) and is_object($this->aliases[$alias])) {
            return new $this->aliases[$alias];
        }

        if (isset($this->aliases[$alias]) and class_exists($this->aliases[$alias])) {
            return new $this->aliases[$alias];
        }
    }
}
