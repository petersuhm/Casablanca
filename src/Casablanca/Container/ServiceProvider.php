<?php

namespace Casablanca\Container;

use Casablanca\Casablanca;

interface ServiceProvider
{
    public function register(Casablanca $container);
}
