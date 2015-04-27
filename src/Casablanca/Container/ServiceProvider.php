<?php

namespace Casablanca\Container;

use Casablanca\Casablanca;

interface ServiceProvider
{
    /**
     * Bind services to container through a service provider.
     *
     * @param Casablanca $container
     * @return mixed
     */
    public function register(Casablanca $container);
}
