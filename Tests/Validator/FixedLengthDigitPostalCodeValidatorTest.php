<?php

namespace Markup\AddressingBundle\Tests\Validator;

use Markup\AddressingBundle\Validator\FixedLengthDigitPostalCodeConstraint;
use Markup\AddressingBundle\Validator\FixedLengthDigitPostalCodeValidator;

class FixedLengthDigitPostalCodeValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->validator = new FixedLengthDigitPostalCodeValidator();
        $this->context = $this->getMock('Symfony\Component\Validator\ExecutionContextInterface');
        $this->validator->initialize($this->context);
    }

    public function testIsConstraintValidator()
    {
        $this->assertInstanceOf('Symfony\Component\Validator\ConstraintValidator', $this->validator);
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
