<?php

namespace spec\Casablanca;

use Casablanca\Container\ServiceProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use stdClass;

class CasablancaSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Casablanca\Casablanca');
        $this->shouldBeAnInstanceOf('Casablanca\Container\Container');
    }

    function it_can_bind_a_concrete_implementation()
    {
        $this->bind('SomeInterface', 'StdClass');
        $this->make('SomeInterface')->shouldBeAnInstanceOf('StdClass');
    }

    function it_can_bind_a_closure()
    {
        $this->bind('SomeInterface', function()
        {
            return new StdClass;
        });
        $this->make('SomeInterface')->shouldBeAnInstanceOf('StdClass');
    }

    function it_can_bind_an_object_instance()
    {
        $this->bind('SomeInterface', new StdClass);
        $this->make('SomeInterface')->shouldBeAnInstanceOf('StdClass');
    }

    function it_can_resolve_constructor_dependencies()
    {
        $this
            ->make('spec\Casablanca\PostsRepository')
            ->shouldHaveType('spec\Casablanca\PostsRepository');
    }

    function it_can_reflect_on_constructor_dependencies_recursively()
    {
        $this
            ->make('spec\Casablanca\PostServiceThing')
            ->shouldHaveType('spec\Casablanca\PostServiceThing');
    }

    function it_can_register_service_providers(ServiceProvider $provider)
    {
        $provider->register($this)->shouldBeCalled();
        $this->register($provider);
    }
}

class PostsRepository
{
    private $object;
    public function __construct(StdClass $object)
    {
        $this->object = $object;
    }
}

class PostServiceThing
{
    private $posts;
    public function __construct(PostsRepository $posts)
    {
        $this->posts = $posts;
    }
}
