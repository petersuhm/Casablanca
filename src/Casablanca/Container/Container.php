<?php

namespace Casablanca\Container;

interface Container
{
    public function bind($alias, $concrete);
    public function make($alias);
}
