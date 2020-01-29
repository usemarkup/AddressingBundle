<?php

namespace Markup\AddressingBundle\Tests\Checker;

use Markup\AddressingBundle\Checker\AddressUnderCheck;
use Markup\AddressingBundle\Checker\PostalCodeChecker;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostalCodeCheckerTest extends MockeryTestCase
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var PostalCodeChecker
     */
    private $checker;

    protected function setUp()
    {
        $this->validator = m::mock(ValidatorInterface::class);
        $this->checker = new PostalCodeChecker($this->validator);
    }

    public function testPostalCodeCheckerTrueIfValidates()
    {
        $emptyViolationList = new ConstraintViolationList();
        $this->validator
            ->shouldReceive('validate')
            ->with(m::type(AddressUnderCheck::class))
            ->once()
            ->andReturn($emptyViolationList);
        $this->assertTrue($this->checker->check('sw1a1aa', 'GB'));
    }

    public function testPostalCodeCheckerFalseIfDoesNotValidate()
    {
        $nonEmptyViolationList = new ConstraintViolationList([m::mock(ConstraintViolationInterface::class)]);
        $this->validator
            ->shouldReceive('validate')
            ->with(m::type(AddressUnderCheck::class))
            ->once()
            ->andReturn($nonEmptyViolationList);
        $this->assertFalse($this->checker->check('123456', 'SE'));
    }
}
