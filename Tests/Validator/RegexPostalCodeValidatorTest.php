<?php

namespace Markup\AddressingBundle\Tests\Validator;

use Markup\AddressingBundle\Validator\PostalCodeConstraint;
use Markup\AddressingBundle\Validator\RegexPostalCodeValidator;

/**
* A test for a validator for postal codes.
*/
class RegexPostalCodeValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->regexValidator = $this->getMock('Symfony\Component\Validator\ConstraintValidatorInterface');
        $this->notBlankValidator = $this->getMock('Symfony\Component\Validator\ConstraintValidatorInterface');
        $this->validator = new RegexPostalCodeValidator($this->regexValidator, $this->notBlankValidator);
    }

    public function testIsConstraintValidator()
    {
        $this->assertInstanceOf('Symfony\Component\Validator\ConstraintValidatorInterface', $this->validator);
    }

    public function testValidateInitializesAndDelegatesOnValidators()
    {
        $constraint = new PostalCodeConstraint();
        $constraint->message = 'message';
        $context = $this->getMock('Symfony\Component\Validator\ExecutionContextInterface');
        $value = 'i am a value';
        $this->regexValidator
            ->expects($this->at(0))
            ->method('initialize')
            ->with($this->equalTo($context));
        $this->regexValidator
            ->expects($this->at(1))
            ->method('validate')
            ->with($this->equalTo($value), $this->isInstanceOf('Symfony\Component\Validator\Constraint'));
        $this->notBlankValidator
            ->expects($this->at(0))
            ->method('initialize')
            ->with($this->equalTo($context));
        $this->notBlankValidator
            ->expects($this->at(1))
            ->method('validate')
            ->with($this->equalTo($value), $this->isInstanceOf('Symfony\Component\Validator\Constraint'));
        $this->validator->initialize($context);
        $this->validator->validate($value, $constraint);
    }
}
