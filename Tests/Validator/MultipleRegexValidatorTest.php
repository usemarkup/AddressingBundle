<?php

namespace Markup\AddressingBundle\Tests\Validator;

use Markup\AddressingBundle\Validator\MultipleRegexConstraint;
use Markup\AddressingBundle\Validator\MultipleRegexValidator;
use Mockery as m;

class MultipleRegexValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->validator = new MultipleRegexValidator();
        $this->context = m::mock('Symfony\Component\Validator\ExecutionContextInterface');
        $this->validator->initialize($this->context);
    }

    protected function tearDown()
    {
        m::close();
    }

    public function testIsConstraintValidator()
    {
        $this->assertInstanceOf('Symfony\Component\Validator\ConstraintValidatorInterface', $this->validator);
    }

    public function testPassingPostalCode()
    {
        $postalCode = '123-456';
        $patterns = ['/^\d{3}\-\d{3}$/', '/^\d{5}$/'];
        $constraint = new MultipleRegexConstraint();
        $constraint->patterns = $patterns;
        $this->context
            ->shouldReceive('addViolation')
            ->never();
        $this->validator->validate($postalCode, $constraint);
    }

    public function testFailingPostalCode()
    {
        $postalCode = '123';
        $patterns = ['/^[A-Z]{4}$/'];
        $constraint = new MultipleRegexConstraint();
        $constraint->patterns = $patterns;
        $this->context
            ->shouldReceive('addViolation')
            ->once();
        $this->validator->validate($postalCode, $constraint);
    }
}
