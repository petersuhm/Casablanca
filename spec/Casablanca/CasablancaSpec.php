<?php

namespace spec\Casablanca;

use Casablanca\Actions\ActionHandler;
use Casablanca\Container\ServiceProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use stdClass;

require __DIR__ . '/../stubs.php';

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

    function it_can_fetch_constructor_dependencies_from_bindings()
    {
        $concrete = new stdClass;
        $this->bind('stdClass', $concrete);

        $this->make('spec\Casablanca\PostsRepository')->getObject()->shouldBe($concrete);
    }

    function it_can_add_a_normal_wordpress_action()
    {
        $var = 'var';
        $callback = function() use ($var) {};
        $this->addAction('init', $callback, 9, 2)
            ->shouldReturn(array('init', $callback, 9, 2));
    }

    function it_can_resolve_an_action_handler_from_the_container()
    {
        $this->addAction('init', 'spec\Casablanca\SomeActionHandler', 8, 2)
            ->shouldBeLike(array('init', array($this->make('spec\Casablanca\SomeActionHandler'), 'handle'), 8, 2));
    }
}

class PostsRepository
{
    private $object;
    public function __construct(stdClass $object)
    {
        $this->object = $object;
    }

    public function getObject()
    {
        return $this->object;
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

class SomeActionHandler implements ActionHandler
{
    public function handle()
    {
        //
    }
}
