<?php

namespace Markup\AddressingBundle\Tests\Validator;

use Markup\AddressingBundle\Validator\FixedLengthDigitPostalCodeConstraint;
use Markup\AddressingBundle\Validator\FixedLengthDigitPostalCodeValidator;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class FixedLengthDigitPostalCodeValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->validator = new FixedLengthDigitPostalCodeValidator();
        $this->context = $this->getMock(ExecutionContextInterface::class);
        $this->validator->initialize($this->context);
    }

    public function testIsConstraintValidator()
    {
        $this->assertInstanceOf(ConstraintValidator::class, $this->validator);
    }

    public function testValidationWithoutLengthThrowsLogicException()
    {
        $this->setExpectedException('LogicException');
        $value = '12345';
        $constraint = new FixedLengthDigitPostalCodeConstraint();
        $this->validator->validate($value, $constraint);
    }

    public function testValidatorForFourDigitCodePasses()
    {
        $code = '1234';
        $constraint = new FixedLengthDigitPostalCodeConstraint();
        $constraint->length = 4;
        $this->context
            ->expects($this->never())
            ->method('addViolation');
        $this->validator->validate($code, $constraint);
    }

    public function testValidatorForFourDigitCodeFailsAgainstFive()
    {
        $code = '1234';
        $constraint = new FixedLengthDigitPostalCodeConstraint();
        $constraint->length = 5;
        $this->context
            ->expects($this->once())
            ->method('addViolation');
        $this->validator->validate($code, $constraint);
    }
}
