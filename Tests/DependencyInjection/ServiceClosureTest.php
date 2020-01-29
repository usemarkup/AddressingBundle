<?php

namespace Markup\AddressingBundle\Tests\DependencyInjection;

use Markup\AddressingBundle\DependencyInjection\ServiceClosure;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A test for a callable object that returns a service (lazily fetched).
 */
class ServiceClosureTest extends MockeryTestCase
{
    /**
     * @var string
     */
    private $serviceId;

    /**
     * @var ContainerInterface|m\MockInterface
     */
    private $container;

    /**
     * @var ServiceClosure
     */
    private $closure;

    protected function setUp()
    {
        $this->serviceId = 'yay_service';
        $this->container = m::mock(ContainerInterface::class);
        $this->closure = new ServiceClosure($this->serviceId, $this->container);
    }

    public function testIsCallable()
    {
        $this->assertTrue(is_callable($this->closure));
    }

    public function testServiceFetched()
    {
        $service = function () { return false; };
        $this->container
            ->shouldReceive('get')
            ->with($this->serviceId)
            ->andReturn($service);
        $closure = $this->closure;
        $this->assertSame($service, $closure());
    }

    public function testNullReturnedWhenServiceNotAccessible()
    {
        $exception = new \Symfony\Component\DependencyInjection\Exception\RuntimeException();
        $this->container
            ->shouldReceive('get')
            ->with($this->serviceId)
            ->andThrow($exception);
        $closure = $this->closure;
        $this->assertNull($closure());
    }
}
