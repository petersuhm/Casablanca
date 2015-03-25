<?php

namespace Casablanca;

use Casablanca\Container\Container;
use ReflectionClass;

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
            return  new $this->aliases[$alias];
        }

        return $this->resolve($alias);
    }

    private function resolve($class)
    {
        $reflection = new ReflectionClass($class);

        $constructor = $reflection->getConstructor();

        if ( ! $constructor) {
            return new $class;
        }

        $params = $constructor->getParameters();

        if (count($params) === 0) {
            return new $class;
        }

        $newInstanceParams = [];

        foreach ($params as $param) {
            // Here we should perform a bunch of checks, such as:
            // isArray(), isCallable(), isDefaultValueAvailable()
            // isOptional() etc.

            if (is_null($param->getClass())) {
                $newInstanceParams[] = null;
                continue;
            }

            $newInstanceParams[] = $this->resolve(
                $param->getClass()->getName()
            );
        }

        return $reflection->newInstanceArgs(
            $newInstanceParams
        );
    }
}
