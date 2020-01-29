<?php

namespace Markup\AddressingBundle\Tests\Validator;

use Markup\AddressingBundle\Validator\PostalCodeConstraint;
use Markup\AddressingBundle\Validator\RegexPostalCodeValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
* A test for a validator for postal codes.
*/
class RegexPostalCodeValidatorTest extends TestCase
{
    protected function setUp()
    {
        $this->regexValidator = $this->createMock(ConstraintValidatorInterface::class);
        $this->notBlankValidator = $this->createMock(ConstraintValidatorInterface::class);
        $this->validator = new RegexPostalCodeValidator($this->regexValidator, $this->notBlankValidator);
    }

    public function testIsConstraintValidator()
    {
        $this->assertInstanceOf(ConstraintValidatorInterface::class, $this->validator);
    }

    public function testValidateInitializesAndDelegatesOnValidators()
    {
        $constraint = new PostalCodeConstraint();
        $constraint->message = 'message';
        $context = $this->createMock(ExecutionContextInterface::class);
        $value = 'i am a value';
        $this->regexValidator
            ->expects($this->at(0))
            ->method('initialize')
            ->with($this->equalTo($context));
        $this->regexValidator
            ->expects($this->at(1))
            ->method('validate')
            ->with($this->equalTo($value), $this->isInstanceOf(Constraint::class));
        $this->notBlankValidator
            ->expects($this->at(0))
            ->method('initialize')
            ->with($this->equalTo($context));
        $this->notBlankValidator
            ->expects($this->at(1))
            ->method('validate')
            ->with($this->equalTo($value), $this->isInstanceOf(Constraint::class));
        $this->validator->initialize($context);
        $this->validator->validate($value, $constraint);
    }
}
