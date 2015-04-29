<?php

namespace Casablanca;

use Casablanca\Container\Container;
use Casablanca\Container\ServiceProvider;
use ReflectionClass;

/**
 * The Casablanca service container. Extend this class from your
 * WordPress package.
 *
 * @package Casablanca
 */
class Casablanca implements Container
{
    /**
     * Service aliases for the Casablanca container.
     *
     * @var array
     */
    private $aliases = array();

    /**
     * Add a WordPress action. If $handler is the name of a class that
     * implements ActionHandler, the $handler will be resolved out of
     * the IoC container.
     *
     * @param $tag
     * @param $handler
     * @param int $priority
     * @param int $acceptedArgs
     * @return array|bool|void
     */
    public function addAction($tag, $handler, $priority = 10, $acceptedArgs = 1)
    {
        if (array_key_exists('Casablanca\Actions\ActionHandler', class_implements($handler))) {
            return add_action($tag, array($this->make($handler), 'handle'), $priority, $acceptedArgs);
        }

        return add_action($tag, $handler, $priority, $acceptedArgs);
    }

    /**
     * Bind a class name, a class instance or an anonymous function
     * to the Casablanca service container.
     *
     * @param $alias
     * @param $concrete
     */
    public function bind($alias, $concrete)
    {
        $this->aliases[$alias] = $concrete;
    }

    /**
     * Retrieve a service from the container. Dependencies will be
     * resolved in a recursive manner.
     *
     * @param $alias
     * @return mixed|object
     */
    public function make($alias)
    {
        if (isset($this->aliases[$alias]) and is_callable($this->aliases[$alias])) {
            return call_user_func($this->aliases[$alias]);
        }

        if (isset($this->aliases[$alias]) and is_object($this->aliases[$alias])) {
            return $this->aliases[$alias];
        }

        if (isset($this->aliases[$alias]) and class_exists($this->aliases[$alias])) {
            return $this->resolve($this->aliases[$alias]);
        }

        return $this->resolve($alias);
    }

    /**
     * Register a service provider for the container.
     *
     * @param ServiceProvider $provider
     */
    public function register(ServiceProvider $provider)
    {
        $provider->register($this);
    }

    /**
     * @param $class
     * @return object
     */
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

        $newInstanceParams = array();

        foreach ($params as $param) {
            // @todo Here we should probably perform a bunch of checks, such as:
            // isArray(), isCallable(), isDefaultValueAvailable()
            // isOptional() etc.

            if (is_null($param->getClass())) {
                $newInstanceParams[] = null;
                continue;
            }

            $newInstanceParams[] = $this->make(
                $param->getClass()->getName()
            );
        }

        return $reflection->newInstanceArgs(
            $newInstanceParams
        );
    }
}
